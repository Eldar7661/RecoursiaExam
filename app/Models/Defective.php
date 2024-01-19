<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defective extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description',
        'created_at', 
        'updated_at'
    ];

    public function solutions()
    {
        return $this->hasMany(Solutions::class, 'theme_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];
}
