<?php
namespace App\Http\Controllers;
/**
 * Description of TemporaryController
 *
 * @author mfayez
 */
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Enums\AccountTypes;

class TemporaryController extends Controller {
    public function getClones(){
        $users =  User::having('countClone','>',1)->orderBy('countClone','DESC')->groupBy('email')->get(['email',DB::raw('count(*) as countClone')]);
        dump($users);
        if(empty($users)) dd('no duplicates found , horray !');
        foreach ($users as $user){
            $currentCount = $user->countClone;
            $singleUserCollection = User::having('email','=',$user->email)->where('account_type','=',AccountTypes::customer)->get(['id','email','username','first_name','last_name']);
            dump($singleUserCollection);
            $i=1;
            foreach ($singleUserCollection as $singleUser){
                if($i == $currentCount) break;
                $singleUser->email .= '_old'.$i;
                $singleUser->save();
                $i++;
                dump($singleUser);
            }
            dump('----------------------------------------------------------------');
        }
    }
}
