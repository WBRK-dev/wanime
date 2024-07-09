<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    use HasFactory;

    protected $table = 'hits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'authorized',
        'ip',
        'os',
        'path',
        'screenx',
    ];

    protected $casts = [
        'authorized' => 'boolean',
    ];
    
}
