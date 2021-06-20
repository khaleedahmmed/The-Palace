<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helper\helper;
use Validator;
use Auth;


class AuthController extends Controller
{

    use ResponseTrait;

    //register
    public function register(Request $request)
    {
        $data = $request->validate(
            [
                'name'          => 'required|min:3|max:191',
                'email'         => 'required|email|unique:users,email',
                'password'      => 'required|confirmed|min:6|max:191',
                'phone'         => 'required',
                'image'         =>'nullable'
            ]);
           
           if($request->image != null){
            $data['image']      = Helper::imageUploade($data['image'], 'users');    
           }
            $data['password']   = bcrypt($request->password);
            $user               = User::create($data);

             $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('api')->attempt($credentials);  //generate token

            if (!$token)
                return $this->error(trans('api.invalid_loggin'),401);
        
            $user = Auth::guard('api')->user();
            $user ->api_token = $token;
            //return token
            return $this->response($user);  //return json response
    }

    //login 
    public function login(Request $request)
    {

        $data = Validator::make($request->all(),
        [
                "email"    => "required",
                "password" => "required"
        ]);

            if ($data->fails()) {
                
                return $this->error(trans('api.invalid_loggin'), $data->errors());
            }

            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('api')->attempt($credentials);  //generate token

            if (!$token)
                return $this->error(trans('api.invalid_loggin'),401);
        
            $user = Auth::guard('api')->user();
            $user ->api_token = $token;
            //return token
            return $this->response($user);  //return json response
    }

    public function logout(Request $request)
    {
        
         $token = $request->bearerToken();
        if($token){
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
                
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                
                return  $this->error(trans('api.wrong'));
            }
            return $this->response([],trans('api.Logged_out'));
        }else{
            
            return  $this->error(trans('api.wrong'));
        }

    }

    //login with social media
    public function socialLogin(Request $request)
    {
        $data = $request->validate(
        [   'social_id' => 'required|string|max:255',
            'name' =>   'required|string|max:255',
            'email' => 'required|email|email',
        ]);
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            $token=JWTAuth::fromUser($user);
            if (!$token)
                return $this->error(trans('api.invalid_loggin'),401);
           $user ->social_id = $request->social_id;
           $user ->update();
           $user ->api_token = $token;
            //return token
            return $this->response($user); 
        } else {
           
            $newUser        = User::create($data);
            $user = User::where('email', $request->email)->first();
            $token=JWTAuth::fromUser($user);

           if (!$token)
             return $this->error(trans('api.invalid_loggin'),401);
       
          
           $user ->api_token = $token;
           //return token
           return $this->response($user);  //return json response
        }
           
    }
    public function profile(Request $request)
    {
       
           return $this->response(auth()->user());  
        }
           
    
}
