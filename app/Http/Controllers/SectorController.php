<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {
        try {
            return Sector::all();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            return Sector::create([
                'name' => $request->input('name')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            return Sector::find($id);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sector = Sector::find($id);

            if ($sector) {
                $sector->name = $request->input('name');

                $sector->save();

                return response()->json([
                    'message' => 'Sector Updated'
                ], 200);
            }
            
            return response()->json([
                'message' => 'Sector Not Found'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $sector = Sector::findOrFail($id);

            $sector->delete();

            return response()->json([
                'message' => 'Sector Deleted'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
