<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorController extends Controller
{
    /**
     * Enable 2FA for authenticated user and return QR code.
     */
    public function enable(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // Enable 2FA
        $user->enableTwoFactor();

        return response()->json([
            'success' => true,
            'qr' => $user->getQRCodeInline(),
            'secret' => $user->two_factor_secret,
        ]);
    }

    /**
     * Verify 2FA code during login or for security confirmation.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        if (!$user->verifyTwoFactorCode($request->code)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid 2FA code',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => '2FA verified successfully',
        ]);
    }

    /**
     * Disable 2FA for authenticated user.
     */
    public function disable(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user->disableTwoFactor();

        return response()->json([
            'success' => true,
            'message' => '2FA disabled successfully',
        ]);
    }
}
