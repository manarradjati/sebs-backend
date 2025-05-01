<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Categories retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve categories.',
            'create_success'   => 'Category created successfully.',
            'create_failure'   => 'Failed to create category.',
            'show_success'     => 'Category retrieved successfully.',
            'show_failure'     => 'Failed to retrieve category.',
            'update_success'   => 'Category updated successfully.',
            'update_failure'   => 'Failed to update category.',
            'delete_success'   => 'Category deleted successfully.',
            'delete_failure'   => 'Failed to delete category.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'Category cannot be deleted due to related data.'
        ];
    }

    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $categories
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

    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->validated());
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

    public function show(Category $category)
    {
        try {
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $category
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

    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->validated());
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

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json([
                'toastmessage' => $this->messages['delete_success']
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
