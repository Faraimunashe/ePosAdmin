<?php

namespace App\Http\Controllers;

use App\Models\PosUser;
use Exception;
use Illuminate\Http\Request;

class PosUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = PosUser::paginate(10);
        if(isset($search))
        {
            $users = PosUser::where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->paginate(10);
        }
        return inertia('PosUsersPage',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Posusers/CreatePosUserPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.PosUser::class],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        try{
            $user = new PosUser();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = md5($request->password);
            $user->save();

            return back()->withErrors(['success' => 'Pos user created successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => 'Exception error']);
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

            $user = PosUser::findOrFail($id);
            $user->delete();

            return back()->withErrors(['success' => 'Pos user deleted successfully.']);
        }catch(Exception $e)
        {
            return back()->withErrors(['error' => 'Exception error']);
        }
    }
}
