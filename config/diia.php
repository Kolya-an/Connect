<?php

return [
    'api_url' => 'https://api2s.diia.gov.ua/api/v2',
    'branch_id' => env('DIIA_BRANCH_ID', '12345'),
    'client_id' => env('DIIA_CLIENT_ID', 'client_id'),
    'client_secret' => env('DIIA_CLIENT_SECRET', 'client_secret'),
    'webhook_url' => env('DIIA_WEBHOOK_URL', 'https://connect-cosmetology.com/api/diia/webhook'),
    'signature_type' => env('DIIA_SIGNATURE_TYPE', 'CAdES_X_LONG'),
];