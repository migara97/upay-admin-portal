<?php

use App\Repository\Eloquent\ActivityRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

if (!function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('get_enum_value')) {
    function get_enum_value($value, $enumClass, $matchValue = false)
    {
        $cases = $enumClass::cases();
        $index = array_search($value, array_column($cases, $matchValue ? "value" : "name"));
        if ($index !== false) {
            return $cases[$index]->labels();
        }

        return null;
    }
}

if (!function_exists('get_formatted_permission_list')) {
    function get_formatted_permission_list($permissionList): array
    {
        $formattedPermissionList = [];

        foreach ($permissionList as $p) {
            $permissionValue['id'] = $p->id;
            $permissionValue['name'] = $p->name;
            $key = get_enum_value($p->category_id, PermissionCategory::class, true);
            $val = $permissionValue;
            $exists = array_key_exists($key, $formattedPermissionList);

            if ($exists) {
                array_push($formattedPermissionList[$key], $val);
            } else {
                $formattedPermissionList[$key] = array($val);
            }
        }

        asort($formattedPermissionList);
        return $formattedPermissionList;
    }
}

if (!function_exists('log_activity')) {

    function log_activity($action, $description, $appUser = null, $level = \Psr\Log\LogLevel::INFO)
    {
        $user = auth()->user() != null ? auth()->user()->email : "";
        $log = "[ACTIVITY] | " . str_pad($user, 25) . " | " . str_pad($action, 10) . " | " . $appUser . " | ";
        try {
            Log::log($level, $log . "Description -> " . $description);

            App::make(ActivityRepository::class)->saveActivity([
                "user" => $user,
                "affected_app_user" => $appUser,
                "action" => $action,
                "description" => $description,
            ]);
        } catch (Exception $e) {
            Log::error($log . "Exception: " . $e->getMessage() . " - " . $e->getLine());
        }
    }
}

if (!function_exists('upload_image')) {

    function upload_image($image, Closure $failedCallback, $path = null, $overwrite = false): ?string
    {
        $log = "[UPLOAD_IMAGE] | ";

        $originalName = $image->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $name = preg_replace("/[^a-zA-Z0-9]+/", "_", $filename) . ".$extension";

        Log::info($log . "Name: " . $name);

        // Skip file existence check if overwrite is enabled
        if (!$overwrite) {
            $finalPath = $path ? "$path/$name" : $name;
            $fileExists = Storage::disk(env('STORAGE_DISK'))->exists($finalPath);

            if ($fileExists) {
                return $failedCallback("An image already exists with this name.");
            }
        }

        $image->storeAs($path, $name, env('STORAGE_DISK'));

        return $name;
    }
}

if (!function_exists('audit_log')) {
    function audit_log(string $action, string $description = null, string $pre = null, string $new = null): void
    {
        try {
            $trail = new \App\Models\Backend\AuditTrail();
            $trail->created_at = Carbon::now();
            $trail->email = auth()->user() != null ? auth()->user()->email : null;
            $trail->request = $pre;
            $trail->response = $new;
            $trail->sequence_id = session()->getId();
            $trail->category = "ADMIN";
            $trail->action = $action;
            $trail->description = $description;

            $trail->save();
        } catch (Exception $exception) {
            Log::warning("[AuditLog] | Exception -> " . $exception->getMessage() . " " . $exception->getLine());
        }

    }
}

if (!function_exists('filter_arrays')) {
   function filter_arrays(array $first, array $second): array
   {
    //    $out = filter_dual_auth_summary([
    //        "pre" => $first,
    //        "new" => $second
    //    ]);

       return [$first, $second];
   }
}
