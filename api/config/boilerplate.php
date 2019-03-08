
<?php

return [
  // these options are related to the registration procedure
    'registration_local' => [

        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'social_provider_id' => 'required|min:1|max:3',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender_id' => 'required|min:1|max:3',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]
    ],

    'contact' => [

        // here you can specify some validation rules for your sign-in request
        'validation_rules' => [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'numbers' => 'array',
            'numbers.*.number' => 'distinct',
        ]
    ],
];