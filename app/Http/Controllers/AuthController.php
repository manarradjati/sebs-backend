<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     private $messages;

     public function __construct()
     {
          $this->messages = [
               'login_success'    => 'Login successful',
               'login_failure'    => 'Login failed',
               'invalid_credentials' => 'Invalid credentials',
               'invalid_email'    => 'Invalid email address',
               'invalid_password' => 'Invalid password',



               'logout_success'   => 'Logout successful',
               'logout_failure'   => 'Logout failed',
               'register_success' => 'User registered successfully',
               'register_failure' => 'User registration failed',
               'user_info_success'=> 'User information retrieved successfully',
               'user_info_failure'=> 'Failed to retrieve user information',
               'change_password_success' => 'Password changed successfully',
               'change_password_failure' => 'Failed to change password',
               'password_incorrect' => 'Current password is incorrect',
               'unexpected_error' => 'An unexpected error occurred',
               'validation_error' => 'Validation error',
          ];
     }

     public function login(Request $request)
     {
          try {
               $credentials = $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|string',
               ]);

               // -------------------------------------------------------------
               // -------------------------------------------------------------
               // -------------------------------------------------------------
               // Check if the email exists and the password is correct separately error messages

               $email = $request->input('email');
               $password = $request->input('password');

               // Check if the email exists
               $user = \App\Models\User::where('email', $email)->first();

               if (!$user) {
                    // If the email doesn't exist, send an appropriate response
                    return response()->json([
                         'toastmessage' => $this->messages['invalid_email'],
                         'error' => $this->messages['login_failure'],
                    ], 404);
               }

               // Try to authenticate with the credentials
               if (!$token = JWTAuth::attempt($credentials)) {
                    // If authentication fails, but email exists, password is likely incorrect
                    return response()->json([
                         'toastmessage' => $this->messages['invalid_password'],
                         'error' => $this->messages['login_failure'],
                    ], 404);
               }

               // -------------------------------------------------------------
               // -------------------------------------------------------------
               // -------------------------------------------------------------


               // if (!$token = JWTAuth::attempt($credentials)) {
               //      return response()->json([
               //           'toastmessage' => $this->messages['invalid_credentials'],
               //           'error' => $this->messages['login_failure'],
               //      ], 500);
               // }

               $user = JWTAuth::user();
               // $user->load(['orders']);
               $token = JWTAuth::fromUser($user);
               $data = ['token' => $token, 'user' => $user];

               return response()->json([
                    'toastmessage' => $this->messages['login_success'],
                    'data' => $data,
               ], 200);
          } catch (\Throwable $e) {
               return response()->json([
                    'toastmessage' => $this->messages['unexpected_error'],
                    'error' => $this->messages['unexpected_error'],
                    'exception' => $e->getMessage(),
               ], 500);
          }
     }

     public function logout()
     {
          try {
               JWTAuth::invalidate(JWTAuth::getToken());

               return response()->json([
                    'toastmessage' => $this->messages['logout_success'],
               ], 200);
          } catch (\Throwable $e) {
               return response()->json([
                    'toastmessage' => $this->messages['logout_failure'],
                    'error' => $this->messages['unexpected_error'],
                    'exception' => $e->getMessage(),
               ], 500);
          }
     }

     public function register(Request $request)
     {
          try {
               $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                    'username' => 'required|string|max:255|unique:users,username',
                    'is_banned' => 'boolean',
                    'address' => 'nullable|string|max:500',
                    'age' => 'nullable|integer|min:0',
                    'phone' => 'nullable|string|max:20',
               ]);

               $validated['password'] = Hash::make($validated['password']);

               $user = User::create($validated);

               $token = JWTAuth::fromUser($user);

               return response()->json([
                    'toastmessage' => $this->messages['register_success'],
                    'user' => $user,
                    'token' => $token,
               ], 201); // HTTP 201 Created
          } catch (\Throwable $e) {
               return response()->json([
                    'toastmessage' => $this->messages['register_failure'],
                    'error' => $this->messages['unexpected_error'],
                    'exception' => $e->getMessage(),
               ], 500);
          }
     }
     
     public function userInfo(Request $request)
     {
          try {
               $user = JWTAuth::user();

               return response()->json([
                    'toastmessage' => $this->messages['user_info_success'],
                    'user' => $user,
               ], 200);
          } catch (\Throwable $e) {
               return response()->json([
                    'toastmessage' => $this->messages['user_info_failure'],
                    'error' => $this->messages['unexpected_error'],
                    'exception' => $e->getMessage(),
               ], 500);
          }
     }

     private function isStrongPassword($password)
     {
          return 
          strlen($password) >= 8 && 
          preg_match('/[A-Z]/', $password) && 
          preg_match('/[a-z]/', $password) && 
          preg_match('/[0-9]/', $password) && 
          preg_match('/[^A-Za-z0-9]/', $password);
     }

     public function changePassword(Request $request)
     {
          try {
               // Validate the request data
               $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:8',
                    'new_password_confirmation' => 'required|same:new_password',
               ]);

               if ($validator->fails()) {
                    return response()->json([
                         'toastmessage' => $this->messages['validation_error'],
                         'errors' => $validator->errors()
                    ], 422);
               }

               // Get the authenticated user
               $user = JWTAuth::user();

               // Check if the current password matches the user's stored password
               if (!Hash::check($request->input('current_password'), $user->password)) {
                    return response()->json(['toastmessage' => $this->messages['password_incorrect']], 422);
               }

               // Update the user's password with the new one
               $user->password = Hash::make($request->input('new_password'));
               $user->save();

               return response()->json([
                    'toastmessage' => $this->messages['change_password_success'],
               ], 200);


          } catch (\Throwable $e) {
               return response()->json([
                    'toastmessage' => $this->messages['change_password_failure'],
                    'error' => $this->messages['unexpected_error'],
                    'exception' => $e->getMessage(),
               ], 500);
          }
     }
}
