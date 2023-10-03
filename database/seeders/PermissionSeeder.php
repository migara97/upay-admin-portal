<?php

namespace Database\Seeders;
use App\Enums\PermissionCategory as Pmc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view-backend', 'category_id' => Pmc::Other->value],
            
            // Biller
            [ 'name' => 'view-biller-management', 'category_id' => Pmc::Biller->value],
            [ 'name' => 'add-provider', 'category_id' => Pmc::Biller->value],
        ];

        //Disable foregin key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        //Truncate first
        Permission::query()->truncate();

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
        //Enable foreign key Checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
