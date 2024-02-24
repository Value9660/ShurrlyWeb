<?php

namespace App\Http\Controllers\Api\Advisor;

use App\Models\Day;
use App\Http\Controllers\Controller;
use App\Http\Requests\Advisor\DayRequest;
use App\Http\Resources\Advisor\DayResources;

class DayController extends Controller
{
    public function __invoke(DayRequest $request)
    {
        $allDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        // Validate the request data
        $validator = $request->validated();

        // Create or update the availability record
        $seeker = $request->user();
        $seeker->days()->delete();
        foreach ($request['days'] as $day) {
            $days = Day::create([
                'day' => $day['day'],
                'from' => $day['from'],
                'to' => $day['to'],
                'seeker_id' => $seeker->id,
                'available' => true
            ]);
            unset($allDays[array_search($day['day'], $allDays)]);
        }
        //to return all days 
        //foreach ($allDays as $d) {
            //Day::create(['day' => $d, 'from' => '00:00', 'to' => '00:00', 'seeker_id' => $seeker->id, 'available' => false]);
        //}


        return $this->handleResponse(message: 'Successfully update DateTime', data: new DayResources(['days' => $seeker->days, 'offlineDays']));
    }
}
