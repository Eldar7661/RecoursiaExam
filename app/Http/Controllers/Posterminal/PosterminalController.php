<?php

namespace App\Http\Controllers\Posterminal;

use App\Http\Controllers\Controller;
use App\Models\Posterminal;
use Illuminate\Http\Request;
use App\Http\Requests\Posterminal\CreateRequest;
use App\Http\Requests\Posterminal\UpdateRequest;

class PosterminalController extends Controller
{
    public function show()
    {
        try {
            $query = Posterminal::all();
            return response()->json(['200', $query]);
        } catch (\Throwable $th) {
            $th->methodt = 'show error';
            return response()->json(['95', $th]);
        }
    }

    public function create(CreateRequest $data)
    {
        $posterminal = $data->validated();
        try {
            Posterminal::create($posterminal);
        } catch (\Throwable $th) {
            $th->methodt = 'create error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function update(UpdateRequest $data)
    {
        $posterminal = $data->validated();
        try {
            Posterminal::find($posterminal['id'])->update($posterminal);
        } catch (\Throwable $th) {
            $th->methodt = 'update error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function delete(Request $data)
    {
        try {
            $posterminal = Posterminal::find($data['id']);
            $posterminal->update(['status' => '0']);
            $posterminal->delete();
        } catch (\Throwable $th) {
            $th->methodt = 'delete error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function restore(Request $data)
    {
        try {
            $posterminal = Posterminal::onlyTrashed()
                ->where('id', $data['id'])
                ->get()[0]->restore();
        } catch (\Throwable $th) {
            $th->methodt = 'restore error';
            return response()->json(['95', $th]);
        }
        return $this->deletedShow();
    }

    public function deletedShow()
    {
        try {
            $query = Posterminal::onlyTrashed()->get();
            return response()->json(['200', $query]);
        } catch (\Throwable $th) {
            $th->methodt = 'deletedShow error';
            return response()->json(['95', $th]);
        }
    }
}
