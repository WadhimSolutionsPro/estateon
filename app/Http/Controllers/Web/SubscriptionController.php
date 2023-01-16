<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\SubscriptionPlan;
use App\UserSubscription;
use App\Payment;

class SubscriptionController extends Controller
{
    public function startpayu(Request $request)
    {
        $data = $request->all();
        $plan_id = $data['plan_id'];
        $plan = SubscriptionPlan::where('id', $plan_id)->first();
        $user = Auth::guard('frontuser')->user();
        // echo "<pre>";
        // print_r($user->toArray());
        // exit;
        return view('estate.confirmpayment', compact(['plan', 'user']));
    }
    public function pay(Request $request)
    {
        $data = $request->all();
        $plan_id = $data['plan_id'];
        $plan = SubscriptionPlan::where('id', $plan_id)->first();
        $transaction_id = 'TXN_' . uniqid();
        \Payumoney::pay([
            'txnid'       => $transaction_id,
            'amount'      => $plan->price,
            'productinfo' => $plan->name,
            'firstname'   => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'udf1'        => $plan_id,
            'surl'        => url('payment/response'),
            'furl'        => url('payment/response'),
        ])->send();
    }
    public function paymentresponse(Request $request)
    {
        $data = $request->all();
        $user = Auth::guard('frontuser')->user();
        $result = \Payumoney::completePay($data);
        $status = false;
        if ($result->checksumIsValid() and $result->isSuccess()) {
            $payment = Payment::create([
                'user_id' => $user->id,
                'txnid' => $data['txnid'],
                'amount' => $data['amount'],
                'date' => $data['addedon'],
                'name' => $data['firstname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'plan_id' => $data['udf1']
            ]);
            if ($data['udf1'] != "") {
                $plan = SubscriptionPlan::where('id', $data['udf1'])->first();
                $startdate = $data['addedon'];
                $endDate = date('Y-m-d', strtotime("+" . $plan->time_in_monthes . " months", strtotime($startdate)));
                $usersubscription = UserSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $data['udf1'],
                    'payment_id' => $payment->id,
                    'start_at' => $startdate, 'end_at' => $endDate,
                    'status' => '1',
                    'notes' => ''
                ]);
            }

            $status = true;
        } else {
            $status = false;
        }
        return view('estate.paymentsuccess', compact(['status']));
    }
}
