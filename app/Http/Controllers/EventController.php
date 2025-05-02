<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest;
use Exception;

class EventController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Events retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve events.',
            'create_success'   => 'Event created successfully.',
            'create_failure'   => 'Failed to create event.',
            'show_success'     => 'Event retrieved successfully.',
            'show_failure'     => 'Failed to retrieve event.',
            'update_success'   => 'Event updated successfully.',
            'update_failure'   => 'Failed to update event.',
            'delete_success'   => 'Event deleted successfully.',
            'delete_failure'   => 'Failed to delete event.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'Event cannot be deleted due to related data.'
        ];
    }

    public function index()
    {
        try {
            $events = Event::with(['organizer.user', 'category'])->get();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $events
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['retrieve_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function store(EventRequest $request)
    {
        try {
            Event::create($request->validated());
            return response()->json([
                'toastmessage' => $this->messages['create_success']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['create_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Event $event)
    {
        try {
            $event->load(['organizer', 'category']);
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $event
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['show_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function update(EventRequest $request, Event $event)
    {
        try {
            $event->update($request->validated());
            return response()->json([
                'toastmessage' => $this->messages['update_success']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['update_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Event $event)
    {
        try {
            $event->delete();
            return response()->json([
                'toastmessage' => $this->messages['delete_success']
            ]);
        } catch (\Illuminate\Database\QueryException $queryException) {
            return response()->json([
                'toastmessage' => $this->messages['delete_failure_query'],
                'error' => $this->messages['unexpected_error_query'],
                'exception' => $queryException->getMessage()
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'toastmessage' => $this->messages['delete_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }
}
