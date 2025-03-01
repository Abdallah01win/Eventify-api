<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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
        $userId = Auth::id();
        $now = now();

        return $this->model()
            ->with(['category:id,name'])
            ->with(['participants' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->withCount('participants')
            ->where(function ($query) use ($userId, $now) {
                $query->where('user_id', $userId)
                    ->orWhereHas('participants', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->orWhere('end_date', '>=', $now);
            });
    }

    public function createOne(Request $request)
    {
        try {
            $request->merge(['user_id' => Auth::id()]);

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

    public function join($id)
    {
        $userId = Auth::id();
        $event = Event::findOrFail($id);

        if ($event->participants()->where('user_id', $userId)->exists()) {
            return response()->json(['success' => false, 'errors' => ['Already participating']]);
        }

        $event->participants()->create(
            [
                'user_id' => $userId,
                'event_id' => $event->id,
                'status' => 'confirmed'
            ]
        );

        return response()->json(['success' => true, 'message' => 'Successfully joined event']);
    }

    public function leave($id)
    {
        $event = Event::findOrFail($id);

        $participant = $event->participants()->where('user_id', Auth::id())->first();

        if (!$participant) {
            return response()->json(['success' => false, 'errors' => ['Not participating in this event']]);
        }

        $participant->delete();

        return response()->json(['success' => true, 'message' => 'Successfully left event']);
    }
}
