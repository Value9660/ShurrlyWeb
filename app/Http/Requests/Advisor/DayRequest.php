<?php

namespace App\Http\Requests\Advisor;

use App\Http\Requests\Auth\Request;


class DayRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'days' => ['required','array'],
            'days.*.day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'days.*.from' => 'required|date_format:H:i',
            'days.*.to' => 'required|date_format:H:i|after:from',
        ];
    }
}
