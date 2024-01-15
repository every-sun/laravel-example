<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'writer', 'user_id'];
    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'익명',
        ]);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
