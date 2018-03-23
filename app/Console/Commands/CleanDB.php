<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Managers\NotificationManager;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Enums\AccountTypes;
class CleanDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'DB-clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send notification mail to agents one month prior to course start';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users =  User::whereNotNull('email')->having('countClone','>',1)->orderBy('countClone','DESC')->groupBy('email')->get(['email',DB::raw('count(*) as countClone')]);

        if($users->count() === 0){
            $this->info('no duplicates found , horray !');
        }
        $this->info('number of duplicate emails '.$users->count());
        foreach ($users as $user){
            $current_count = $user->countClone;
            $single_user_collection = User::having('email','=',$user->email)->where('account_type','=',AccountTypes::customer)->get(['id','email','username','first_name','last_name']);

            foreach ($single_user_collection as $key=> $single_user){
                if($key+1 == $current_count) {
                    break;
                }
                $single_user->email .= '_old'.$key;
                $single_user->save();
                echo '.';
            }
            $this->info('done');
        }
    }


}
