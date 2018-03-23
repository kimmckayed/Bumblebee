<?php

namespace App\Http\Controllers;


use Sentinel;
use Validator;
use Input;
use Flash;

class ProfileController extends Controller
{
    public function getIndex()
    {


        return redirect()->to('profile/security');

    }

    public function getSecurity()
    {


        return view('home.master.profile.security');

    }

    public function postSecurity()
    {
        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }
        $user = Sentinel::getUser();
        $credentials = [
            'email' => $user->email,
            'password' => Input::get('old_password'),
        ];


        $valid = Sentinel::validateCredentials($user, $credentials);
        if (!$valid) {
            Flash::error('old password not validate');

            return redirect()->back();

        }
        $user->password = bcrypt(Input::get('password'));
        $user->save();
        Flash::success('Password Changed Successfully ');

        return redirect()->back();


    }

    private function validateForm()
    {

        $validator = Validator::make(Input::all(), [

            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

}