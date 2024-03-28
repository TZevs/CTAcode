<?php
    function exchange(float $amount, float $rates) {
        $newAmount = $amount * $rates;

        return [
            $newAmount
        ];
    } 
?>