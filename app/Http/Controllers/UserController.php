<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', User::class);
        $data = $request->validate([
            'fio' => 'required|unique:users|string',
            'email' => 'required|unique:users|email|string',
            'phone' => 'required|unique:users|string',
            'birth_date' => 'required|date_format:Y-m-d',
            'id_childdata' => 'required',
        ]);

        $data['role'] = 'client';
        User::create($data);

        return response()->json([
            'data' => [
                'message' => 'Created'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        $data = $request->validate([
            'fio' => 'nullable|unique:users,fio,' . $user->id . '|string',
            'email' => 'nullable|unique:users,email,' . $user->id . '|email|string',
            'phone' => 'nullable|unique:users,phone,' . $user->id . '|string',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'id_childdata' => 'nullable',
        ]);

        User::where('id', $user->id)->update($data);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'message' => 'Updated'
            ]
        ]);
    }

    public function changeRoom(Request $request, Room $room, User $user)
    {
        Gate::authorize('update', $user);

        $user->id_childdata = $room->id;
        $user->save();

        return response()->json([
            'data' => [
                'message' => 'Changed'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        $user->delete();

        return response()->json([
            'data' => [
                'message' => 'Deleted'
            ]
        ]);
    }
}
