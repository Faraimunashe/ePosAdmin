<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::paginate(10);
        if(isset($search))
        {
            $users = User::where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->paginate(10);
        }
        return inertia('UsersPage',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Users/CreateUserPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'is_pos_supervisor' => 'sometimes|boolean',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_pos_supervisor' => $request->has('is_pos_supervisor') ? $request->is_pos_supervisor : false,
            ]);

            if($request->has('is_pos_supervisor') && $request->is_pos_supervisor == true)
            {
                $supervisor = new Supervisor();
                $supervisor->admin_id = $user->id;
                $supervisor->password = md5($request->password);
                $supervisor->save();
            }

            return back()->withErrors(['success' => 'User created successfully']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $user = User::findOrFail($id);
            $user->delete();

            return back()->withErrors(['success' => 'Pos user deleted successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => 'Exception error']);
        }
    }
}
