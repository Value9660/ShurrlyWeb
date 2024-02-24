<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\MediaCollections\Models\Concerns\HasUuid;


class Seeker extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable,InteractsWithMedia,HasUuid,HasRoles;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'date_birth',
        'password',
        'provider_id',
        'provider',
        'email_verified_at'
    ];

    protected $dates = ['date_birth'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('seeker_profile_image');
    }

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }
    public function days(){
        return $this->hasMany(Day::class,'seeker_id','id');
    }
    
    public function deleteUnverifiedAccounts()
{
    // Get unverified accounts created more than 10 days ago
    $unverifiedAccounts = Seeker::whereNull('email_verified_at')
                              ->where('created_at', '<=', Carbon::now()->subDays(10))
                              ->get();

    foreach ($unverifiedAccounts as $account) {
        // Delete the account
        DB::transaction(function () use ($account) {
            $account->delete();
        });
    }
}

}
