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
            'email'=>'required|email',
        ];
        $response = [
            'name.required'=>'name required.',
            'lastname.required'=>'last name required.',
            'email.required'=>'email required.',
            'email.email'=>'email is not valid .',
        ];
        $validator = Validaror::make($request->all(),$rules,$response)->validate();

        $user = new User;
        $user->name = e($request->input('name'));
        $user->lastname = e($request->input('lastname'));
        $user->email = e($request->input('email'));
        if($user->save()){
            return 'update successful!!';
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
            'email'=>'required|email',
        ];
        $response = [
            'name.required'=>'name required.',
            'lastname.required'=>'last name required.',
            'email.required'=>'email required.',
            'email.email'=>'email is not valid .',
        ];
        $validator = Validaror::make($request->all(),$rules,$response)->validate();
        $user = User::find($id);
        $user->name = e($request->input('name'));
        $user->lastname = e($request->input('lastname'));
        $user->email = e($request->input('email'));
        if($user->save()){
            return $user;
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
            return 'delete successful!!';
        }
    }
}
