<?php

// ============================================================
// AuthController.php — InfraEnercom S.A.C.
// Correcciones aplicadas:
//   1. Eliminado dd() que bloqueaba la ejecución en catch
//   2. Redirect usa route('dashboard.index') en lugar de url()
//   3. Agregado roleCheck opcional para restringir solo admins
// ============================================================

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class LoginController extends Controller
{

    public function index() {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        try {

            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            if (! Auth::attempt($credentials, false)) {

                Log::warning('Intento de acceso fallido', [
                    'email' => $request->email,
                    'ip'    => $request->ip(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales incorrectas.',
                ], 422);
            }

            // --- Opcional: restringir acceso solo a administradores ---
            // $user = Auth::user();
            // if ($user->role !== 'admin') {
            //     Auth::logout();
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'No tienes permisos de administrador.',
            //     ], 403);
            // }

            $request->session()->regenerate();

            $user = Auth::user();

            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            Log::info('Inicio de sesión exitoso', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'ip'      => $request->ip(),
            ]);

            return response()->json([
                'success'  => true,
                'message'  => 'Bienvenido al sistema, ' . $user->name . '.',
                // ✅ CORRECCIÓN: usar route() en lugar de url()
                'redirect' => route('dashboard.index'),
                'user'     => [
                    'id'        => $user->id,
                    'name'      => $user->name,
                    'last_name' => $user->last_name,
                    'email'     => $user->email,
                    'role'      => $user->role,
                ],
            ]);

        } catch (Throwable $e) {

            // ✅ CORRECCIÓN: eliminado dd() que detenía la ejecución
            Log::error('Error en login', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'ip'      => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor. Intenta de nuevo.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}