<?php

namespace App\Http\Controllers\Api\Advisor;

use App\Models\Skill;
use App\Models\Advisor;
use App\Http\Controllers\Controller;
use App\Http\Resources\Advisor\UploadResources;
use App\Http\Requests\Advisor\UploadAdvisorRequest;


class UploadAdvisorController extends Controller
{
    public function __invoke(UploadAdvisorRequest $request)
    {

        $validatedData = $request->validated();


        $seeker = request()->user();

        if (!empty($request->skills)) {

        $advisor = Advisor::create([
            'bio' => $validatedData['bio'],
            'expertise' => $validatedData['expertise'],
            'Offere' => $validatedData['Offere'],
            'seeker_id' =>  $seeker->id,
            'available' => $validatedData['available'],

        // ! For Testing change to false after dashboard
            'approved' => true,
        ]);

        // ! For Testing Auto Approved code
        
        $seeker->assignRole('advisor');

        // To add a new skill in table skill and update advisor skills

        $generatedSkills = [];
        $advisorId = $seeker->id ;

        foreach ($request->skills as $skill) {
            array_push($generatedSkills, Skill::firstOrCreate(['name' => $skill])->id);
        }

        //FOR ADDING TO EDIT skill TO EDIT
        $advisor = Advisor::where('id',$advisorId)->first();
        $advisor->skills()->attach($generatedSkills);


        // upload image

        if ($request->hasFile('image')) {

            $advisor->addMediaFromRequest('image')->toMediaCollection('advisor_profile_image');
        }
        // upload video

        if ($request->hasFile('video')) {

            $advisor->addMediaFromRequest('video')->toMediaCollection('advisor_Intro_video');
        }

        if ($request->hasFile('certificates')) {

            $advisor->addMediaFromRequest('certificates')->toMediaCollection('advisor_Certificates_PDF');
        }


        return $this->handleResponse(message: 'Successfully', data: new UploadResources($advisor),);


    }

    else {
        return $this->handleResponse(message: 'Skills required' ,status:false ,code : 406 );

    }




}


}
