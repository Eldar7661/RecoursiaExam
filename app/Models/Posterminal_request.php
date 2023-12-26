<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posterminal_request extends Model
{
    use HasFactory;

    protected $table = 'posterminal_requests';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function posterminal()
    {
        return $this->belongsTo(Posterminal::class, 'posterminal_id', 'id');
    }

    public function theme()
    {
        return $this->belongsTo(Posterminal_theme::class, 'theme_id', 'id');
    }

    public function solution()
    {
        return $this->belongsTo(Posterminal_solution::class, 'solution_id', 'id');
    }
}
