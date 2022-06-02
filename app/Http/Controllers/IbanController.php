<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IbanController extends Controller
{
    public function getValidation($iban) {
        return response($this->validateIban($iban), 200);
      }

    public function validateIban($iban) {
        //Validate an IBAN according to https://en.wikipedia.org/wiki/International_Bank_Account_Number
        /*Check that the total IBAN length is correct as per the country. If not, the IBAN is invalid
Move the four initial characters to the end of the string
Replace each letter in the string with two digits, thereby expanding the string, where A = 10, B = 11, ..., Z = 35
Interpret the string as a decimal integer and compute the remainder of that number on division by 97*/
        $len = strlen($iban);
        
        $movedIban = trim(Str::substr($iban, 4, $len - 4).Str::substr($iban, 0, 4));

        $arrayOfIban = preg_split('//', $movedIban, -1, PREG_SPLIT_NO_EMPTY);

        for ($i=0; $i<$len; $i++) {
            if (preg_match('/[a-zA-Z]/', $arrayOfIban[$i])) {
                $arrayOfIban[$i] = $this->convertToDigits($arrayOfIban[$i]);
            }         
        }

        $convertedIban = implode('',$arrayOfIban);

        if($this->mod97($convertedIban) == 1)
           return true;
        
        return false;
    }

    public function convertToDigits($letter) {
        
        $letters = collect(['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']);

        $convertedDigits = $letters->search($letter) + 10;

        return $convertedDigits;
    }

    public function mod97($string) {  
        return bcmod($string,97);
    }

    public function validateCountryCode($string) {  
        //to do
        return true;
    }
}
