<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Command;
use App\Models\Commit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitController extends Controller
{
    public function index()
    {
        try {
            // return Commit::with('user', 'command')->get();
            $user = Auth::user();
            
            return Commit::orderBy('id', 'desc')
                ->with('user', 'command')
                ->where('user_id', $user->id)
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
            $user = $request->input('user');
            $command = $request->input('command');

            if (User::find($user) && Command::find($command)) {
                return Commit::create([
                    'user_id' => $user,
                    'command_id' => $command,
                    'number_from' => $request->input('number'),
                    'answered' => false
                ]);
            }
            return response()->json([
                'message' => 'Usuário e/ou comando não existente'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        try {
            return Commit::with('user', 'command')->find($id);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $commit = Commit::find($id);

            if ($commit) {
                $commit->user_id = $request->input('user');
                $commit->command_id = $request->input('command');
                $commit->number_from = $request->input('number');

                $commit->save();

                return response()->json([
                    'message' => 'Commit Updated'
                ], 200);
            }
            
            return response()->json([
                'message' => 'Commit Not Found'
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
            $commit = Commit::findOrFail($id);

            $commit->delete();

            return response()->json([
                'message' => 'Commit Deleted'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
