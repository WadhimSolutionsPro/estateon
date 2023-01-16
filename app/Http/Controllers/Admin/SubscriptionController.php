<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SubscriptionPlan;
use App\UserSubscription;
class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = SubscriptionPlan::where('status', 1)->get();
        return view('admin.subsription_plans.index', compact(['plans']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subsription_plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $plan = SubscriptionPlan::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'time_in_monthes' => $data['time_in_monthes'],
            'features' => $data['features'],
            'status' => 1
        ]);
        return redirect()->route('admin.subscription.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = SubscriptionPlan::where('id', $id)->first();
        return view('admin.subsription_plans.show', compact(['plan']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = SubscriptionPlan::where('id', $id)->first();
        return view('admin.subsription_plans.edit', compact(['plan']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update($request->all());

        return redirect()->route('admin.subscription.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = SubscriptionPlan::where('id', $id)->update(['status'=>0]);
        return redirect()->route('admin.subscription.index');
    }

    public function usersubscription(Request $request){
        $params = $request->all();
        $subscriptions=UserSubscription::query();
        if(isset($params['active'])){
            if($params['active']==true){
                $subscriptions->where('status', 1);
            }
        }
        $usersubscription = $subscriptions->with(['user', 'plan', 'payment'])->paginate(10);
        return view('admin.usersubscription.index', compact(['usersubscription', 'params']));
    }

    public function subscriptiondetail($id){
        $usersubscription = UserSubscription::where('id', $id)->with(['user', 'plan', 'payment'])->first();
    //    echo "<pre>"; print_r($usersubscription->toArray());
    //    exit;
        return view('admin.usersubscription.show', compact(['usersubscription']));
    }
}
