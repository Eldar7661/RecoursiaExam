<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefectivePostamat extends Model
{
    use HasFactory;

    public function solutions()
    {
        return $this->hasMany(PostamatSolution::class, 'defective_id', 'id');
    }

    protected $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y, H:i',
        'updated_at' => 'datetime:d/m/Y, H:i'
    ];
}
