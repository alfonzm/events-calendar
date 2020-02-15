<?php

namespace App\Helpers;

class DateHelper
{
    //
    // Pass a start date, end date and an array of weekday numbers (e.g. 0 = Sun, 1 = Mon, etc)
    // and get an array of dates for each day of week within the range
    //
    // Format of start date, end date and result is in Y-m-d
    //
    public static function getDatesByDaysOfWeekWithinRange($startDate, $endDate, $dayOfWeekNumbers = []) {
        // get dates per week
        $datesPerDayOfWeek = array_map(function($dayOfWeekNumber) use ($startDate, $endDate) {
            return DateHelper::getDatesByDayOfWeekWithinRange($startDate, $endDate, $dayOfWeekNumber);
        }, $dayOfWeekNumbers);

        // flatten into one array of dates
        return array_merge(...$datesPerDayOfWeek);
    }

    public static function getDatesByDayOfWeekWithinRange($startDate, $endDate, $dayOfWeekNumber){
        $dateArray = [];
        $endDate = strtotime($endDate);

        $days = [
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
        ];

        for($i = strtotime($days[$dayOfWeekNumber], strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i)) {
            $dateArray[] = date('Y-m-d',$i);
        }

        return $dateArray;
    }
}
