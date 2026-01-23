<?php

// if (!function_exists('currentTenant')) {
//     function currentTenant()
//     {
//         return config('saas.current_tenant');
//     }
// }

// if (!function_exists('tenantRoute')) {
//     function tenantRoute($name, $params = [])
//     {
//         if (!is_array($params)) {
//             $params = ['id' => $params];
//         }

//         $tenant = currentTenant();

//         if (!$tenant) {
//             throw new Exception('Tenant not resolved');
//         }


//         return route('tenant.' . $name, $params);
//     }
// }



if (!function_exists('currentTenant'))
    { function currentTenant()
 { return config('saas.current_tenant');
  } }
  if (!function_exists('tenantRoute'))
    {
        function tenantRoute($name, $params = []) {
             if (!is_array($params)) { $params = ['id' => $params]; }
              $tenant = currentTenant();
              if (!$tenant)
               {
                throw new Exception('Tenant not resolved'); }
               return route('tenant.' . $name, array_merge( ['tenant' => $tenant->id], $params ));
               } }