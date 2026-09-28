<?php

namespace App\Http\Controllers;

use App\Models\PhotoConsent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DiiaWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $requestId = $request->header('x-document-request-trace-id')
            ?? $request->input('requestId')
            ?? $request->input('token');

        $action = $request->header('x-diia-id-action')
            ?? $request->input('action');

        Log::info('DIIA WEBHOOK HIT', [
            'requestId' => $requestId,
            'action' => $action,
        ]);

        if ($action !== 'hashedFilesSigning') {
            Log::warning('DIIA WEBHOOK: unsupported action', [
                'requestId' => $requestId,
                'action' => $action,
            ]);

            return response()->json([
                'status' => 'unsupported_action',
            ], 400);
        }

        $diiaData = Cache::get('diia_consent:' . $requestId);

        if (!$diiaData || !is_array($diiaData)) {
            Log::error('DIIA WEBHOOK: session data not found', [
                'requestId' => $requestId,
            ]);

            return response()->json([
                'status' => 'session_not_found',
            ], 404);
        }

        $consentId = $diiaData['consent_id'] ?? null;

        if (!$consentId) {
            Log::error(
                'DIIA WEBHOOK: consent_id missing from session data',
                [
                    'requestId' => $requestId,
                ]
            );

            return response()->json([
                'status' => 'consent_id_missing',
            ], 400);
        }

        $consent = PhotoConsent::find($consentId);

        if (!$consent) {
            Log::error('DIIA WEBHOOK: consent not found', [
                'requestId' => $requestId,
                'consent_id' => $consentId,
            ]);

            return response()->json([
                'status' => 'not_found',
            ], 404);
        }

        /*
         * Користувач скасував або відхилив підпис.
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

            $temporaryPdfPath =
                $diiaData['temporary_pdf_path'] ?? null;

            if (
                $temporaryPdfPath
                && Storage::disk('local')->exists($temporaryPdfPath)
            ) {
                Storage::disk('local')->delete($temporaryPdfPath);
            }

            Cache::forget('diia_consent:' . $requestId);

            Log::info('DIIA SIGNING DECLINED', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
            ]);

            return response()->json([
                'status' => 'declined',
            ], 200);
        }

        /*
         * Захист від повторного webhook.
         */
        if ($consent->status === 'signed') {
            Log::info('DIIA WEBHOOK: consent already signed', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
            ]);

            return response()->json([
                'success' => true,
            ], 200);
        }

        try {
            $temporaryPdfPath =
                $diiaData['temporary_pdf_path'] ?? null;

            if (
                !$temporaryPdfPath
                || !Storage::disk('local')->exists($temporaryPdfPath)
            ) {
                Log::error(
                    'DIIA WEBHOOK: temporary PDF not found',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                    ]
                );

                return response()->json([
                    'status' => 'pdf_not_found',
                ], 500);
            }

            /*
             * Отримуємо результат підписання.
             */
            $encodeData = $request->input('encodeData');

            if (!$encodeData) {
                Log::error(
                    'DIIA WEBHOOK: encodeData відсутній',
                    [
                        'consent_id' => $consent->id,
                        'requestId' => $requestId,
                    ]
                );

                return response()->json([
                    'status' => 'missing_encode_data',
                ], 400);
            }

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
             * Перевіряємо, що Дія повернула саме наш PDF.
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
             * 1. Отримуємо інформацію про підписувача з X.509 сертифіката.
             */
            $signerInfo = $this->extractDiiaSignerInfo(
                $signature
            );

            /*
             * 2. ГЕНЕРУЄМО ФІНАЛЬНИЙ PDF з реальними даними підписувача
             */
            $photoBase64 = $diiaData['photo_base64'] ?? null;

            $consent->load(['doctor', 'doctorPhoto']);
            $doctor = $consent->doctor ?? $consent->doctorPhoto?->doctor;

            $finalPdf = Pdf::loadView('pdf.photo-consent', [
                'consent' => $consent,
                'doctor' => $doctor, // <--- Передаємо об'єкт або масив з даними лікаря
                'photoBase64' => $photoBase64,
                'signerInfo' => [
                    'name' => $signerInfo['name'],
                    'drfo' => $signerInfo['drfo'],
                    'signed_at' => $signerInfo['signed_at'],
                ],
            ]);

            $pdfBytes = $finalPdf->output();

            /*
             * 3. Формуємо шляхи збереження
             */
            $pdfPath = 'consents/consent_' . $consent->token . '.pdf';
            $p7sPath = 'consents/consent_' . $consent->token . '.pdf.p7s';

            /*
             * 4. Зберігаємо новий PDF та p7s контейнер у public disk
             */
            if (!Storage::disk('public')->put($pdfPath, $pdfBytes)) {
                throw new \RuntimeException(
                    "Не вдалося зберегти фінальний PDF: {$pdfPath}"
                );
            }

            // Зберігаємо бінарний підпис (.p7s)
            $p7sBinary = base64_decode($signature, true);
            if ($p7sBinary !== false) {
                Storage::disk('public')->put($p7sPath, $p7sBinary);
            }

            if (!Storage::disk('public')->exists($pdfPath)) {
                throw new \RuntimeException(
                    "Фінальний PDF не знайдений після збереження: {$pdfPath}"
                );
            }

            /*
             * 5. Оновлюємо записи в БД
             */
            DB::transaction(function () use (
                $consent,
                $signerInfo,
                $signData,
                $pdfPath,
                $p7sPath,
                $fileName,
                $signature
            ) {
                $consent->update([
                    'status' => 'signed',
                    'signed_at' => now(),
                    'signer_info' => $signerInfo,
                    'pdf_path' => $pdfPath,
                    'p7s_path' => $p7sPath,
                ]);

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

                if ($consent->doctorPhoto) {
                    $consent->doctorPhoto->update([
                        'is_active' => true,
                    ]);
                }
            });

            /*
             * 6. Очищаємо тимчасовий черновий PDF та кеш
             */
            if (Storage::disk('local')->exists($temporaryPdfPath)) {
                Storage::disk('local')->delete($temporaryPdfPath);
            }

            Cache::forget('diia_consent:' . $requestId);

            Log::info('DIIA SIGNING SUCCESS', [
                'consent_id' => $consent->id,
                'requestId' => $requestId,
                'fileName' => $fileName,
                'signer_name' => $signerInfo['name'],
                'signer_drfo' => $signerInfo['drfo'],
            ]);

            return response()->json([
                'success' => true,
            ], 200);

        } catch (\Throwable $e) {
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

    private function extractDiiaSignerInfo(
        string $signature
    ): array {
        $signatureBinary = base64_decode(
            $signature,
            true
        );

        if ($signatureBinary === false) {
            throw new \RuntimeException(
                'Invalid Diia signature Base64'
            );
        }

        $tmpFile = tempnam(
            sys_get_temp_dir(),
            'diia_cms_'
        );

        if ($tmpFile === false) {
            throw new \RuntimeException(
                'Unable to create temporary CMS file'
            );
        }

        $certFile = $tmpFile . '.pem';

        try {
            file_put_contents(
                $tmpFile,
                $signatureBinary
            );

            $command = sprintf(
                'openssl pkcs7 -inform DER -in %s -print_certs -out %s 2>&1',
                escapeshellarg($tmpFile),
                escapeshellarg($certFile)
            );

            exec(
                $command,
                $output,
                $exitCode
            );

            if (
                $exitCode !== 0
                || !file_exists($certFile)
            ) {
                throw new \RuntimeException(
                    'Unable to extract certificate from Diia CMS: ' .
                    implode("\n", $output)
                );
            }

            $certificates = file_get_contents(
                $certFile
            );

            if (
                $certificates === false
                || trim($certificates) === ''
            ) {
                throw new \RuntimeException(
                    'Diia CMS certificate data is empty'
                );
            }

            if (!preg_match(
                '/-----BEGIN CERTIFICATE-----(.*?)-----END CERTIFICATE-----/s',
                $certificates,
                $matches
            )) {
                throw new \RuntimeException(
                    'No X.509 certificate found in Diia CMS'
                );
            }

            $certificate =
                "-----BEGIN CERTIFICATE-----\n"
                . trim($matches[1])
                . "\n-----END CERTIFICATE-----\n";

            $certInfo = openssl_x509_parse(
                $certificate
            );

            if ($certInfo === false) {
                throw new \RuntimeException(
                    'Unable to parse Diia signer certificate'
                );
            }

            $subject = $certInfo['subject'] ?? [];
            $issuer = $certInfo['issuer'] ?? [];

            $firstName = isset($subject['GN'])
                ? trim($subject['GN'])
                : null;

            $lastName = isset($subject['SN'])
                ? trim($subject['SN'])
                : null;

            $serialNumber =
                $subject['serialNumber'] ?? null;

            $drfo = null;

            if (
                is_string($serialNumber)
                && preg_match(
                    '/TINUA-(\d+)/',
                    $serialNumber,
                    $matches
                )
            ) {
                $drfo = $matches[1];
            }

            $name = trim(
                implode(
                    ' ',
                    array_filter([
                        $lastName,
                        $firstName,
                    ])
                )
            );

            if ($name === '') {
                $name =
                    $subject['CN']
                    ?? 'Підписувач Дія.Підпис';
            }

            return [
                'name' => $name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'drfo' => $drfo,
                'certificate_serial' =>
                    $certInfo['serialNumberHex']
                    ?? null,
                'certificate_issuer' =>
                    $issuer['CN']
                    ?? null,
                'certificate_valid_from' =>
                    isset($certInfo['validFrom_time_t'])
                        ? date(
                            'Y-m-d H:i:s',
                            $certInfo['validFrom_time_t']
                        )
                        : null,
                'certificate_valid_to' =>
                    isset($certInfo['validTo_time_t'])
                        ? date(
                            'Y-m-d H:i:s',
                            $certInfo['validTo_time_t']
                        )
                        : null,
                'signed_at' =>
                    now()->format('d.m.Y H:i:s'),
            ];
        } finally {
            @unlink($tmpFile);
            @unlink($certFile);
        }
    }
}