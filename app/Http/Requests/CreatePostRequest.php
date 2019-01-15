<?php

namespace App\Http\Request;

use App\Exceptions\ThrottleException;
use App\Reply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return Gate::allows('create' , new Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('Too many request.Please,take a break.' , 429);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }
}
