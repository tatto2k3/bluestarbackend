<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\UserMeta;
use Tymon\JWTAuth\Exceptions\JWTException;
use Google\Client;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'handleGoogleLogin']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = [
            'user_id' => auth()->user()->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl'),
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($data);

        return $this->respondWithToken($token, $refreshToken);
    }

    public function profile()
    {
        try {
            return response()->json(auth()->user());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $refreshToken = request()->refresh_token;
        try {

            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decoded['user_id']);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            auth()->invalidate();

            $token = auth()->login($user);
            $refreshToken = $this->createRefreshToken($user);

            return $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $e) {
            return response()->json(['error' => 'RefreshToken is invalid'], 400);
        }
    }

    protected function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    private function createRefreshToken($user)
    {
        $data = [
            'user_id' => $user->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl'),
        ];

        return JWTAuth::getJWTProvider()->encode($data);
    }

    public function handleGoogleLogin(Request $request)
    {
        try {
            $googleToken = $request->input('token');

            if (!$googleToken) {
                return response()->json(['error' => 'Token is missing'], 400);
            }

            $client = new Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $payload = $client->verifyIdToken($googleToken);

            if (!$payload) {
                return response()->json(['error' => 'Invalid Google Token'], 400);
            }

            $googleId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];
            $avatar = $payload['picture'] ?? null;

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $googleId,
                    'password' => Hash::make('123456'),
                ]);

                $user_meta = [
                    'full_name' => $payload['name'],
                    'given_name' => $payload['given_name'],
                    'family_name' => $payload['family_name'],
                    'email' => $payload['email'],
                    'picture' => $payload['picture']
                ];

                $user_meta_save = UserMeta::create([
                    'user_id' => $user->id,
                    'meta' => json_encode($user_meta),
                ]);
            }

            $token = JWTAuth::fromUser($user);
            $refreshToken = $this->createRefreshToken($user);

            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'refresh_token' => $refreshToken,
                'user' => $user,
                'avatar' => $avatar
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
