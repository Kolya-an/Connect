<?php

namespace App\Http\Controllers;

use App\Models\PhotoConsent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiiaWebhookController extends Controller
{
    public function handle(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Фіксуємо факт отримання webhook від Дії
        |--------------------------------------------------------------------------
        */

        Log::info('DIIA WEBHOOK HIT', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'body_keys' => array_keys($request->all()),
            'headers' => [
                'x-document-request-trace-id' =>
                    $request->header('x-document-request-trace-id'),

                'x-diia-id-action' =>
                    $request->header('x-diia-id-action'),

                'content-type' =>
                    $request->header('content-type'),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Отримуємо requestId
        |--------------------------------------------------------------------------
        */

        $requestId =
            $request->header('x-document-request-trace-id')
            ?? $request->input('requestId')
            ?? $request->input('token');

        Log::info('DIIA WEBHOOK REQUEST ID DEBUG', [
            'requestId' => $requestId,
        ]);

        if (!$requestId) {
            Log::error('DIIA WEBHOOK: requestId not found');

            return response()->json([
                'status' => 'missing_request_id',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Перевіряємо тип webhook
        |--------------------------------------------------------------------------
        */

        $action = $request->header('x-diia-id-action');

        if ($action !== 'hashedFilesSigning') {
            Log::warning('DIIA WEBHOOK: unexpected action', [
                'action' => $action,
                'requestId' => $requestId,
            ]);

            return response()->json([
                'status' => 'unsupported_action',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Знаходимо PhotoConsent
        |--------------------------------------------------------------------------
        */

        $consentBySession = PhotoConsent::where(
            'diia_session_id',
            $requestId
        )->first();

        $consentByToken = PhotoConsent::where(
            'token',
            $requestId
        )->first();

        Log::info('DIIA WEBHOOK CONSENT DEBUG', [
            'requestId' => $requestId,

            'consent_by_diia_session_id' =>
                $consentBySession?->id,

            'consent_by_token' =>
                $consentByToken?->id,

            'session_value' =>
                $consentBySession?->diia_session_id,

            'token_value' =>
                $consentByToken?->token,
        ]);

        $consent = $consentBySession ?? $consentByToken;

        if (!$consent) {
            Log::error('DIIA WEBHOOK: consent not found', [
                'requestId' => $requestId,
            ]);

            return response()->json([
                'status' => 'not_found',
            ], 404);
        }

        $consent->load([
            'doctorPhoto',
            'userSignature',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5. Перевіряємо скасування
        |--------------------------------------------------------------------------
        */

        if (
            $request->has('cancel')
            || in_array(
                $request->input('status'),
                [
                    'cancelled',
                    'declined',
                    'REJECTED',
                ],
                true
            )
        ) {
            $consent->update([
                'status' => 'declined',
            ]);

            Log::info('DIIA SIGNING DECLINED', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
            ]);

            return response()->json([
                'status' => 'declined',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Ідемпотентність
        |--------------------------------------------------------------------------
        */

        if ($consent->status === 'signed') {
            Log::info('DIIA WEBHOOK: consent already signed', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
            ]);

            return response()->json([
                'status' => 'ok',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Перевіряємо оригінальний PDF
        |--------------------------------------------------------------------------
        |
        | Це той самий PDF, який був створений ДО відправки hash
        | у Дію.
        |
        | Повторно PDF НЕ генеруємо.
        |
        */

        $pdfPath = $consent->pdf_path;

        $fullPdfPath = $pdfPath
            ? public_path($pdfPath)
            : null;

        if (
            !$pdfPath
            || !$fullPdfPath
            || !file_exists($fullPdfPath)
            || filesize($fullPdfPath) === 0
        ) {
            Log::error('DIIA WEBHOOK: original PDF not found', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
                'pdf_path' => $pdfPath,
                'full_pdf_path' => $fullPdfPath,
            ]);

            return response()->json([
                'status' => 'pdf_not_found',
            ], 500);
        }

        /*
        |--------------------------------------------------------------------------
        | 8. Обробляємо результат підписання
        |--------------------------------------------------------------------------
        */

        try {
            /*
            |--------------------------------------------------------------------------
            | 8.1. Отримуємо encodeData
            |--------------------------------------------------------------------------
            */

            $encodeData = $request->input('encodeData');

            if (!$encodeData) {
                Log::error('DIIA WEBHOOK: encodeData відсутній', [
                    'consent_id' => $consent->id,
                    'requestId' => $requestId,
                ]);

                return response()->json([
                    'status' => 'missing_encode_data',
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | 8.2. Base64 decode
            |--------------------------------------------------------------------------
            */

            $decodedJson = base64_decode(
                $encodeData,
                true
            );

            if ($decodedJson === false) {
                Log::error(
                    'DIIA WEBHOOK: не вдалося Base64-декодувати encodeData',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                    ]
                );

                return response()->json([
                    'status' => 'invalid_encode_data',
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | 8.3. JSON decode
            |--------------------------------------------------------------------------
            */

            $signData = json_decode(
                $decodedJson,
                true
            );

            if (!is_array($signData)) {
                Log::error(
                    'DIIA WEBHOOK: encodeData містить некоректний JSON',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                        'json_error' => json_last_error_msg(),
                    ]
                );

                return response()->json([
                    'status' => 'invalid_encode_data_json',
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | 8.4. Отримуємо signedItems
            |--------------------------------------------------------------------------
            */

            $signedItems = $signData['signedItems'] ?? [];

            if (
                !is_array($signedItems)
                || empty($signedItems)
            ) {
                Log::error(
                    'DIIA WEBHOOK: signedItems порожній або відсутній',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                    ]
                );

                return response()->json([
                    'status' => 'empty_signed_items',
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | 8.5. Беремо перший підписаний файл
            |--------------------------------------------------------------------------
            */

            $signedItem = $signedItems[0];

            $fileName = $signedItem['name'] ?? null;

            $signature = $signedItem['signature'] ?? null;

            if (!$fileName || !$signature) {
                Log::error(
                    'DIIA WEBHOOK: signedItem не містить name або signature',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                    ]
                );

                return response()->json([
                    'status' => 'invalid_signed_item',
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | 8.6. Перевіряємо ім'я підписаного файлу
            |--------------------------------------------------------------------------
            */

            $expectedFileName =
                "Zgoda_na_pidpys_{$consent->id}.pdf";

            if ($fileName !== $expectedFileName) {
                Log::error(
                    'DIIA WEBHOOK: unexpected signed file name',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                        'expected' => $expectedFileName,
                        'received' => $fileName,
                    ]
                );

                return response()->json([
                    'status' => 'invalid_file_name',
                ], 400);
            }

            /*
            |--------------------------------------------------------------------------
            | 8.7. Debug підпису
            |--------------------------------------------------------------------------
            |
            | Повний signature НЕ логуємо.
            |
            */

            Log::info('DIIA SIGNED ITEM DEBUG', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
                'fileName' => $fileName,
                'signature_length' => strlen($signature),
                'signature_prefix' => substr(
                    $signature,
                    0,
                    30
                ),
            ]);

            /*
            |--------------------------------------------------------------------------
            | 8.8. Інформація про підписанта
            |--------------------------------------------------------------------------
            */

            $signerInfo = [
                'name' => 'Підписано через Дія.Підпис',
                'drfo' => '',
                'signed_at' => now()->toDateTimeString(),
            ];

            /*
            |--------------------------------------------------------------------------
            | 8.9. Зберігаємо результат підписання
            |--------------------------------------------------------------------------
            |
            | ВАЖЛИВО:
            |
            | $pdfPath — це оригінальний PDF,
            | створений ДО підписання.
            |
            | Новий PDF тут НЕ генерується.
            |
            */

            DB::transaction(function () use (
                $consent,
                $signerInfo,
                $signData,
                $pdfPath,
                $fileName,
                $signature
            ) {
                $consent->update([
                    'status' => 'signed',
                    'signed_at' => now(),
                    'signer_info' => $signerInfo,
                    'pdf_path' => $pdfPath,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Зберігаємо signature
                |--------------------------------------------------------------------------
                */

                if ($consent->userSignature) {
                    $consent->userSignature->update([
                        'status' => 'signed',
                        'signed_at' => now(),

                        'signature_data' => [
                            'fileName' => $fileName,
                            'signature' => $signature,
                            'signedItems' =>
                                $signData['signedItems'] ?? [],
                        ],

                        'pdf_path' => $pdfPath,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Активуємо фото лікаря
                |--------------------------------------------------------------------------
                */

                if ($consent->doctorPhoto) {
                    $consent->doctorPhoto->update([
                        'is_active' => true,
                    ]);
                }
            });

            /*
            |--------------------------------------------------------------------------
            | 9. Успішне завершення webhook
            |--------------------------------------------------------------------------
            */

            Log::info('DIIA SIGNING SUCCESS', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
                'fileName' => $fileName,
                'pdf_path' => $pdfPath,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Повертаємо HTTP 204 No Content
            |--------------------------------------------------------------------------
            */

            $response = response()->noContent();

            Log::info('DIIA WEBHOOK RESPONSE', [
                'requestId' => $requestId,
                'status' => $response->getStatusCode(),
                'headers' => $response->headers->all(),
                'content_length' => strlen($response->getContent()),
            ]);

            return $response;

        } catch (\Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | 10. Помилка обробки webhook
            |--------------------------------------------------------------------------
            */

            Log::error(
                'Diia Callback/Webhook Error ' .
                "[Token/ID: {$requestId}]: " .
                $e->getMessage(),
                [
                    'consent_id' => $consent->id ?? null,
                    'exception' => get_class($e),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process signature result',
            ], 500);
        }
    }
}