<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'clip_id',
        'parent_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clip()
    {
        return $this->belongsTo(Clip::class);
    }

    // For replies (parent comment)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // For replies (child comments)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
}