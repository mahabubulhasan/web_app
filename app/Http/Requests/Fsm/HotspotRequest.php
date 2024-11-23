<?php

namespace App\Http\Requests\fsm;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AtLeastOneFieldRequired;
use App\Rules\FatalitiesLessThanCases;

class HotspotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = ($this->isMethod('POST') ? $this->store() : $this->update());
        return $rules;
    }
    public function messages()
    {
        return [
            //owner part
            'hotspot_location.required' => 'Hotspot Area required',
            'date.required' => 'Date required',
            'disease.required' => 'Infected Disease required',
            'male_cases.required' => 'Number of Male Cases reqired',
            'female_cases.required' => 'Number of Female Cases reqired',
            'other_cases.required' => 'Number of Other Cases reqired',
            'male_cases.numeric' => 'Number of Male Cases should be number',
            'female_cases.numeric' => 'Number of Female Cases should be number',
            'other_cases.numeric' => 'Number of Other Cases should be number',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function store()
    {
        return [
            'hotspot_location' => 'required',
            'date' => 'required|date|before_or_equal:today',
            'disease' => 'required',
            'male_cases' => ['required', 'numeric', 'min:0', new AtLeastOneFieldRequired],
            'female_cases' => ['required', 'numeric', 'min:0', new AtLeastOneFieldRequired],
            'other_cases' => ['required', 'numeric', 'min:0', new AtLeastOneFieldRequired],
            'male_fatalities' => ['nullable', 'numeric', 'min:0', new FatalitiesLessThanCases('male_cases')],
            'female_fatalities' => ['nullable', 'numeric', 'min:0', new FatalitiesLessThanCases('female_cases')],
            'other_fatalities' => ['nullable', 'numeric', 'min:0', new FatalitiesLessThanCases('other_cases')],
            'geom' => 'required',
        ];
    }


    public function update()
    {
        return [
            'hotspot_location' => 'required',
            'date' => 'required|date|before_or_equal:today',
            'male_cases' => ['required', 'numeric', 'min:0', new AtLeastOneFieldRequired],
            'female_cases' => ['required', 'numeric', 'min:0', new AtLeastOneFieldRequired],
            'other_cases' => ['required', 'numeric', 'min:0', new AtLeastOneFieldRequired],
            'male_fatalities' => ['nullable', 'numeric', 'min:0', new FatalitiesLessThanCases('male_cases')],
            'female_fatalities' => ['nullable', 'numeric', 'min:0', new FatalitiesLessThanCases('female_cases')],
            'other_fatalities' => ['nullable', 'numeric', 'min:0', new FatalitiesLessThanCases('other_cases')],
            'geom' => 'required',
            'disease' => 'required'

        ];
    }
    // public function messages()
    // {
    //     return [
    //         'hotspot_location.required' => 'The Hotspot Name is required.',
    //         'date.required' => 'The Date is required.',
    //         'no_of_cases.required' => 'The No. of cases is required.',
    //         'geom.required' => 'The Hotspot Area is required.',
    //         'no_cases.numeric' => 'The number of cases must be a numeric value.',
    //         'no_of_fatalities.required' =>  'The No. of Fatalities  is required.',
    //         'no_of_fatalities.numeric' => 'The number of Fatalities must be a numeric value.',
    //     ];
    // }
}
// Last Modified Date: 10-04-2024
// Developed By: Innovative Solution Pvt. Ltd. (ISPL)    for .php files
