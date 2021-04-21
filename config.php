<?php

return [
    // Host Configuration
    'host' => env('NETBOX_URL', 'http://localhost:8000'),
    'token' => env('NETBOX_API_TOKEN', ''),

    // SSL Options
    'verify_peer' => env('NETBOX_VERIFY_SSL', true)
];
