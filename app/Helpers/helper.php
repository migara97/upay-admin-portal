<?php

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