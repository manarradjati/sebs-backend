<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizerRequest;
use Exception;

class OrganizerController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Organizers retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve organizers.',
            'create_success'   => 'Organizer created successfully.',
            'create_failure'   => 'Failed to create organizer.',
            'show_success'     => 'Organizer retrieved successfully.',
            'show_failure'     => 'Failed to retrieve organizer.',
            'update_success'   => 'Organizer updated successfully.',
            'update_failure'   => 'Failed to update organizer.',
            'delete_success'   => 'Organizer deleted successfully.',
            'delete_failure'   => 'Failed to delete organizer.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'Organizer cannot be deleted due to related data.'
        ];
    }

    public function index()
    {
        try {
            $organizers = Organizer::all();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $organizers
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['retrieve_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    public function store(OrganizerRequest $request)
    {
        try {
            Organizer::create($request->validated());
            return response()->json([
                'toastmessage' => $this->messages['create_success']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['create_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    public function show(Organizer $organizer)
    {
        try {
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $organizer
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['show_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    public function update(OrganizerRequest $request, Organizer $organizer)
    {
        try {
            $organizer->update($request->validated());
            return response()->json([
                'toastmessage' => $this->messages['update_success']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['update_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    public function destroy(Organizer $organizer)
    {
        try {
            $organizer->delete();
            return response()->json([
                'toastmessage' => $this->messages['delete_success'],
                'message' => $this->messages['delete_success'],
            ]);
        } catch (\Illuminate\Database\QueryException $queryException) {
            return response()->json([
                'error' => $this->messages['unexpected_error_query'],
                'toastmessage' => $this->messages['delete_failure_query'],
                'exception' => $queryException
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'toastmessage' => $this->messages['delete_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }
}
