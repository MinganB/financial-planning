<?php

if (!function_exists('formatDate')) {
    /**
     * Returns date in 'YYYY-MM-DD' format. 
     *
     * @param int $year Year in format YYYY.
     * @param int $month (Optional) Month. Defaults to '1'.
     * @param int $day (Optional) Day. Defaults to '1'.
     * @return string Date in 'YYYY-MM-DD' format - null if failed.
     */
    function formatDate($year, $month = 1, $day = 1) {
        $year = intval($year);
        $day = (!is_int($day) || $day < 1 || $day > 31) ? 1 : $day;
        $month = (!is_int($month) || $month < 1 || $month > 12) ? 1 : $month;

        if (!is_int($year)) {
            return null;
        }
    
        $formatted_month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $formatted_day = str_pad($day, 2, '0', STR_PAD_LEFT);
    
        $formatted_date = $year . '-' . $formatted_month . '-' . $formatted_day;
        log_message('info', 'Anniversary date is '.$formatted_date);

        return $formatted_date;
    }
}

?>