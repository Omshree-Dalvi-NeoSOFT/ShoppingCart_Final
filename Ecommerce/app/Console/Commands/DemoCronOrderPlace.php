<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\UserDetails;
// use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class DemoCronOrderPlace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        // $q->where('created_at', '>=', date('Y-m-d').' 00:00:00'));
        $dailyorders = UserDetails::whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])->count();           
            $data = ['dailyorders'=>$dailyorders];
            $user['to'] = 'omshreedalvi98@gmail.com';
            Mail::send('email.dailyorder',$data,function($message) use ($user){
                $message->to($user['to']);
                $message->subject('Daily Order Report !');
            });
        return 0;
    }
}
