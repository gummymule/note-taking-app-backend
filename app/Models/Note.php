<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['title', 'content', 'archived', 'last_edited'];
    protected $casts = [
        'archived' => 'boolean',
        'last_edited' => 'datetime',
    ];
    
    /**
     * The tags that belong to the note.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'note_tags');
    }
}
