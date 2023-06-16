<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public static function formatMobileNumber($number) {
        // Remove all non-numeric characters from the number
        // dd($number);
        $number = preg_replace('/[^0-9]/', '', $number);
    
        // Check if the number has a country code prefix
        $hasCountryCode = false;
        if (strlen($number) > 10) {
            $hasCountryCode = true;
        }
    
        // Format the number based on whether it has a country code
        if ($hasCountryCode) {
            // Format: +CC (AAA) NNN-NNNN
            preg_match('/(\d{1,3})(\d{3})(\d{3})(\d{4})/', $number, $matches);
            $formattedNumber = '+' . $matches[1] . ' (' . $matches[2] . ') ' . $matches[3] . '-' . $matches[4];
        } else {
            // Format: (AAA) NNN-NNNN
            preg_match('/(\d{3})(\d{3})(\d{4})/', $number, $matches);
            $formattedNumber = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
        }
    
        return $formattedNumber;
    }
}
