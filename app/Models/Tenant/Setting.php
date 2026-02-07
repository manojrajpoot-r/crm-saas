<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Setting extends BaseTenantModel
{

    protected $fillable = [

        'company_name',
        'company_email',
        'company_phone',
        'company_address',

        'logo',
        'favicon',

        'leave_auto_approve',
        'max_leave_per_month',
        'allow_half_day',

        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'mail_from_address',
        'mail_from_name',

        'timezone',
        'date_format',
        'currency',

        'status',
    ];

       public static function rules($id = null)
    {
        return [
              'company_name' => 'nullable|string',
            'company_email' => 'nullable|email',
            'company_phone' => 'nullable|string',
            'company_address' => 'nullable|string',

            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',

            'leave_auto_approve' => 'nullable|boolean',
            'max_leave_per_month' => 'nullable|integer',
            'allow_half_day' => 'nullable|boolean',

            'smtp_host' => 'nullable|string',
            'smtp_port' => 'nullable|string',
            'smtp_username' => 'nullable|string',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',

            'timezone' => 'nullable|string',
            'date_format' => 'nullable|string',
            'currency' => 'nullable|string',
        ];
    }

protected static function booted()
{
    static::saved(function () {
        cache()->forget('tenant_mail_settings');
    });
}

}