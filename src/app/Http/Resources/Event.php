<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id)) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'event_days' => EventDay::collection($this->eventDays),
            ];
        } else {
            return [];
        }
    }
}
