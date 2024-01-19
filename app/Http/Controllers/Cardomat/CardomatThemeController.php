<?php

namespace App\Http\Controllers\Cardomat;

use App\Http\Controllers\Controller;
use App\Models\Cardomat_themes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardomatThemeController extends Controller
{
    public function index(): JsonResponse
    {
        $defectives = Cardomat_themes::all();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'defectives' => $defectives,
        ], 200);
    }

    public function create(Request $request): JsonResponse
    {
        Cardomat_themes::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $defectives = Cardomat_themes::all();

        return response()->json([
            'status' => true,
            'message' => 'Product successfully created!',
            'defectives' => $defectives,
        ], 200);
    }

    public function edit(Request $request): JsonResponse
    {
        Cardomat_themes::find($request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $defectives = Cardomat_themes::all();

        return response()->json([
            'status'=> true,
            'message'=> 'Product successfully updated',
            'defectives' => $defectives,
        ], 200);
    }

    public function delete($id)
    {
        $defective = Cardomat_themes::find($id);

        if (!$defective) {
            return response()->json([
                'status' => false,
                'message' => 'defective not found'
            ], 404);
        }

        $defective->delete();

        $defectives = Cardomat_themes::all();

        return response()->json([
            'status' => true,
            'message' => 'defective deleted successfully',
            'defectives' => $defectives,
        ]);
    }

    public function find()
    {
        try {
            $themes = Cardomat_themes::all();

            return response()->json([
                'themes' => $themes,
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => false
            ], 500);
        }
    }
}
