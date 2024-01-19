<?php

namespace App\Http\Controllers\Cardomat;

use App\Http\Controllers\Controller;
use App\Models\Cardomat_solutions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardomatSolutionsController extends Controller
{
    public function index(): JsonResponse
    {
        $solutions = Cardomat_solutions::with('theme')->get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'solutions' => $solutions,
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        Cardomat_solutions::create([
            'theme_id' => $request->theme_id,
            'title' => $request->title,
        ]);

        $solutions = Cardomat_solutions::with('theme')->get();

        return response()->json([
            'status' => true,
            'message' => 'Product successfully created!',
            'solutions' => $solutions,
        ], 200);
    }

    public function edit(Request $request): JsonResponse
    {
        Cardomat_solutions::find($request->id)->update([
            'theme_id' => $request->theme_id,
            'title' => $request->title,
        ]);

        $solutions = Cardomat_solutions::with('theme')->get();

        return response()->json([
            'status'=> true,
            'message'=> 'Product successfully updated',
            'solutions' => $olutions,
        ], 200);
    }

    public function delete($id)
    {
        $solutions = Cardomat_solutions::find($id);

        if (!$solutions) {
            return response()->json([
                'status' => false,
                'message' => 'solution not found'
            ], 404);
        }

        $solutions->delete();

        $solutions = Cardomat_solutions::with('theme')->get();

        return response()->json([
            'status' => true,
            'message' => 'solution deleted successfully',
            'solutions' => $solutions,
        ]);
    }
}
