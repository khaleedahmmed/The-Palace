<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Helper\helper;
use App\User as Model;
use Auth;


class ProfileController extends Controller
{

    use ResponseTrait;

    public function index()
    {
           return $this->response(auth()->user());  
     }


    public function update(Request $request)
    {
        $data= $request->all();
        $user = Auth::user();     
        $data['image'] = Helper::imageUploade($data['image'], 'users');
        $user->update($data);
        return $this->response([],trans('api.updated_succssfully'));  
     }
  
}
