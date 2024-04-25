<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Commit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitController extends Controller
{
    public function index()
    {
        try {
            return Commit::with('user', 'command', 'sector')
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $params = $request->all();

            return Commit::create($params);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            return Commit::with('user', 'command', 'sector')
                ->find($id);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
