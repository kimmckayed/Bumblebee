<?php 

namespace App\Http\Controllers;

use App\Managers\AuthManager;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;
    /**
     * @AuthManager AuthManager|null
     */
    public $auth_manager =  null;
    public function __construct()
    {
        $this->auth_manager = new AuthManager();

    }
}
