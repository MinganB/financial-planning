<?php

if (!function_exists('getUserDetailsFields')) {
    function getUserDetailsFields() {
        return [
            5 => 'title',
            7 => 'marital_regime',
            53 => 'nationality',
        ];
    }
}

if (!function_exists('getUserDataFields')) {
    function getUserDataFields() {
        return [
            1 => 'nick_name',
            2 => 'full_name',
            3 => 'last_name',
            4 => 'initials',
            11 => 'home_3',
            12 => 'city',
            13 => 'home_2',
            15 => 'complex_name',
            16 => 'complex_unit',
            17 => 'home_1',
            18 => 'street_number',
            19 => 'copy_postal',
            54 => 'id_number',
        ];
    }
}

if (!function_exists('getAnniversaryFields')) {
    function getAnniversaryFields() {
        return [
            9 => 'anniversary_year',
            10 => 'anniversary_month',
            11 => 'anniversary_day',
        ];
    }
}

if (!function_exists('getUserEmploymentFields')) {
    function getUserEmploymentFields() {
        return [
            21 => 'employer',
            22 => 'job_title',
            23 => 'employer_since',
            24 => 'industry',
            25 => 'industry_since',
            38 => 'retirement_age',
        ];
    }
}

if (!function_exists('getUserUnderwritingFields')) {
    function getUserUnderwritingFields() {
        return [
            31 => 'medical_scheme',
            32 => 'member_no',
            34 => 'is_smoker',
            35 => 'smoker_status',
            36 => 'is_drinker',
            37 => 'alcohol_usage',
        ];
    }
}

?>