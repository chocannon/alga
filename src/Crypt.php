<?php
// +----------------------------------------------------------------------
// | AES加解密类
// +----------------------------------------------------------------------
// | Author: chocannon@outlook.com
// +----------------------------------------------------------------------

namespace Alga;

class Crypt
{
    /**
     * 加密
     */
    public static function encode(string $text, string $key, string $cipher = 'AES-256-CBC')
    {
        $ivLen   = openssl_cipher_iv_length($cipher);
        $ivStr   = openssl_random_pseudo_bytes($ivLen);
        $ciphStr = openssl_encrypt($text, $cipher, $key, OPENSSL_RAW_DATA, $ivStr);
        $hmacStr = hash_hmac('sha256', $ciphStr, $key, true);
        return base64_encode($ivStr . $hmacStr . $ciphStr);
    }


    /**
     * 解密
     */
    public static function decode(string $cipherText, string $key, string $cipher = 'AES-256-CBC')
    {
        $ciphText = base64_decode($cipherText);
        $ivLen    = openssl_cipher_iv_length($cipher);
        $ivStr    = substr($ciphText, 0, $ivLen);
        $hmacStr  = substr($ciphText, $ivLen, $shaLen = 32);
        $ciphStr  = substr($ciphText, $ivLen + $shaLen);
        $origStr  = openssl_decrypt($ciphStr, $cipher, $key, OPENSSL_RAW_DATA, $ivStr);
        $calcMac  = hash_hmac('sha256', $ciphStr, $key, true);
        return hash_equals($hmacStr, $calcMac) ? $origStr : false;
    }
}

