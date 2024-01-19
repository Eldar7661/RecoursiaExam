<?php

namespace App\Http\Controllers\Posterminal;

use App\Http\Controllers\Controller;
use App\Models\Posterminal_theme;
use Illuminate\Http\Request;
use App\Http\Requests\Posterminal\ThemeCreateRequest;
use App\Http\Requests\Posterminal\ThemeUpdateRequest;

class ThemeController extends Controller
{
    public function show()
    {
        $this->authorize('themeAllMethods', auth()->user());
        try {
            $query = Posterminal_theme::with('solutions')->get();
            return response()->json(['200', $query]);
        } catch (\Throwable $th) {
            $th->methodt = 'themeCreate error';
            return response()->json(['95', $th]);
        }
    }

    public function create(ThemeCreateRequest $data)
    {
        $this->authorize('themeAllMethods', auth()->user());
        $theme = $data->validated();
        try {
            Posterminal_theme::create($theme);
        } catch (\Throwable $th) {
            $th->methodt = 'themeCreate error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function update(ThemeUpdateRequest $data)
    {
        $this->authorize('themeAllMethods', auth()->user());
        $theme = $data->validated();
        try {
            Posterminal_theme::find($theme['id'])->update($theme);
        } catch (\Throwable $th) {
            $th->methodt = 'themeUpdate error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }

    public function delete(Request $data)
    {
        $this->authorize('themeAllMethods', auth()->user());
        try {
            Posterminal_theme::find($data['id'])->delete();
        } catch (\Throwable $th) {
            $th->methodt = 'themeDelete error';
            return response()->json(['95', $th]);
        }
        return $this->show();
    }
}
