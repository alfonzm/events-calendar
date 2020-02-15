<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Resources\Event as EventResource;
use App\Http\Resources\EventCollection;
use App\Http\Requests\StoreEventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // public function index() {
    //     return new EventResource(Event::all()->last());
    // }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();

        $event = Event::create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'title' => $validated['title'],
        ]);

        $event->saveDays($validated['days']);

        return new EventResource($event);
    }

    public function update(StoreEventRequest $request, Event $event) {
        $validated = $request->validated();

        $event->title = $validated['title'];
        $event->start_date = $validated['start_date'];
        $event->end_date = $validated['end_date'];
        $event->save();

        $event->eventDays()->delete();
        $event->saveDays($validated['days']);

        return new EventResource($event);
    }
}
