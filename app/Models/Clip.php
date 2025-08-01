<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Clip extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'twitch_clip_id',
        'title',
        'embed_url',
        'thumbnail_url',
        'views',
        'clipper_twitch_id',
        'clipper_name',
        'broadcaster_twitch_id',
        'broadcaster_name',
        'broadcaster_profile_image_url',
        'clipper_profile_image_url',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); // For later
    }
}