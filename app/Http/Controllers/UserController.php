<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $auth = auth::user();
        $models = User::where('active', '1')->get();

        return view('user', compact('models','auth'));
    }

    public function create()
    {
        $auth = auth::user();

        return view('users.create',compact('auth'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|max:32',
            'email' => 'required|email',
            'position' => 'required|string|required|max:255',
            'password' => 'required|string|required|max:255'
        ]);
        $users = new User();
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->position = $request->input('position');
        $users->password = password_hash($request->input('password'),PASSWORD_DEFAULT);
        $users->save();

        // Additional logic or redirection after successful data storage

        return redirect()->back()->with('success', 'Comment stored successfully!');
    }

    public function edit($id)
    {
        $auth = auth::user();
        $models = User::findOrFail($id);

        return view('users.edit', compact('auth','models'));
    }

    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->position = $request->input('position');
        $users->password = password_hash($request->input('password'),PASSWORD_DEFAULT);
        
        $users->save();

        return redirect('/user')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        // dd($id);
        $users = User::findOrFail($id);
        $users->active = '0';
        $users->save();

        return redirect('/user')->with('success', 'User Deleted successfully');
    }
}
