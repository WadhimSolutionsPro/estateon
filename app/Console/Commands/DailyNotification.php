<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserFilter;
use App\User;
use App\Property;
use Illuminate\Support\Facades\DB;
use App\Notifications\AccountActivated;
class DailyNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to all user daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $userfilter=UserFilter::with('user')->get();
        
        foreach($userfilter as $filter){
            $filter->user->makeVisible('device_token');
            if($filter->user->device_token){
                $filterdata=unserialize($filter->filter); 
                if($filterdata['lat'] !="" && $filterdata['lng'] != ""){
                    $notificationdata = DB::select(DB::raw("select lat, lng, type, count(*) as aggregate from `properties` group by `type` having ( 6371 * acos(cos(radians(". $filterdata['lat'] .")) * cos( radians(lat) ) * cos( radians( lng ) - radians(".$filterdata['lng'].")) + sin(radians(".$filterdata['lat'].")) * sin(radians(lat)))) <= 30"));
                }else{
                    $notificationdata = DB::select(DB::raw("select lat, lng, type, count(*) as aggregate from `properties` group by `type`"));
                }       
                
                $data['msg']='';
if(count($notificationdata)>0){
    foreach($notificationdata as $index=>$notification){
        if($index==0){
            $data['msg'] = "You have ". $notification->aggregate. " ". $notification->type. ' properties';
        }
        if($index == count($notificationdata)-1 && $index !=0){
            $data['msg'] .= " and ". $notification->aggregate. " ". $notification->type. ' properties';
        }
        if($index == count($notificationdata)-1){
            $data['msg'] .= " near you";
        }
    }
    // $data['msg'] = "You have ". $notificationdata[0]->aggregate. " ". $notificationdata[0]->type. ' properties and '. $notificationdata[1]->aggregate. " ". $notificationdata[1]->type. ' properties near you';
                    $usernotification['title']=$filter->user->name;
                    $usernotification['data']=['type'=>'nearby'];
                    $usernotification['body']=$data['msg'];
                    $filter->user->notify(new AccountActivated($usernotification));

}
           
//}

                // if($userdata->device_token){
                //     $notification['title']=$user->name;
                //     $notification['data']=['c_id'=>"$id", 'name'=>$userdata->name, 'email'=>$userdata->email, 'user_id'=>"$userdata->id", 'type'=>'message'];
                //     $notification['body']=$data['msg'];
                //     $userdata->notify(new AccountActivated($notification));
                // }






                // $property = Property::where('status', 1)
                // ->selectRaw(" *,( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$filterdata['lat'], $filterdata['lng'], $filterdata['lat']])
                // ->having("distance", "<=", 30)->groupBy('type')
                // ->when($filterdata['lat'], function($query) use($filterdata){
                //     $query->selectRaw(" *,( 6371 * acos( cos( radians(?) ) * cos( radians( lat ) )* cos( radians( lng ) - radians(?)) + sin( radians(?) ) * sin( radians( lat ) ) )) AS distance", [$filterdata['lat'], $filterdata['lng'], $filterdata['lat']])
                //         ->having("distance", "<=", 30);
                // }) 
              //  ->select('type', DB::raw('count(*) as total'))
             //  ->groupBy('type')
               
                // if($filter->lat){
                //     if($filter->lng){
                //         $property->selectRaw(" * ,
                //         ( 6371 * acos( cos( radians(?) ) *
                //           cos( radians( lat ) )
                //           * cos( radians( lng ) - radians(?)
                //           ) + sin( radians(?) ) *
                //           sin( radians( lat ) ) )
                //         ) AS distance",$filter->lat, $filter->lng, $filter->lat)
                //             ->having("distance", "<=", $radius)
                //             ->orderBy("distance", 'asc');
                //     }
                // }
                // $property->get();
                // $property->select('type', DB::raw('count(*) as total'))
                // ->groupBy('type')->get();
            }
            
        }
       // $data=$userfilter[0]->filter;
        $this->info(json_encode($data['msg']));
    }
}
