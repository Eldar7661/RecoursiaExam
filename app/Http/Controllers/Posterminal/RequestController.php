<?php

namespace App\Http\Controllers\Posterminal;

use App\Http\Controllers\Controller;
use App\Models\Posterminal;
use App\Models\Posterminal_request;
use App\Models\Posterminal_theme;
use Illuminate\Http\Request;
use App\Http\Requests\Posterminal\RequestCreateRequest;
use App\Http\Requests\Posterminal\RequestCloseRequest;

class RequestController extends Controller
{
    public function show()
    {
        $this->authorize('requestShow', auth()->user());
        try {
            $requests = Posterminal_request::with('posterminal', 'theme', 'solution')->get();
            $posterminals = Posterminal::all();
            $theme = Posterminal_theme::with('solutions')->get();
            return response()->json(['200', $requests, $posterminals, $theme]);
        } catch (\Throwable $th) {
            $th->methodt = 'requestShow error';
            return response()->json(['95', $th]);
        }
    }

    public function create(RequestCreateRequest $data)
    {
        $this->authorize('requestCreate', auth()->user());
        $request = $data->validated();
        try {
            Posterminal_request::create($request);
        } catch (\Throwable $th) {
            $th->methodt = 'requestCreate error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function inWork(Request $data)
    {
        $this->authorize('requestInWork', auth()->user());
        try {
            Posterminal_request::find($data['id'])
                ->update([
                    'status' => 1,
                ]);
        } catch (\Throwable $th) {
            $th->methodt = 'requestInWork error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function close(RequestCloseRequest $data)
    {
        $this->authorize('requestClose', auth()->user());
        $request = $data->validated();
        try {
            Posterminal_request::find($request['id'])
                ->update([
                    'status' => 2,
                    'solution_id' => $request['solution_id'],
                ]);
        } catch (\Throwable $th) {
            $th->methodt = 'requestClose error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function cancel(Request $data)
    {
        $this->authorize('requestCancel', auth()->user());
        try {
            Posterminal_request::find($data['id'])
                ->update([
                    'status' => 3,
                ]);
        } catch (\Throwable $th) {
            $th->methodt = 'requestCancel error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }
}
