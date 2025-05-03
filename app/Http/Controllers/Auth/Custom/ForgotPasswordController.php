<?php

namespace App\Http\Controllers\Auth\Custom;

use App\Http\Controllers\Controller;
use App\Jobs\SendSiabResetPassword;
use App\Models\PpdbModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendSiabResetPassword(Request $request)
    {
        // Find email
        $userDetail = PpdbModel::where('nis', $request->nis)->first();

        // Email params
        $params = [
            'nis' => $request->nis,
            'email' => $userDetail->email,
            'token' => Str::random(64),
        ];

        $check = DB::table('password_resets')->where('email', $userDetail->email)->first();
        if (empty($check)) {
            // Create password reset token
            DB::table('password_resets')->insert([
                    'email' => $userDetail->email,
                    'token' => Hash::make($params['token']),
                    'created_at' => now(),
                ]);
    
            SendSiabResetPassword::dispatch(
                $params,
                [
                    'email' => $userDetail->email,
                    'name' => $userDetail->nama,
                ]
            );
    
            return redirect()
                ->route('login', ['apps' => 'siab'])
                ->with('status', [
                    'type' => 'success',
                    'message' => 'Tautan reset password berhasil dikirim melalui email',
                ]);
        } else {
            // Update token
            DB::table('password_resets')
                ->where('email', $userDetail->email)
                ->update([
                    'token' => Hash::make($params['token']),
                    'created_at' => now(),
                ]);

            SendSiabResetPassword::dispatch(
                $params,
                [
                    'email' => $userDetail->email,
                    'name' => $userDetail->nama,
                ]
            );
            
            return redirect()
                ->route('login', ['apps' => 'siab'])
                ->with('status', [
                    'type' => 'success',
                    'message' => 'Tautan reset password berhasil dikirim ulang melalui email',
                ]);
        }

    }

    public function updateSiabPassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data_password_reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!empty($data_password_reset)) {
            if (Hash::check($request->token, $data_password_reset->token)) {
                // Update password
                DB::table('users')
                    ->where('username', $request->nis)
                    ->update([
                        'password' => Hash::make($request->password),
                    ]);
    
    
                // Delete password reset token
                DB::table('password_resets')
                    ->where('email', $request->email)
                    ->delete();
    
                return redirect()
                    ->route('login', ['apps' => 'siab'])
                    ->with('status', [
                        'type' => 'success',
                        'message' => 'Password berhasil diubah',
                    ]);
            } else {
                return redirect()
                    ->route('login', ['apps' => 'siab'])
                    ->with('status', [
                        'type' => 'error',
                        'message' => 'Password gagal diubah, token yang digunakan telah kadaluwarsa. Silahkan melakukan reset password kembali.',
                    ]);
            }
        } else {
            return redirect()
                    ->route('login', ['apps' => 'siab'])
                    ->with('status', [
                        'type' => 'error',
                        'message' => 'Anda belum pernah melakukan reset password, silahkan melakukan reset password terlebih dahulu',
                    ]);
        }
    }
}
