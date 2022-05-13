<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class Game extends Model
{
    use HasFactory;
    
    protected $table = 'games';
    protected $fillable = [
        'name',
    ];

    /**
     * Get all of the posts for the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * The statistics that belong to the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function statistics()
    {
        return $this->belongsToMany(Statistic::class,'statistics_games_users');
    }

    /**
     * The users that belong to the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'statistics_games_users');
    }

    /**
     * Prepare a date for array / JSON serialization.
     * 
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
