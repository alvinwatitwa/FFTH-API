<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'c_password' => 'required|same:password',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('CodeLineApp')->accessToken;
        $success['name'] =  $user->name;


        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login (Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('FFTH')->accessToken;
                $response = [
                    'token' => $token,
                    'user' => $user
                ];

                return $this->sendResponse($response , 'User Logged in successfully.');
            } else {

                $response = ['Password missmatch'];

                return $this->sendError('Password missmatch', $response);
            }

        } else {

            $response = ['User does not exist'];

            return $this->sendError('User does not exist', $response);
        }

    }

    /**
     * Log out
     */

    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        return $this->sendResponse([] , 'You have been succesfully logged out!');

    }
}
