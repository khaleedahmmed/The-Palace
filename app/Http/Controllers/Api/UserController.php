<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Traits\ResponseTrait;
use App\Helper\helper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response(User::where('isAdmin','!=', 1)->get());  
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

            return $this->response([],"User created successfully");  //return json response
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =User::where('isAdmin','!=', 1)->find($id);  
         if(!$user){
            return $this->error('This user is not found');
         }
        return $this->response($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data= $request->all();
        $user = User::where('isAdmin','!=', 1)->find($id);  
        if(!$user){
            return $this->error('This user is not found');
         } 
         if(isset($data['image'])){  
        $data['image'] = Helper::imageUploade($data['image'], 'users');
         }
        $user->update($data);
        return $this->response([],'Updated succssfully'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('isAdmin','!=', 1)->find($id);
        if(!$user){
            return $this->error('This user is not found');
         }
         $user->delete();
        return $this->response([],'Deleted succssfully'); 

    }
}
