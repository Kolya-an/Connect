<?php

namespace App\Http\Controllers;

use App\Models\PhotoConsent;
use App\Services\DiiaSignService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DiiaWebhookController extends Controller
{
    public function handle(Request $request, DiiaSignService $diiaService)
    {
        $requestId = $request->input('requestId');
        // Якщо Дія передає sessionId у тілі webhook-запиту, беремо його як фолбек
        $sessionId = $request->input('sessionId') ?? $request->input('diia_session_id');
        
        $consent = PhotoConsent::where('token', $requestId)
            ->with(['doctorPhoto', 'userSignature'])
            ->first();

        // 1. Ідемпотентність: якщо запис не знайдено або вже підписано — повертаємо 200 OK
        if (!$consent || $consent->status === 'signed') {
            return response()->json(['status' => 'ok']);
        }

        try {
            // Отримуємо ідентифікатор сесії (з моделі або з запиту)
            $activeSessionId = $consent->diia_session_id ?? $sessionId;

            // 2. Отримуємо розшифровані дані підпису з Дії
            $signData = $diiaService->getSignatureResult($activeSessionId);

            $signerInfo = [
                'name' => $signData['userInfo']['fullName'] ?? 'Невідомо',
                'drfo' => $signData['userInfo']['drfo'] ?? '',
                'signed_at' => now()->toDateTimeString(),
            ];

            // 3. Безпечне зчитування зображення в Base64
            $photoBase64 = null;
            if ($consent->doctorPhoto && Storage::disk('public')->exists($consent->doctorPhoto->path)) {
                $photoBase64 = base64_encode(Storage::disk('public')->get($consent->doctorPhoto->path));
            }

            // 4. Генерація PDF
            $pdf = Pdf::loadView('pdf.photo-consent', [
                'consent' => $consent,
                'signerInfo' => $signerInfo,
                'photoBase64' => $photoBase64,
            ]);

            $pdfPath = "consents/consent_{$consent->id}_" . time() . ".pdf";
            Storage::disk('public')->put($pdfPath, $pdf->output());

            // 5. Транзакційне оновлення бази даних
            DB::transaction(function () use ($consent, $signerInfo, $signData, $pdfPath) {
                $consent->update([
                    'status' => 'signed',
                    'signed_at' => now(),
                    'signer_info' => $signerInfo,
                    'pdf_path' => $pdfPath,
                ]);

                if ($consent->userSignature) {
                    $consent->userSignature->update([
                        'status' => 'signed',
                        'signed_at' => now(),
                        'signature_data' => $signData,
                        'pdf_path' => $pdfPath,
                    ]);
                }

                if ($consent->doctorPhoto) {
                    $consent->doctorPhoto->update(['is_active' => true]);
                }
            });

            return response()->json(['status' => 'success']);

        } catch (\Throwable $e) {
            Log::error("Diia Webhook Error [Token: {$requestId}]: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process webhook',
            ], 500);
        }
    }
}