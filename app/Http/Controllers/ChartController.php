<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\Sector;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function sectors()
    {
        try {
            $sectors = Sector::all();
            $data = [];

            foreach ($sectors as $sector) {
                $count = Commit::whereHas('command', function ($query) use ($sector) {
                    $query->where('sector_id', $sector->id);
                })->count();

                $data[] = ['name' => $sector->name, 'count' => $count];
            }

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
