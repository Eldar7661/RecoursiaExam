<?php

namespace App\Http\Controllers\Posterminal;

use App\Http\Controllers\Controller;
use App\Models\Posterminal_request;
use Illuminate\Http\Request;
use App\Http\Requests\Posterminal\RequestCreateRequest;

class RequestController extends Controller
{
    public function show()
    {
        try {
            $query = Posterminal_request::with('posterminal', 'theme', 'solution')->get();
            return response()->json(['200', $query]);
        } catch (\Throwable $th) {
            dd($th);
            $th->methodt = 'requestShow error';
            return response()->json(['95', $th]);
        }
    }

    public function create(RequestCreateRequest $data)
    {
        $request = $data->validated();
        try {
            Posterminal_request::create($request);
        } catch (\Throwable $th) {
            $th->methodt = 'requestCreate error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function update(Request $data)
    {
        try {
            Posterminal_request::find($data['id'])
                ->update([
                    'status' => $data['status'],
                    'solution_id' => $data['solution_id'],

                ]);
        } catch (\Throwable $th) {
            $th->methodt = 'requestCanceled error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }
}
