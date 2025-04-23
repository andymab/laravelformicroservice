<?php

namespace App\Http\Controllers\Auth;

use App\Application\User\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function __construct(protected LoginService $service) {}

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->service->attempt($request->email, $request->password);

        if (! $result) {
            return response()->json(['message' => 'Неверные данные'], 401);
        }

        return response()->json([
            'access_token' => $result['access_token'],
            'refresh_token' => $result['refresh_token'],
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $request->validate([
            'refresh_token' => 'required|string',
        ]);

        $tokens = $this->service->refreshToken($request->refresh_token);

        if (! $tokens) {
            return response()->json(['message' => 'Неверный refresh токен'], 401);
        }

        return response()->json($tokens);
    }
}
