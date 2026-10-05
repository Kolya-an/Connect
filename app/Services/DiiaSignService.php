<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DiiaSignService
{
    protected string $baseUrl;
    protected string $acquirerToken;
    protected string $authAcquirerToken;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.diia.base_url', 'https://api2s.diia.gov.ua'), '/');
        $this->acquirerToken = config('services.diia.acquirer_token', 'hyalual_test_token_lle312');
        $this->authAcquirerToken = config('services.diia.auth_acquirer_token', 'YWNxdWlyZXJfMTYxMjpoeWFsdWFsX3Rlc3RfdG9rZW5fbGxlMzEy');
    }

    /**
     * Стандартні заголовки для всіх запитів до Дії
     */
    protected function defaultHeaders(?string $sessionToken = null): array
    {
        $headers = [
            'Accept'     => 'application/json',
            'User-Agent' => 'ConnectCosmetology/1.0',
        ];

        if ($sessionToken) {
            $headers['Authorization'] = "Bearer {$sessionToken}";
        }

        return $headers;
    }

    /**
     * Крок 1: Отримання сесійного токена (з кешуванням на 110 хвилин)
     */
    public function getSessionToken(): string
    {
        return Cache::remember('diia_session_token', 110 * 60, function () {
            $url = "{$this->baseUrl}/api/v1/auth/acquirer/{$this->acquirerToken}";

            $response = Http::withHeaders([
                'Authorization' => "Basic {$this->authAcquirerToken}",
                'Accept'        => 'application/json',
                'User-Agent'    => 'ConnectCosmetology/1.0',
            ])->get($url);

            if (!$response->successful()) {
                Log::error('Diia Auth Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                throw new Exception("Помилка авторизації Дії ({$response->status()}): {$response->body()}");
            }

            $sessionToken = $response->json('token');

            if (!$sessionToken) {
                throw new Exception("Сесійний токен відсутній у відповіді Дії: " . $response->body());
            }

            return $sessionToken;
        });
    }

    /**
     * Крок 2: Отримання списку створених відділень (Branches)
     */
    public function getBranches(): array
    {
        $sessionToken = $this->getSessionToken();

        $response = Http::withHeaders($this->defaultHeaders($sessionToken))
            ->get("{$this->baseUrl}/api/v2/acquirers/branches");

        if (!$response->successful()) {
            Log::error('Diia Get Branches Error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new Exception('Помилка отримання філій Дії: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Крок 3: Створення нового відділення (Branch)
     */
    public function createBranch(array $data = []): string
    {
        $sessionToken = $this->getSessionToken();
        $url = "{$this->baseUrl}/api/v2/acquirers/branch";

        $payload = array_merge([
            'name'            => 'Connect Cosmetology',
            'email'           => 'connectcosmetologist@gmail.com',
            'region'          => 'м. Київ',
            'district'        => 'м. Київ',
            'location'        => 'м. Київ',
            'street'          => 'вул. Народного Ополчення',
            'house'           => '19',
            'customFullName'  => 'Товариство з обмеженою відповідальністю "Інститут Гіалуаль"',
            'customFullAddress' => 'вул. Народного Ополчення, буд. 19, м. Київ, 03151',
            'deliveryTypes'   => ['api'],
            'offerRequestType'=> 'dynamic',
            'scopes'          => [
                'diiaId' => ['hashedFilesSigning']
            ]
        ], $data);

        $response = Http::withHeaders($this->defaultHeaders($sessionToken))->post($url, $payload);

        if (!$response->successful()) {
            Log::error('Diia Create Branch Error', [
                'status' => $response->status(),
                'body'   => $response->json() ?? $response->body()
            ]);
            throw new Exception('Помилка створення відділення в Дії: ' . $response->body());
        }

        return $response->json('_id');
    }

    /**
     * Крок 4: Створення Оферу для конкретного Branch (API v1)
     */
    public function createOffer(string $branchId, array $data = []): string
    {
        $sessionToken = $this->getSessionToken();
        
        // ВАЖЛИВО: Офери створюються виключно через v1 API
        $url = "{$this->baseUrl}/api/v1/acquirers/branch/{$branchId}/offer";

        $payload = array_merge([
            'name'   => 'Згода на обробку та використання фотоматеріалів',
            'scopes' => [
                'diiaId' => [
                    'hashedFilesSigning'
                ]
            ]
        ], $data);

        $response = Http::withHeaders($this->defaultHeaders($sessionToken))->post($url, $payload);

        if (!$response->successful()) {
            Log::error('Diia Create Offer Error', [
                'url'    => $url,
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            throw new \Exception("Помилка створення Offer в Дії ({$response->status()}): " . $response->body());
        }

        return $response->json('_id') ?? $response->json('id');
    }







    /**
     * Крок 5: Генерація DeepLink для підписання хешів файлів (Дія.Підпис v2)
     */
    public function createHashedFilesSession(string $branchId, string $offerId, array $payload): array
    {
        $sessionToken = $this->getSessionToken();
        $url = "{$this->baseUrl}/api/v2/acquirers/branch/{$branchId}/offer-request/dynamic";

        $body = [
            'offerId'    => $offerId,
            'requestId'  => (string) $payload['requestId'],
            'returnLink' => $payload['returnLink'],
            'signAlgo' => 'ECDSA',
            'data'       => [
                'hashedFilesSigning' => [
                    'hashedFiles' => array_map(function ($file) {
                        return [
                            'fileName' => $file['fileName'],
                            'fileHash' => $file['fileHash'],
                        ];
                    }, $payload['hashedFiles']),
                ],
            ],
        ];

       

$response = Http::withHeaders($this->defaultHeaders($sessionToken))
    ->asJson()
    ->post($url, $body);

        if (!$response->successful()) {
            Log::error('Diia Create Hashed Files Session Error', [
                'url'    => $url,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            throw new Exception("Помилка створення сесії підпису в Дії ({$response->status()}): " . $response->body());
        }

        return $response->json();
    }

    /** 
     * Отримання результату підписання / оферу з Дії (API v2)
     */
    public function getSignatureResult(string $branchId, string $requestId): array
    {
        $token = $this->getSessionToken();

        // ВИПРАВЛЕНО: Правильний шлях Дії v2 (offer-request/{requestId})
        $url = "{$this->baseUrl}/api/v2/acquirers/branch/{$branchId}/offer-request/{$requestId}";

        Log::info("Diia Requesting Signature Result for requestId: {$requestId}", ['url' => $url]);

        $response = Http::withHeaders($this->defaultHeaders($token))->get($url);

        if ($response->failed()) {
            Log::error("Diia Get Signature Result Error [{$response->status()}]:", [
                'requestId' => $requestId,
                'url'       => $url,
                'body'      => $response->body(),
            ]);

            throw new Exception("Помилка отримання результатів підпису від Дії: " . $response->body());
        }

        $data = $response->json();

        Log::info("Diia Signature Result Success for requestId: {$requestId}", [
            'data' => $data,
        ]);

        return $data;
    }

    public function getOffers(string $branchId): array
{
    $sessionToken = $this->getSessionToken();

    $url = "{$this->baseUrl}/api/v1/acquirers/branch/{$branchId}/offers";

    $response = Http::withHeaders(
        $this->defaultHeaders($sessionToken)
    )->get($url);

    Log::info('DIIA GET OFFERS', [
        'url' => $url,
        'status' => $response->status(),
        'body' => $response->json() ?? $response->body(),
    ]);

    if (!$response->successful()) {
        throw new Exception(
            "Помилка отримання Offers Дії ({$response->status()}): "
            . $response->body()
        );
    }

    return $response->json();
}

    public function parseSignerInfo(string $p7sContent): array
    {
        $signerInfo = [
            'name' => 'Невідомо',
            'drfo' => 'Невідомо',
        ];

        // Перетворюємо DER у PEM для обробки OpenSSL
        $pem = "-----BEGIN PKCS7-----\n" . chunk_split(base64_encode($p7sContent), 64, "\n") . "-----END PKCS7-----\n";

        $certs = [];
        if (openssl_pkcs7_unpack($pem, $certs)) {
            // Або витягаємо сертифікат через openssl CLI / certparse
            $tempCertPath = tempnam(sys_get_temp_dir(), 'cert_');
            file_put_contents($tempCertPath, $pem);
            
            $output = [];
            exec("openssl pkcs7 -in {$tempCertPath} -inform PEM -print_certs", $output);
            unlink($tempCertPath);

            $certText = implode("\n", $output);
            
            // Витягаємо РНОКПП / ІПН
            if (preg_match('/TINUA-(\d{8,10})/', $certText, $matches)) {
                $signerInfo['drfo'] = $matches[1];
            }

            // Витягаємо ПІБ (GN - Given Name, SN - Surname або CN)
            $gn = ''; $sn = '';
            if (preg_match('/GN=([^\/\n,]+)/u', $certText, $m)) $gn = $m[1];
            if (preg_match('/SN=([^\/\n,]+)/u', $certText, $m)) $sn = $m[1];

            if ($gn || $sn) {
                $signerInfo['name'] = trim("{$sn} {$gn}");
            } elseif (preg_match('/CN=([^\/\n,]+)/u', $certText, $m)) {
                $signerInfo['name'] = $m[1];
            }
        }

        return $signerInfo;
    }
    
}