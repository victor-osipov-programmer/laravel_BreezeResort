<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Http\Resources\UsersInRoom;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Room::class);

        $rooms = Room::all();

        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Room::class);

        $data = $request->validate([
            'name' => 'required',
            'desc_data' => 'required',
        ]);

        Room::create($data);

        return response()->json([
            'data' => [
                'message' => 'Created'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Room $room)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        Gate::authorize('delete', $room);
        $room->delete();

        return response()->json([
            'data' => [
                'message' => 'Deleted'
            ]
        ]);
    }

    public function getUsersInRooms(Room $room)
    {
        Gate::authorize('viewAny', Room::class);
        Gate::authorize('viewAny', User::class);
        
        $rooms = Room::with('users')->get();
        
        return UsersInRoom::collection($rooms);
    }
}
