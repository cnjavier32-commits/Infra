<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function sendCode(Request $request)
    {
        try {

            $request->validate([
                'email' => ['required', 'email'],
            ]);

            $user = User::where(
                'email',
                $request->email
            )->first();

            if (! $user) {

                return response()->json([
                    'success' => false,
                    'message' => 'El correo electrónico no se encuentra registrado.',
                ], 404);

            }

            $otp = str_pad(
                random_int(0, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );

            DB::table('password_reset_tokens')
                ->updateOrInsert(
                    ['email' => $user->email],
                    [
                        'token' => Hash::make($otp),
                        'created_at' => now(),
                    ]
                );

            Mail::to($user->email)
                ->send(
                    new PasswordResetOtpMail(
                        $otp,
                        $user->name
                    )
                );

            Log::info('Código OTP enviado', [
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Código enviado correctamente al correo registrado.',
            ]);

        } catch (\Throwable $e) {

            Log::error('Error enviando OTP', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor.',
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        try {

            $request->validate([
                'email' => ['required', 'email'],
                'code' => ['required', 'digits:6'],
            ]);

            $record = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (! $record) {

                return response()->json([
                    'success' => false,
                    'message' => 'No existe una solicitud activa.',
                ], 404);

            }

            $createdAt = Carbon::parse(
                $record->created_at
            );

            if ($createdAt->addMinutes(10)->isPast()) {

                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->delete();

                return response()->json([
                    'success' => false,
                    'message' => 'El código ha expirado.',
                ], 422);

            }

            Log::info('OTP DEBUG', [
                'email' => $request->email,
                'code_received' => $request->code,
                'token_exists' => ! empty($record->token),
            ]);

            Log::info('TOKEN DB', [
                'email' => $request->email,
                'created_at' => $record->created_at,
            ]);

            if (! Hash::check($request->code, $record->token)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Código incorrecto.',
                ], 422);

            }

            return response()->json([
                'success' => true,
                'message' => 'Código verificado correctamente.',
            ]);

        } catch (\Throwable $e) {

            Log::error('Error verificando OTP', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno.',
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {

            $request->validate([
                'email' => ['required', 'email'],
                'code' => ['required', 'digits:6'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
            ]);

            $record = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (! $record) {
                return response()->json([
                    'success' => false,
                    'message' => 'No existe una solicitud activa.',
                ], 404);
            }

            // Verificar que el código no haya expirado (10 min)
            if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {

                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->delete();

                return response()->json([
                    'success' => false,
                    'message' => 'El código ha expirado. Solicita uno nuevo.',
                ], 422);
            }

            // Re-verificar el código OTP por seguridad
            if (! Hash::check($request->code, $record->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código incorrecto.',
                ], 422);
            }

            // Actualizar la contraseña
            $updated = User::where('email', $request->email)
                ->update([
                    'password' => Hash::make($request->password),
                ]);

            if (! $updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró el usuario.',
                ], 404);
            }

            // Eliminar el token ya usado
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            Log::info('Contraseña restablecida', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Contraseña actualizada correctamente!',
            ]);

        } catch (\Throwable $e) {

            Log::error('Error restableciendo contraseña', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor.',
            ], 500);
        }
    }
}
