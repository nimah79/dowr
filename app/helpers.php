<?php

if (! function_exists('to_persian_digits')) {
    function to_persian_digits(string $str): string
    {
        return str_replace(
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            $str,
        );
    }
}
