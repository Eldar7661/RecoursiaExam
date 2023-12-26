<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posterminal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'posterminals';
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function requests()
    {
        return $this->hasMany(Posterminal_request::class, 'posterminal_id', 'id');
    }

}
