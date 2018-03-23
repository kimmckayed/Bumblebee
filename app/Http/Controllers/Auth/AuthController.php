<?php namespace App\Http\Controllers\Auth;

use App\Managers\ActivityManager;
use App\Managers\AuthManager;
use Auth;
use App\Http\Controllers\Controller;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;



class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/*public function authenticate()
    {	
    	var_dump('test');exit;
    	$username = Input::get('username');
		$password = bcrypt(Input::get('password'));

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }*/

    public function postLogin(Request $request)
	{
		$this->validate($request, [
			'username' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('username', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
            $user_data = Auth::user();


            try{
                $user = Sentinel::findById($user_data->id);

                $sentinel_user = Sentinel::loginAndRemember($user);
            }catch (\Exception $e){
                $user = Sentinel::findById($user_data->id);

                $sentinel_user = Sentinel::loginAndRemember($user);
            }
            $am = new AuthManager();
            if($am->isAnyRole(['master','sales','finance','company_agent','company_master','customer_service','service_company'])){
                (new ActivityManager())->userLogin($user_data->id,'normal login to the system');
                return redirect()->intended('dashboard');
            }
            Auth::logout();
            Sentinel::logout();
            return redirect($this->loginPath())

                ->withErrors(['is forbidden from login ',
                ]);

		}

		return redirect($this->loginPath())
					->withInput($request->only('username', 'remember'))
					->withErrors([
						'username' => $this->getFailedLoginMessage(),
					]);
	}


    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        if(Sentinel::check()) {
            $id = $this->auth->user()->id;
            (new ActivityManager())->userLogout($id, 'Logout to the system');
            $this->auth->logout();
            Sentinel::logout();
        }
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    public function getForceLogin($id){
        Auth::loginUsingId($id);
        $user_data = Auth::user();
        $user = Sentinel::findById($user_data->id);

        $sentinel_user = Sentinel::loginAndRemember($user);
        return \Redirect::to('dashboard');
    }

}
