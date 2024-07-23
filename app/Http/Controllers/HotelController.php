<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Http\Resources\UsersInRoomsInHotel;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Hotel::class);

        $hotels = Hotel::all(); 

        return HotelResource::collection($hotels);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Hotel::class);

        $data = $request->validate([
            'name' => 'required|unique:hotels',
            'number' => 'required|unique:hotels'
        ]);

        $hotel = Hotel::create($data);

        return response()->json([
            'data' => [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'number' => $hotel->number
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        Gate::authorize('delete', $hotel);
        $hotel->delete();

        return response()->json([
            'data' => [
                'message' => 'Deleted'
            ]
        ]);
    }
    public function addRoomInHotel(Hotel $hotel, Room $room)
    {
        Gate::authorize('view', $hotel);
        Gate::authorize('update', $room);

        $room->hotel_id = $hotel->id;
        $room->save();

        return response()->json([
            'data' => [
                'name' => $hotel->name,
                'title' => 'Название'
            ]
        ]);
    }
    public function getRoomsInHotels()
    {
        Gate::authorize('viewAny', Hotel::class);
        Gate::authorize('viewAny', Room::class);
        Gate::authorize('viewAny', User::class);
        
        $hotels = Hotel::with('rooms.users')->get();

        return UsersInRoomsInHotel::collection($hotels);
    }
}
