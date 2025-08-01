<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'twitch_id',
        'twitch_token',
        'twitch_refresh_token',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'twitch_token',
        'twitch_refresh_token',
    ];

    /**
     * The "type" of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * Get the clips shared by the user.
     */
    public function clips()
    {
        return $this->hasMany(Clip::class);
    }

    /**
     * Get the votes cast by the user.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the comments made by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class); // For later
    }
}