<?php
use Appnings\Payment\Facades\Payment;

return [

    /*
    |--------------------------------------------------------------------------
    | CCAvenue configuration file
    |--------------------------------------------------------------------------
    |   gateway = CCAvenue
    |   view    = File
     */

    'gateway' => 'CCAvenue', // Making this option for implementing multiple gateways in future

    'testMode' => false, // True for Testing the Gateway [For production false]

    'ccavenue' => [ // CCAvenue Parameters
        'merchantId' => env('CCAVENUE_MERCHANT_ID', '408041'),
        'accessCode' => env('CCAVENUE_ACCESS_CODE', 'AVVR58IK08BL10RVLB	'),
        'workingKey' => env('CCAVENUE_WORKING_KEY', '24BC724EC96D725CAE8625447532121B'),

        // Should be route address for url() function
        'redirectUrl' => env('CCAVENUE_REDIRECT_URL', 'payment/success'),
        'cancelUrl' => env('CCAVENUE_CANCEL_URL', 'payment/cancel'),

        'currency' => env('CCAVENUE_CURRENCY', 'INR'),
        'language' => env('CCAVENUE_LANGUAGE', 'EN'),
    ],
//    'ccavenue' => [ // CCAvenue Parameters
//        'merchantId' => env('CCAVENUE_MERCHANT_ID', '408041'),
//        'accessCode' => env('CCAVENUE_ACCESS_CODE', 'AVPW03IH94CG34WPGC'),
//        'workingKey' => env('CCAVENUE_WORKING_KEY', 'DD93E70D2DC5B209F080A23F9282B760'),
//
//        // Should be route address for url() function
//        'redirectUrl' => env('CCAVENUE_REDIRECT_URL', 'payment/success'),
//        'cancelUrl' => env('CCAVENUE_CANCEL_URL', 'payment/cancel'),
//
//        'currency' => env('CCAVENUE_CURRENCY', 'INR'),
//        'language' => env('CCAVENUE_LANGUAGE', 'EN'),
//    ],

    // Add your response link here. In Laravel 5.* you may use the api middleware instead of this.
    'remove_csrf_check' => [
        'payment/reponse','payment/success',
    ],

];
