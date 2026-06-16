<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|string',
        ]);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => 'mock_order_' . rand(100000, 999999),
                'amount' => $request->amount * 100,
                'currency' => 'INR',
            ]
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|string|in:Admission,Product,Membership',
            'razorpay_payment_id' => 'nullable|string',
        ]);

        $user = $request->user();

        $payment = Payment::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_id' => $request->razorpay_payment_id ?? 'mock_pay_' . rand(100000, 999999),
            'type' => $request->type,
            'status' => 'Success',
        ]);

        if ($request->type === 'Admission') {
            if ($user->referred_by) {
                $referral = Referral::where('referred_user_id', $user->id)->first();
                if ($referral) {
                    $referral->status = 'Successful';
                    $referral->save();

                    $referrer = User::find($user->referred_by);
                    if ($referrer) {
                        $referrer->referrals_count = ($referrer->referrals_count ?? 0) + 1;
                        $referrer->save();
                    }
                }
            }
        } elseif ($request->type === 'Membership') {
            $user->membership_plan = 'premium';
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Mock payment verified successfully',
            'payment' => $payment,
        ]);
    }

    public function getMyPayments(Request $request)
    {
        $payments = Payment::where('user_id', $request->user()->id)->get();

        return response()->json([
            'success' => true,
            'count' => $payments->count(),
            'data' => $payments,
        ]);
    }
}
