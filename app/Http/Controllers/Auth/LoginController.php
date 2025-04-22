<?php

namespace App\Http\Controllers\Auth;

use App\Application\User\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function __construct(protected LoginService $service) {}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $token = $this->service->attempt($request->email, $request->password);

        if (! $token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }
}
