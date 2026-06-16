<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function getMyReferrals(Request $request)
    {
        $user = $request->user();
        $referrals = Referral::with('referredUser:id,name,email,created_at')
            ->where('referrer_id', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $referrals->count(),
            'referralsCount' => $user->referrals_count ?? current($referrals),
            'data' => $referrals,
        ]);
    }

    public function verifyReferralCode(Request $request)
    {
        $request->validate([
            'referralCode' => 'required|string',
        ]);

        $user = User::where('referral_code', $request->referralCode)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Referral Code'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'referrerName' => $user->name,
        ]);
    }
}
