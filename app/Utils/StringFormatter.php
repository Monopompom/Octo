<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 4/11/2018
 * Time: 18:46
 */

namespace App\Utils;


class StringFormatter {

    static public function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);

        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        } else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }

        $str = $first_letter . $str_end;

        return $str;
    }
}