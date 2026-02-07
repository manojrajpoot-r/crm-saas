<?php

namespace App\FormDefinitions;

class ChangePassword
{
    public static function fields($item = null): array
    {
        return [


            'Change Password' => [

                [
                    'type' => 'input',
                    'label' => 'Change Password',
                    'name' => 'password',
                    'type_attr' => 'password',
                ],

                [
                    'type' => 'input',
                    'label' => 'Confirm  Password',
                    'name' => 'password_confirmation',
                     'type_attr' => 'password',
                ],

            ]
        ];
    }
}