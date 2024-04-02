<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Exception;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $sectorId = $user->sector_id;

            return Command::where('sector_id', $sectorId)
                ->whereNull('parent_id')
                ->with('replies', 'sector')
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            return Command::create([
                'name' => $request->input('name'),
                'return' => $request->input('return'),
                'sector_id' => $request->input('sector'),
                'parent_id' => $request->input('parent')
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
            $command = Command::findOrFail($id);

            if ($command->parent_id === null) {
                $command = Command::with('replies', 'sector')->find($id);
            }

            return $command;
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $command = Command::findOrFail($id);

            if ($command->parent_id === null) {
                $command = Command::with('replies', 'sector')->find($id);
            }

            if ($command) {
                $command->name = $request->input('name');
                $command->return = $request->input('return');
                $command->sector_id = $request->input('sector');
                $command->parent_id = $request->input('parent');

                $command->save();

                return response()->json([
                    'message' => 'Command Updated'
                ], 200);
            }
            
            return response()->json([
                'message' => 'Command Not Found'
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
            $command = Command::findOrFail($id);

            $childCommands = Command::where('parent_id', $id)->exists();

            if ($childCommands) {
                return response()->json([
                    'message' => 'Unable to delete command. It is being used as a parent by other commands.'
                ], 403);
            }

            $command->delete();

            return response()->json([
                'message' => 'Command Deleted'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}