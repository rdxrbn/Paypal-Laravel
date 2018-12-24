<?php
/**
 * Created by: Rooban Viveh
 * Email: followrdx@gmail.com
 * Date: 12/25/18
 */
return [

    'paypal' => [
        'id' => env('PAYPAL_CLIENTID'),
        'secret' => env('PAYPAL_SECRET'),
        'url' => [
            'redirect' => 'http://lucki.de/process-payment',
            'cancelled' => 'http://lucki.de/cancelled'
        ]
    ],

];
