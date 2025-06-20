<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = [
        'content'
    ];

    protected $table = 'channels';

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
