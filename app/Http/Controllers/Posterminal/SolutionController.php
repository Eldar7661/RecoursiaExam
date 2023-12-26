<?php

namespace App\Http\Controllers\Posterminal;

use App\Http\Controllers\Controller;
use App\Models\Posterminal_solution;
use Illuminate\Http\Request;
use App\Http\Requests\Posterminal\SolutionCreateRequest;
use App\Http\Requests\Posterminal\SolutionUpdateRequest;

class SolutionController extends Controller
{
    public function show()
    {
        try {
            $query = Posterminal_solution::with('theme')->get();
            return response()->json(['200', $query]);
        } catch (\Throwable $th) {
            $th->methodt = 'solutionShow error';
            return response()->json(['95', $th]);
        }
    }

    public function create(SolutionCreateRequest $data)
    {
        $solution = $data->validated();
        try {
            Posterminal_solution::create($solution);
        } catch (\Throwable $th) {
            $th->methodt = 'solutionCreate error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function update(SolutionUpdateRequest $data)
    {
        $solution = $data->validated();
        try {
            Posterminal_solution::find($solution['id'])->update($solution);
        } catch (\Throwable $th) {
            $th->methodt = 'solutionUpdate error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function delete(Request $data)
    {
        try {
            Posterminal_solution::find($data['id'])->delete();
        } catch (\Throwable $th) {
            $th->methodt = 'solutionDelete error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }
}
