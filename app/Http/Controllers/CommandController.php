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
        $user = Auth::user();
        $sector = $user->sector_id;
        $isBot = $user->is_bot;

        try {
            if($isBot) {
                return Command::with('replies', 'sector')
                    ->whereNull('parent_id')
                    ->get();
            }

            return Command::where('sector_id', $sector)
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
        $user = Auth::user();
        $sector = $user->sector_id;
        $isBot = $user->is_bot;

        try {
            return Command::create([
                'name' => $request->input('name'),
                'return' => $request->input('return'),
                'sector_id' => $sector,
                'parent_id' => $request->input('parent_id')
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
            ], 500);
        }
    }

    public function start($id)
    {
        try {
            return Command::where('sector_id', $id)
                ->whereNull('parent_id')
                ->with('replies', 'sector')
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $sector = $user->sector_id;
        $isBot = $user->is_bot;
        
        try {
            $command = Command::findOrFail($id);

            if ($command->parent_id === null) {
                $command = Command::with('replies', 'sector')->find($id);
            }

            if ($command) {
                $command->name = $request->input('name');
                $command->return = $request->input('return');
                $command->sector_id = $sector;
                $command->parent_id = $request->input('parent_id');

                $command->save();

                return response()->json([
                    'message' => 'Comando atualizado!'
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
                    'message' => 'A impossibilidade de excluir o comando. Ele está sendo utilizado como pai por outros comandos.'
                ], 403);
            }

            $command->delete();

            return response(200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}