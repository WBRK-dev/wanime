<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Star extends Model
{
    use HasFactory;

    protected $table = 'stars';

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, "userId", "id")->select("id", "name");
    }

    public function anime(): HasOne {
        return $this->hasOne(Anime::class, "animeId", "animeId");
    }

    public function timeAgo() {
        $now = new \DateTime(date("Y-m-d"));
        $then = new \DateTime($this->created_at);
        $diff = $now->diff($then);

        if ($diff->y) {
            return $diff->y . " year". ($diff->y === 1 ? "" : "s") ." ago";
        } else if ($diff->m) {
            return $diff->m . " month". ($diff->m === 1 ? "" : "s") ." ago";
        } else if ($diff->d) {
            return $diff->d . " day". ($diff->d === 1 ? "" : "s") ." ago";
        } else if ($diff->h) {
            return $diff->h . " hour". ($diff->h === 1 ? "" : "s") ." ago";
        } elseif ($diff->i) {
            return $diff->i . " minute". ($diff->i === 1 ? "" : "s") ." ago";
        } else {
            return "just now";
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userid',
        'stars',
        'animeId',
    ];
    
}
