<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Exception;
use App\Models\Command;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index()
    {
        try {
            return Command::all();
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
                'name' => Str::lower(Str::ascii($request->input('name'))),
                'return' => $request->input('return')
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
            return Command::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $command = Command::find($id);

            if ($command) {
                $command->name = Str::lower(Str::ascii($request->input('name')));
                $command->return = $request->input('return');

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
