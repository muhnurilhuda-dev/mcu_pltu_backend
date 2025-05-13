<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(SignupRequest $request) {
        $data = $request->validated();

        /** @var User $user  */
        $user = User::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'status_aktif' => $data['status_aktif'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // return response(compact('user', 'token'));

        return response()->json([
            'user' => $user,
            'token' => $token,
            'redirect_url' => '/dashboard'
        ]);
    }

    // private function getRedirectUrl($jabatan) {
    //     $routes = [
    //         'safety_officer' => '/dashboard/safety',
    //         'permit_applicant' => '/dashboard/permit-applicant',
    //         'tim_medis' => '/dashboard/medical',
    //         'asisten_manajer_k3' => '/dashboard/k3-manager',
    //     ];

    //     return $routes[$jabatan] ?? '/dashboard';
    // }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)){
            return response([
                'message' => 'Provided email or password is incorrect'
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }

    public function logout (Request $request) {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
