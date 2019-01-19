<?php

namespace App\Http\Requests;

use App\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\In;

class CreateTeamRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'priority' => ['required', new In(Team::PRIORITIES)],
            'team' => ['required', 'array'],
            'team.*.skill' => ['required', new Exists('skills', 'name')],
            'team.*.amount' => ['required', 'integer'],
        ];
    }
}
