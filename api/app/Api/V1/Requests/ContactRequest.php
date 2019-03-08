<?php

namespace App\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Config::get('boilerplate.contact.validation_rules');
    }
}