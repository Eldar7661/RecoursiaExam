<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'address',
        'system_id',
        'status',
        'serial_number',
    ];

    protected $guarded = ['id'];

    public function cardomat_requests()
    {
        return $this->hasMany(Cardomat_requests::class, 'cardomat_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
        'deleted_at' => 'datetime:d/m/Y H:i',
    ];
}
