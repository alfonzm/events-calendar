<?php

namespace App;

use DateHelper;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'start_date', 'end_date'];

    public function eventDays() {
        return $this->hasMany(EventDay::class)->orderBy('date', 'asc');
    }

    public function saveDays($days) {
        // get dates within range, given days of week
        $dates = DateHelper::getDatesByDaysOfWeekWithinRange(
            $this->start_date,
            $this->end_date,
            $days
        );

        // array of ['date' => Y-m-d], used for creating EventDays
        $eventDays = array_map(function($date) {
            return ['date' => $date];
        }, $dates);

        $this->eventDays()->createMany($eventDays);
    }
}
