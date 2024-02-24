<?php

namespace App\Models;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Advisor extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'bio',
        'expertise',
        'seeker_id',
        'Offere',
        'approved'
    ];

    //upload advisor_profile_image
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('advisor_profile_image');
    }
//upload advisor_Intro_video
    public function createMediaProduct(): void
    {
        $this->addMediaCollection('advisor_Intro_video');
    }
    //upload advisor_Certificates_PDF

    public function createMediaCertificates(): void
    {
        $this->addMediaCollection('advisor_Certificates_PDF');
    }

// * Relationship
    public function seeker()
    {
        return $this->hasOne(Seeker::class);
    }

    public function Day()
    {
        return $this->hasMany(Day::class);
    }
    public function skills(){
        return $this->belongsToMany(Skill::class);
    }


}
