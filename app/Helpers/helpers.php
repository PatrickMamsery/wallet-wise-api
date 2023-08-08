
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if (! function_exists('referenceNumber')) {
    function referenceNumber($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }
}

// generate random string for password reset
// Helper functions
if (! function_exists('generateRandomString')) {
    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
