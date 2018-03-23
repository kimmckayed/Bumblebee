<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAgentRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username'=> 'required|unique:users',
            'agent_phone_number' => 'numeric',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|email|unique:users',
            'role' => 'required'
		];
	}

}
