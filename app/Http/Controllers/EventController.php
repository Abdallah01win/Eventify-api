<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Log;

class EventController extends CrudController
{
    protected $table = 'events';

    protected $modelClass = Event::class;

    protected function getTable()
    {
        return $this->table;
    }

    protected function getModelClass()
    {
        return $this->modelClass;
    }

    protected function getReadAllQuery(): Builder
    {
        return $this->model()->with(['user:id,name,email', 'category:id,name,slug']);
    }

    public function createOne(Request $request)
    {
        try {
            $request->merge(['user_id' => auth()->id()]);

            return parent::createOne($request);
        } catch (\Exception $e) {
            Log::error('Error caught in function EventController.createOne : ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json(['success' => false, 'errors' => [__('common.unexpected_error')]]);
        }
    }

    public function updateOne($id, Request $request)
    {
        try {
            return parent::updateOne($id, $request);
        } catch (\Exception $e) {
            Log::error('Error caught in function EventController.updateOne : ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json(['success' => false, 'errors' => [__('common.unexpected_error')]]);
        }
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
