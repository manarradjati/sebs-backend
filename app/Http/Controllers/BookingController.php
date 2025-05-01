<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\BookingRequest;
use Exception;

class BookingController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Bookings retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve bookings.',
            'create_success'   => 'Booking created successfully.',
            'create_failure'   => 'Failed to create booking.',
            'show_success'     => 'Booking retrieved successfully.',
            'show_failure'     => 'Failed to retrieve booking.',
            'update_success'   => 'Booking updated successfully.',
            'update_failure'   => 'Failed to update booking.',
            'delete_success'   => 'Booking deleted successfully.',
            'delete_failure'   => 'Failed to delete booking.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'Booking cannot be deleted due to related data.'
        ];
    }

    public function index()
    {
        try {
            $bookings = Booking::with(['user', 'event'])->get();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $bookings
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['retrieve_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function store(BookingRequest $request)
    {
        try {
            Booking::create($request->validated());
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

    public function show(Booking $booking)
    {
        try {
            $booking->load(['user', 'event']);
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $booking
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['show_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function update(BookingRequest $request, Booking $booking)
    {
        try {
            $booking->update($request->validated());
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

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
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
