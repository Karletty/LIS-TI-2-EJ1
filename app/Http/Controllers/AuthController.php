<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use Laravel\Sanctum\HasApiTokens;
use \stdClass;

class AuthController extends Controller
{
      public function register(Request $request)
      {
            $validator = Validator::make($request->all(), [
                  'name' => 'required|string|max:255',
                  'email' => 'required|string|email|max:255|unique:users',
                  'password' => 'required|string|min:8',
                  'company_id' => 'required|string|min:6|max:6'
            ]);

            if ($validator->fails()) {
                  return response()->json($validator->errors());
            }

            $user = User::create([
                  'name' => $request->name,
                  'email' => $request->email,
                  'password' => Hash::make($request->password),
            ]);

            $employee = Employee::create([
                  'user_id' => $user->id,
                  'company_id' => $request->company_id,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['dataUser' => $user, 'dataEmployee' => $employee, 'access_token' => $token, 'token_type' => 'Bearer']);
      }

      public function login(Request $request)
      {
            if (!Auth::attempt($request->only('email', 'password'))) {
                  return response()->json(['message' => 'Unauthorized'], 401);
            }

            $user = User::where('email', $request['email'])->firstOrFail();
            $employee = Employee::where('user_id', $user->id)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                  'message' => 'Hi ' . $user->name,
                  'accessToken' => $token,
                  'token_type' => 'Bearer',
                  'employee' => $employee,
                  'user' => $user
            ]);
      }

      public function logout()
      {
            auth()->user()->tokens()->delete();
            return [
                  'message' => 'You have successfully logged out and the token has successfully deleted'
            ];
      }
}
