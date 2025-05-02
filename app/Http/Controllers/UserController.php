<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Users retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve users.',
            'create_success'   => 'User created successfully.',
            'create_failure'   => 'Failed to create user.',
            'show_success'     => 'User retrieved successfully.',
            'show_failure'     => 'Failed to retrieve user.',
            'update_success'   => 'User updated successfully.',
            'update_failure'   => 'Failed to update user.',
            'delete_success'   => 'User deleted successfully.',
            'delete_failure'   => 'Failed to delete user.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'User cannot be deleted due to related data.'
        ];
    }

    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $users
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['retrieve_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            User::create($request->validated());
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

    public function show(User $user)
    {
        try {
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $user
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['show_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $user->update($request->validated());
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

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'toastmessage' => $this->messages['delete_success']
            ]);
        } catch (QueryException $queryException) {
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
