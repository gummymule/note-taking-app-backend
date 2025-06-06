<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    
    /**
     * The notes that belong to the tag.
     */
    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_tags');
    }
}
