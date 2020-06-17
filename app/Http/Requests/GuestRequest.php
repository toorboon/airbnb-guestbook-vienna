<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $minDate = (new Carbon())->subMonths(6);
        $birthDayLimit = (new Carbon())->subYears(18);
        $now = new Carbon();

        return [
            'accommodation_id' => 'required|integer',
            'first_name' => 'required',
            'last_name' => 'required',
            'citizenship' => 'required',
            'gender' => 'required',
            'birth_date' => 'required|before_or_equal:'.$birthDayLimit,
            'document_type' => 'required',
            'document' => 'required',
            'address' => 'required',
            '*.*.first_name' => 'sometimes|required|min:2',
            '*.*.last_name' => 'sometimes|required|min:2',
            '*.*.birth_date' => 'sometimes|required|date|before_or_equal:'.$now,
            'arrival_date' => 'required|date|after_or_equal:'.$minDate,
            'est_departure_date' => 'required|date|after_or_equal:arrival_date',
            'act_departure_date' => 'sometimes|nullable|after_or_equal:arrival_date',
            'notes' => 'sometimes|nullable',
            'signature' => 'required',
           ];
    }
}
