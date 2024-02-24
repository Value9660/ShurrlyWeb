<?php

namespace App\Http\Resources\Advisor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'bio' => $this->bio,
            'expertise' => $this->expertise,
            'Offere' => $this->Offere,
            'seeker_id' => $this->seeker_id,
            'image' => $this->getFirstMediaUrl('advisor_profile_image'),
            'video' => $this->getFirstMediaUrl('advisor_Intro_video'),
            'certificates' => $this->getFirstMediaUrl('advisor_Certificates_PDF'),
            "role" => $this->whenHas('role'),
            
        ];
    }
}
