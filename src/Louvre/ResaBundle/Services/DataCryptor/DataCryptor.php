<?php

namespace Louvre\ResaBundle\Services\DataCryptor;

class DataCryptor {
    public function f_crypt($key, $data) {
        $key = md5($key);
        $letter = -1;
        $newString = '';
        $strlen = strlen($data);

        for ($i = 0; $i < $strlen; $i++) {
            $letter++;
            if ($letter > 31) {
                $letter = 0;
            }
            $neword = ord($data{$i}) + ord($key{$letter});
            if ($neword > 255) {
                $neword -= 256;
            }
            $newString .= chr($neword);
        }
        return base64_encode($newString);
    }
    
    public function f_decrypt($key, $data) {
        $key = md5($key);
        $letter = -1;
        $newString = '';
        $data = base64_decode($data);
        $strlen = strlen($data);
        
        for ($i = 0; $i < $strlen; $i++) {
            $letter++;
            if ($letter > 31) {
                $letter = 0;
            }
            $neword = ord($data{$i}) - ord($key{$letter});
            if ($neword < 1) {
                $neword += 256;
            }
            $newString .= chr($neword);
        }
        
        return $newString;
    }
}