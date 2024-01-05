<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{
    public function deleteMe()
    {
        $admin = [
            'name' => 'admin',
            'email' => 'admin@posterminal.lar',
            'password' => 'admin',
            'role' => 'Admin'
        ];
        try {
            $newUser = User::firstOrCreate([
                'email' => $admin['email']
            ], $admin);
        } catch (\Throwable $th) {
            $th->methodt = 'create error';
            return response()->json(['95', $th]);
        }
        $newUser['pass'] = $admin['password'];
        return response()->json(['200', $newUser]);
    }

    public function show()
    {
        $this->authorize('userAllMethods', auth()->user());
        try {
            $query = User::all();
            return response()->json(['200', $query]);
        } catch (\Throwable $th) {
            $th->methodt = 'show error';
            return response()->json(['95', $th]);
        }
    }

    public function create(CreateRequest $data)
    {
        $this->authorize('userAllMethods', auth()->user());
        $user = $data->validated();
        try {
            User::firstOrCreate([
                'email' => $user['email']
            ], $user);
        } catch (\Throwable $th) {
            $th->methodt = 'create error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function update(UpdateRequest $data)
    {
        $this->authorize('userAllMethods', auth()->user());
        $user = $data->validated();
        try {
            User::find($user['id'])->update($user);
        } catch (\Throwable $th) {
            $th->methodt = 'update error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function delete(Request $data)
    {
        $this->authorize('userAllMethods', auth()->user());
        try {
            $user = User::find($data['id']);
            $user->delete();
        } catch (\Throwable $th) {
            $th->methodt = 'delete error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }
}
