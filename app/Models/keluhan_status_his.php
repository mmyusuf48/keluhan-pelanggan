<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keluhan_status_his extends Model
{
    use HasFactory;


    protected $table = 'keluhan_status_history';

    protected $fillable = [
        'keluhan_id',
        'status_keluhan',
    ];

    protected $casts = [
        'status_keluhan' => 'integer',
    ];

    public function keluhan()
    {
        return $this->belongsTo(Keluhan_pelanggan::class, 'keluhan_id');
    }
}
