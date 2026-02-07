<?php

namespace App\FormDefinitions;

class SettingForm
{
    public static function fields($item = null): array
    {
        return [

            /* =======================
             |  GENERAL / COMPANY
             ======================= */
            'Company Information' => [

                [
                    'type' => 'input',
                    'label' => 'Company Name',
                    'name' => 'company_name',
                    'value' => $item->company_name ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'Company Email',
                    'name' => 'company_email',
                    'type_attr' => 'email',
                    'value' => $item->company_email ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'Company Phone',
                    'name' => 'company_phone',
                    'value' => $item->company_phone ?? null,
                ],

                [
                    'type' => 'textarea',
                    'label' => 'Company Address',
                    'name' => 'company_address',
                    'rows' => 3,
                    'value' => $item->company_address ?? null,
                ],
            ],

            /* =======================
             |  BRANDING
             ======================= */
            'Branding' => [

                [
                    'type' => 'file',
                    'label' => 'Company Logo',
                    'name' => 'logo',
                    'preview' => true,
                    'value' => $item->logo ?? null,
                    'preview_path' => 'uploads/settings/logo',

                ],

                [
                    'type' => 'file',
                    'label' => 'Favicon',
                    'name' => 'favicon',
                    'preview' => true,
                    'value' => $item->favicon ?? null,
                    'preview_path' => 'uploads/settings/favicon',
                ],
            ],

            /* =======================
             |  LEAVE SETTINGS
             ======================= */
            'Leave Settings' => [

                [
                    'type' => 'toggle',
                    'label' => 'Auto Approve Leave',
                    'name' => 'leave_auto_approve',
                    'value' => $item->leave_auto_approve ?? false,
                ],

                [
                    'type' => 'input',
                    'label' => 'Max Leave Per Month',
                    'name' => 'max_leave_per_month',
                    'type_attr' => 'number',
                    'value' => $item->max_leave_per_month ?? null,
                ],

                [
                    'type' => 'toggle',
                    'label' => 'Allow Half Day',
                    'name' => 'allow_half_day',
                    'value' => $item->allow_half_day ?? true,
                ],
            ],

            /* =======================
             |  SMTP SETTINGS
             ======================= */
            'SMTP Settings' => [

                [
                    'type' => 'input',
                    'label' => 'SMTP Host',
                    'name' => 'smtp_host',
                    'value' => $item->smtp_host ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'SMTP Port',
                    'name' => 'smtp_port',
                    'type_attr' => 'number',
                    'value' => $item->smtp_port ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'SMTP Username',
                    'name' => 'smtp_username',
                    'value' => $item->smtp_username ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'SMTP Password',
                    'name' => 'smtp_password',
                    'type_attr' => 'password',
                    'value' => null, // security
                ],

                [
                    'type' => 'input',
                    'label' => 'Encryption',
                    'name' => 'smtp_encryption',
                    'value' => $item->smtp_encryption ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'Mail From Address',
                    'name' => 'mail_from_address',
                    'type_attr' => 'email',
                    'value' => $item->mail_from_address ?? null,
                ],

                [
                    'type' => 'input',
                    'label' => 'Mail From Name',
                    'name' => 'mail_from_name',
                    'value' => $item->mail_from_name ?? null,
                ],
            ],

            /* =======================
             |  APP SETTINGS
             ======================= */
            'App Settings' => [

                [
                    'type' => 'input',
                    'label' => 'Timezone',
                    'name' => 'timezone',
                    'value' => $item->timezone ?? 'Asia/Kolkata',
                ],

                [
                    'type' => 'input',
                    'label' => 'Date Format',
                    'name' => 'date_format',
                    'value' => $item->date_format ?? 'd-m-Y',
                ],

                [
                    'type' => 'input',
                    'label' => 'Currency',
                    'name' => 'currency',
                    'value' => $item->currency ?? 'INR',
                ],
            ],
        ];
    }
}