<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Traits\ResponseTrait;
use App\Helper\helper;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response(User::where('isAdmin',1)->get());  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin =User::where('isAdmin', 1)->find($id);  
         if(!$admin){
            return $this->error('This Admin is not found');
         }
        return $this->response($admin);
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
        $admin = User::where('isAdmin',1)->find($id);  
        if(!$admin){
            return $this->error('This Admin is not found');
         } 
         if(isset($data['image'])){  
        $data['image'] = Helper::imageUploade($data['image'], 'admins');
         }
        $admin->update($data);
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
       $admin=User::where('isAdmin',1)->find($id);
       if(!$admin){
        return $this->error('This Admin is not found');
     } 
       $admin->delete();
        return $this->response([],'Deleted succssfully'); 

    }

    public function makeAdmin($id)
    {
       $user = User::find($id);
       if(!$user){
        return $this->error('This User is not found');
     } 

       $user->isAdmin = 1;
       $user->update();

        return $this->response([],'The user now is admin'); 

    }
}
