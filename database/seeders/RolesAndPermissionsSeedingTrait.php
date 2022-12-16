<?php
namespace Database\Seeders;

use App\Models\SystemRole as Role;
use App\Models\SystemPermission as Permission;
use Illuminate\Support\Facades\DB;

trait RolesAndPermissionsSeedingTrait
{
    protected $tables = [
        'users',
        'roles',
        'employees',
        'article_categories',
        'articles',
        'tags',
        'sliders',
    ];

    protected $view_tables = [
        'staticContent',
        'settings',
        'partitions',
        'page_headers',
    ];

    protected $update_tables = [
        'staticContent',
        'settings',
        'partitions',
        'page_headers',
    ];

    protected $comments = [

    ];

    public function create_permissions()
    {
        foreach ($this->tables as $table) {
            Permission::create(['name' => 'viewAny ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'view ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'create ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'update ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'restore ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'forceDelete ' . $table, "guard_name" => "api"]);
        }

        foreach ($this->view_tables as $table) {
            Permission::create(['name' => 'viewAny ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'view ' . $table, "guard_name" => "api"]);
        }

        foreach ($this->update_tables as $table) {
            Permission::create(['name' => 'update ' . $table, "guard_name" => "api"]);
        }

        foreach ($this->comments as $table) {
            Permission::create(['name' => 'update ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete client ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete admin ' . $table, "guard_name" => "api"]);
            Permission::create(['name' => 'delete super-admin ' . $table, "guard_name" => "api"]);
        }
    }

    public function give_permissions_to_role()
    {
        // Create a Super-Admin Role and assign all Permissions
       $role = Role::firstOrCreate(['name' => 'super-admin', "guard_name" => "api"]);
       $role->givePermissionTo(Permission::all());
    }

    public function reset_tables()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::statement("SET foreign_key_checks=1");
    }

    protected function runTesting(){
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->create_permissions();
        $this->give_permissions_to_role();
    }

    protected function runProduction(){
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->reset_tables();
        $this->create_permissions();
        $this->give_permissions_to_role();
    }
}
