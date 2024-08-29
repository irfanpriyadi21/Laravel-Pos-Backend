<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request){
        //get data user
        // $users = \App\Models\User::paginate(10);
        $users = DB::table('users')
        ->when($request->input('name'), function($query, $name){
            return $query->where('name', 'like', '%'.$name.'%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    public function create(){
        return view('pages.users.create');
    }

    public function store(StoreUserRequest $request){
        // dd($request->all());
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        \App\Models\User::create($data);
        return redirect()->route('user.index')->with('success','User Successfully Created');
    }

    public function edit($id){
        $user = \App\Models\User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user){
        $data = $request->validated();
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User Sucessfully Updated');
    }


    public function destroy(User $user){
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Successfully Deleted');

    }





}
