<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Watchlist extends Model
{
    use HasFactory;

    protected $table = 'watchlists';

    public function anime(): HasOne {
        return $this->hasOne(Anime::class, "animeId", "animeId");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userId',
        'status',
        'animeId',
        'episode',
    ];
    
}
