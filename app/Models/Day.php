<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $fillable = [
        'seeker_id',
        'day',
        'available',
        'from',
        'to'
    ];

    // * Relationship
    public function seeker(){
        return $this->belongsTo(Seeker::class);
    }
}
