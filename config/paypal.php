<?php
return [
	// Client ID of the app you registered on PayPal Dev
    'client_id' => env('PAYPAL_CLIENT_ID', 'AWb_eG-q59tLHNE_1sZH1Lk-SBk35QXo6vE-duVxX3rO6M-oMs9uqBweFhCrd7njagswgQXIkbpwQzQr'),
    // Secret of the app
    'secret' => env('PAYPAL_SECRET', 'EP6yv_gF4LoqcbS02x4IZm29XyxvliCp0fkslAZCpVWzZrspO_PJu8r4SkCnfjEXpglfW-UFnFESjODZ'),
    'settings' => [
    	// PayPal mode, sandbox or live
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        // Time of a connection (in seconds)
        'http.ConnectionTimeOut' => 30,
        // There is a log when an error occurs
        'log.logEnabled' => true,
        // The path to the file will log
        'log.FileName' => storage_path() . '/logs/paypal.log',
        // Log type
        'log.LogLevel' => 'FINE'
    ],
];