<?php

if (!function_exists('getProvinceByInt')) {
    function getProvinceByInt($int) {
        $provinces = [
            "I don't live in South Africa",
            "Gauteng",
            "Limpopo",
            "Mpumulanga",
            "North West",
            "Free State",
            "KwaZulu-Natal",
            "Eastern Cape",
            "Northern Cape",
            "Western Cape",
        ];

        return $provinces[$int];
    }
}

?>