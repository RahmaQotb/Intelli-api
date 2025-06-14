<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ResetPassController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        $resetCode = rand(100000, 999999);
        $user->reset_code = $resetCode;
        $user->reset_code_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::raw("Your reset code is: $resetCode", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset Code');
        });

        return response()->json([
            'status' => true,
            'message' => 'Reset code sent to your email.',
        ], 200);
    }

    public function verifyResetCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 400);
        }

        $user = User::where('reset_code', $request->reset_code)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid reset code.',
            ], 400);
        }

        if (Carbon::now()->greaterThan($user->reset_code_expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'Reset code has expired.',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Reset code is valid.',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }
    
        $user->password = Hash::make($request->password);
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully.',
            'data' => new UserResource($user),
        ], 200);
    }
    
}
