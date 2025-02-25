<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'user'])
            ->latest()
            ->paginate(10);
            
        return EventResource::collection($events);
    }
    
    public function store(StoreEventRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $event = Event::create([
                'user_id' => auth()->id(),
                ...$request->validated()
            ]);
            
            DB::commit();
            
            return new EventResource($event->load(['category', 'user']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating event'], 500);
        }
    }
    
    public function show(Event $event)
    {
        return new EventResource($event->load(['category', 'user']));
    }
    
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        
        DB::beginTransaction();
        
        try {
            $event->update($request->validated());
            
            DB::commit();
            
            return new EventResource($event->load(['category', 'user']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating event'], 500);
        }
    }
    
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        
        $event->delete();
        
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function join(Event $event)
    {
        if ($event->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Already participating'], 400);
        }

        $event->participants()->create([
            'user_id' => auth()->id(),
            'status' => 'confirmed'
        ]);

        return response()->json(['message' => 'Successfully joined event', 'status' => 'confirmed']);
    }

    public function leave(Event $event)
    {
        $participant = $event->participants()->where('user_id', auth()->id())->first();
        
        if (!$participant) {
            return response()->json(['message' => 'Not participating in this event'], 400);
        }

        $participant->delete();

        return response()->json(['message' => 'Successfully left event']);
    }
}
