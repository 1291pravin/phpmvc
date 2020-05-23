<?php

class EncyptDescryptHelper extends Controller {

    public static $originalCharacters;
    public static $encryptedCharacters;

    public static function init() {
        if (empty(self::$originalCharacters))
            self::$originalCharacters = range('a', 'z');
    }

    public static function createArray($string) {
        self::init();
        $number = strlen($string);
        $countCharacters = count(self::$originalCharacters);
        $newCharacters = [];
        $j = 0;
        for ($i = 0; $i < count(self::$originalCharacters); $i++) {
            if ($i < $number) {
                $newCharacters[$countCharacters - $number + $i] = self::$originalCharacters[$i];
            } else {
                $newCharacters[$j++] = self::$originalCharacters[$i];
            }
        }
        ksort($newCharacters);
        self::$encryptedCharacters = $newCharacters;
    }

    public static function encryptdecypt($string, $originalCharacters, $encryptedCharacters) {
        $charactersIndex = array_flip($originalCharacters);
        $encyptString = "";
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (in_array($char, $originalCharacters)) {
                $charIndex = $charactersIndex[$char];
                $encyptString .= isset($encryptedCharacters[$charIndex]) ? $encryptedCharacters[$charIndex] : $string[$i];
            } else {
                $encyptString .= $string[$i];
            }
        }
        return $encyptString;
    }

    public static function encypt($string) {
        self::createArray($string);
        return self::encryptdecypt($string, self::$originalCharacters, self::$encryptedCharacters);
    }

    public static function decrypt($string) {
        self::createArray($string);
        return self::encryptdecypt($string, self::$encryptedCharacters, self::$originalCharacters);
    }

}

?>