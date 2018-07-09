<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => 'AKIAJDJFIFTYALEH7QQA',
        'secret' => 'ApGdQbSbAbe/jtbyL3ZbS3DU1UcUZ4pzaaYKBlLlKNvR',
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'mandrill' => [
        'secret' => "XM0x0I5ohAmZaAGkTQnZkw",
    ],

    'twitter' => [
        'client_id'     => 'A9L0xXh0pGoDEaIcEghWTYJzI',
        'client_secret' => 'SGXz39tXlq9T0GBoE6YwzlphpkgWHdLvjTuex1QiJgxuRDWNOr',
        'redirect'      => 'http://www.popoestate.dev/auth/twitter/callback',
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect'      => env('FACEBOOK_URL'),
    ],

    'google' => [
        'client_id' => '313973554665-sluiomam92shgrr5eeugc9iaatrcpgod.apps.googleusercontent.com',
        'client_secret' => 'wWy8d6u09uLkksvI6w1Xfk9L',
        'redirect' => 'http://www.popoestate.dev/auth/google/callback',
    ],

];
