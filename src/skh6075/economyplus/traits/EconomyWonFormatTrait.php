<?php

namespace skh6075\economyplus\traits;

trait EconomyWonFormatTrait{

    /** @package PresentKim */
    public function koreanWonFormat(float $amount, string $endUnit): string{
        $order = ['', '만', '억', '조', '경'];
        $str = "";

        for ($i = count($order) - 1; $i >= 0; --$i) {
            $unit = pow(10000, $i);
            $part = floor($amount / $unit);
            if ($part > 0) {
                $str .= $part . $order[$i];
            }

            $amount %= $unit;
        }

        if (strlen($str) <= 0) {
            $str .= "0";
        }

        return $amount <= 0 ? $str . " " . $endUnit : $amount . " " . $endUnit;
    }

    public function wonFormat(float $format, string $endUnit): string{
        return number_format($format) . $endUnit;
    }
}