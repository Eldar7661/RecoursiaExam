<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solutions extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_id', 
        'title', 
        'created_at', 
        'updated_at'
    ];

    public function theme()
    {
        return $this->belongsTo(Defective::class, 'theme_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];
}
