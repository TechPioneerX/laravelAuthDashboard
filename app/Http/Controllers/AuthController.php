<?php

namespace App\Http\Controllers;
use App\JWTParser;
use App\User;
use App\Utils;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $apiKey = $request->header('apiKey');
        $email = $request->input('email');

        if( $email == null || $apiKey == null || empty($email) || empty($apiKey))
            return response()->json([
                'code' => 400,
                'success' => false,
                'message' => 'Please provide email address and api key.',
                'timestamp' => now()->toDateTimeString(),
                'body' => null,
            ], 400);

        // Validate the API key
        $decodedPayload = Utils::parseJWT($apiKey);
        if (empty($decodedPayload) || $decodedPayload['email'] !== $email) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Invalid API key or email',
                'timestamp' => now()->toDateTimeString(),
                'body' => null,
            ], 401);
        }

        $user = User::withTrashed()->where('email', $email)->first();
        if ($user) {
            if ($user->trashed()) {
                // User is soft-deleted
                return response()->json([
                    'code' => 401,
                    'success' => false,
                    'message' => 'Your account had been blocked.',
                    'timestamp' => now()->toDateTimeString(),
                    'body' => null,
                ], 401);
            } else {
                // User is active
                if( $user->email == $decodedPayload['email'] && $user->apiKey == $apiKey ){
                    // Authentication successful
                    return response()->json([
                        'code' => 200,
                        'success' => true,
                        'message' => 'You has been authenticated successfully!',
                        'timestamp' => now()->toDateTimeString(),
                        'body' => null,
                    ], 200);
                }
            }
        }

        // Authentication successful
        return response()->json([
            'code' => 401,
            'success' => true,
            'message' => 'Authentication result',
            'timestamp' => now()->toDateTimeString(),
            'body' => null,
        ], 200);
    }
}
