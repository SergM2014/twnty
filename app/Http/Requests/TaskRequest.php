<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends Request
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'status' => [new Enum(Status::class)],
            'executor' => 'required|integer'
        ];
    }
}
