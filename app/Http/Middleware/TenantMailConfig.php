<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Models\Tenant\Setting;

class TenantMailConfig
{
    public function handle($request, Closure $next)
    {
        $setting = Cache::remember(
            'tenant_mail_settings',3600,function () {
                return Setting::first();
            }
        );

        if ($setting) {
            config([
                'mail.mailers.smtp.host'       => $setting->smtp_host,
                'mail.mailers.smtp.port'       => $setting->smtp_port,
                'mail.mailers.smtp.username'   => $setting->smtp_username,
                'mail.mailers.smtp.password'   => $setting->smtp_password,
                'mail.mailers.smtp.encryption' => $setting->smtp_encryption,
                'mail.from.address'            => $setting->mail_from_address,
                'mail.from.name'               => $setting->mail_from_name,
            ]);
        }

        return $next($request);
    }
}
