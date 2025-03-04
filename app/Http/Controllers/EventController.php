<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Mail\EventUpdated;
use App\Mail\EventDeleted;
use App\Mail\UserJoinedEvent;
use App\Mail\UserLeftEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            ->with(['participants' => fn($query) => $query->where('user_id', $userId)])
            ->withCount('participants')
            ->where(
                fn($query) =>
                $query->where('user_id', $userId)
                    ->orWhereHas(
                        'participants',
                        fn($query) => $query->where('user_id', $userId)
                    )
                    ->orWhere('end_date', '>=', $now)
            );
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
            $event = Event::findOrFail($id);
            $response = parent::updateOne($id, $request);

            foreach ($event->participants as $participant) {
                Mail::to($participant->user->email)->send(new EventUpdated($event));
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('Error caught in function EventController.updateOne : ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json(['success' => false, 'errors' => [__('common.unexpected_error')]]);
        }
    }

    public function deleteOne($id, Request $request)
    {
        try {
            $event = Event::findOrFail($id);
            $response = parent::deleteOne($id, $request);

            foreach ($event->participants as $participant) {
                Mail::to($participant->user->email)->send(new EventDeleted($event));
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('Error caught in function EventController.deleteOne : ' . $e->getMessage());
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

        Mail::to($event->user->email)->send(new UserJoinedEvent($event, Auth::user()));

        return response()->json(['message' => 'Successfully joined event', 'status' => 'confirmed']);
    }

    public function leave($id)
    {
        $event = Event::findOrFail($id);

        $participant = $event->participants()->where('user_id', Auth::id())->first();

        if (!$participant) {
            return response()->json(['success' => false, 'errors' => ['Not participating in this event']]);
        }

        $participant->delete();

        Mail::to($event->user->email)->send(new UserLeftEvent($event, Auth::user()));

        return response()->json(['success' => true, 'message' => 'Successfully left event']);
    }
}
