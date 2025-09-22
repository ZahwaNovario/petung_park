<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'scene_from' => 'required|exists:scenes,id',
            'scene_to'   => 'required|exists:scenes,id',
            'yaw'        => 'required|numeric',
            'pitch'      => 'required|numeric',
        ]);

        $connection = Connection::create($request->all());

        return response()->json([
            'success' => true,
            'connection' => $connection
        ]);
    }

    public function destroy($id)
    {
        $connection = Connection::findOrFail($id);
        $connection->delete();

        return response()->json([
            'success' => true,
            'id' => $id
        ]);
    }
}
