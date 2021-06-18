<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('id','desc')->get();
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required',
            'lastname'=>'required',
            'email'=>'required|email|unique:users',
            'email.unique'=>'Email is not valid.',
        ];
        $response = [
            'name.required'=>'Name is required.',
            'lastname.required'=>'Last name is required.',
            'email.required'=>'Email is required.',
            'email.unique'=>'Email already registered.',
        ];
        $validator = Validator::make($request->all(),$rules,$response)->validate();

        $user = new User;
        $user->name = e($request->input('name'));
        $user->lastname = e($request->input('lastname'));
        $user->email = e($request->input('email'));
        if($user->save()){
            return $user;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $rules = [
            'name'=>'required',
            'lastname'=>'required',
            'email'=>'required|email|unique:users'
        ];
        $response = [
            'name.required'=>'Name is required.',
            'lastname.required'=>'Last name is required.',
            'email.required'=>'Email is required.',
            'email.email'=>'Email is not valid.',
            'email.unique'=>'Email already registered.'
        ];
        
        $validator = Validator::make($request->all(),$rules,$response)->validate();
        $user = User::find($id);
        $user->name = e($request->input('name'));
        $user->lastname = e($request->input('lastname'));
        $user->email = e($request->input('email'));
        if($user->save()){
            return 'update';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->delete()){
            return 'delete';
        }
    }
}
