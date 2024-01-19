<?php

namespace App\Http\Controllers\Postamat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Postamat\DefectiveStoreRequest;
use App\Http\Requests\Postamat\DefectiveUpdateRequest;
use App\Models\DefectivePostamat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DefectiveController extends Controller
{
    public function index(): JsonResponse
    {
        $defectives = DefectivePostamat::all();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'defectives' => $defectives
        ], 200);
    }

    public function create(DefectiveStoreRequest $request): JsonResponse
    {
        $request = $request->validated();

        $defectives = DefectivePostamat::create($request);

        $defectives = DefectivePostamat::all();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'defectives' => $defectives
        ], 200);
    }

    public function edit(DefectiveUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        DefectivePostamat::find($request->id)->update([
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        return $this->index();
    }

    public function delete(Request $request): JsonResponse
    {
        DefectivePostamat::find($request->id)->delete();

        return $this->index();
    }
}
