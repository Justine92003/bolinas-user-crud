<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
 
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('users/create')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Create a new user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash the password
        ]);

        Session::flash('message', 'Successfully created user!');
        return Redirect::to('users');
    }

    // Display the specified user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
     $user = User::find($id);
    if (!$user) {
        // Log or handle the case where the user is not found
        return redirect()->route('users.index')->withErrors('User  not found.');
    }
    return view('user.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
      
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('users/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

      
        $user = User::findOrFail($id); 
        $user->name = $request->input('name');
        $user->email = $request->input('email');


        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        Session::flash('message', 'Successfully updated user!');
        return Redirect::to('users');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Session::flash('message', 'Successfully deleted the user!');
        return Redirect::to('users');
    }
}