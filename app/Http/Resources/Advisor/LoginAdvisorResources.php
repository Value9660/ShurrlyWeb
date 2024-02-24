<?php

namespace App\Http\Resources\Advisor;

use App\Models\Advisor;
use App\Models\Seeker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;


class LoginAdvisorResources extends JsonResource
{
    public function toArray($request): array
    {
        $this->tokens()->delete();
        $advisor = Auth::user();

        $dateOfBirth = $this->date_birth ? \Carbon\Carbon::createFromFormat('Y-m-d', $this->date_birth)->format('d-m-Y') : null;

        $user =  Auth::id();
        $user = Advisor::find($user);
       $media = $user->getFirstMediaUrl('advisor_profile_image');


        return [
            "id" => $this->whenHas('id'),
            "uuid" => $this->whenHas('uuid'),
            'email_verfied'=>(bool) $this->email_verified_at ? true:false,
            'token' => $this->createToken('auth_token')->plainTextToken,
            "name" =>(string) $this->whenHas('name'),
            "email" => (string) $this->whenHas('email'),
            "date_birth" => $dateOfBirth,
            'image'=> $media,
            "role" => $this->hasRole('advisor') ? 'advisor' : 'advisor'

        ];
    }
}
