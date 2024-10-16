<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiForgotPasswordController extends Controller
{

    private function jsonResponse($status, $message, $data = null, $code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function sendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return $this->jsonResponse('Error', $validator->errors()->first(), null, 422);
            }

            $user = User::where('email', $request->email)->first();

            // Generate OTP unik
            $otp = $this->generateUniqueOtp();

            // Update OTP pengguna di database
            $user->otp = $otp;
            $user->save();

            Mail::to($user->email)->send(new OtpMail($otp));

            return $this->jsonResponse('Success', 'OTP sent successfully', null, 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Error', 'Failed to send OTP: ' . $e->getMessage(), null, 500);
        }
    }

    private function generateUniqueOtp()
    {
        $timestamp = now()->timestamp;
        $random = mt_rand(100000, 999999);
        $otp = substr($timestamp . $random, -6);

        // Pastikan OTP belum digunakan
        while (User::where('otp', $otp)->exists()) {
            $random = mt_rand(100000, 999999);
            $otp = substr($timestamp . $random, -6);
        }

        return $otp;
    }
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->jsonResponse('Error', $validator->errors()->first(), null, 422);
            }

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$user) {
                return $this->jsonResponse('Error', 'Invalid OTP', null, 401);
            }

            return $this->jsonResponse('Success', 'OTP verified successfully', null, 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Error', 'Failed to verify OTP: ' . $e->getMessage(), null, 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return $this->jsonResponse('Error', $validator->errors()->first(), null, 422);
            }

            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if (!$user) {
                return $this->jsonResponse('Error', 'Invalid OTP', null, 401);
            }

            $user->password = Hash::make($request->password);
            $user->otp = null;
            $user->save();

            return $this->jsonResponse('Success', 'Password reset successfully', null, 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Error', 'Failed to reset password: ' . $e->getMessage(), null, 500);
        }
    }
}
