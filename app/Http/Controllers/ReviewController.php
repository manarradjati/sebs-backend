<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Exception;

class ReviewController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Reviews retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve reviews.',
            'create_success'   => 'Review created successfully.',
            'create_failure'   => 'Failed to create review.',
            'show_success'     => 'Review retrieved successfully.',
            'show_failure'     => 'Failed to retrieve review.',
            'update_success'   => 'Review updated successfully.',
            'update_failure'   => 'Failed to update review.',
            'delete_success'   => 'Review deleted successfully.',
            'delete_failure'   => 'Failed to delete review.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'Review cannot be deleted due to related data.'
        ];
    }

    public function index()
    {
        try {
            $reviews = Review::with('booking')->get();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $reviews
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['retrieve_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function store(ReviewRequest $request)
    {
        try {
            Review::create($request->validated());
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

    public function show(Review $review)
    {
        try {
            $review->load('booking');
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $review
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['show_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ReviewRequest $request, Review $review)
    {
        try {
            $review->update($request->validated());
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

    public function destroy(Review $review)
    {
        try {
            $review->delete();
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
