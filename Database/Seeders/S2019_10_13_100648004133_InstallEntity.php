<?php

use Pingu\Core\Seeding\DisableForeignKeysTrait;
use Pingu\Core\Seeding\MigratableSeeder;
use Pingu\Menu\Entities\Menu;
use Pingu\Menu\Entities\MenuItem;
use Pingu\Permissions\Entities\Permission;

class S2019_10_13_100648004133_InstallEntity extends MigratableSeeder
{
    use DisableForeignKeysTrait;

    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $perm = Permission::findOrCreate(['name' => 'manage bundles', 'section' => 'Core']);
        $admin = Menu::findByMachineName('admin-menu');
        $structure = MenuItem::findByMachineName('admin-menu.structure');

        MenuItem::create(
            [
            'name' => 'Bundles',
            'weight' => 0,
            'active' => 1,
            'deletable' => 0,
            'url' => 'core.structure.bundles',
            'permission_id' => $perm->id
            ], $admin, $structure
        );
    }

    /**
     * Reverts the database seeder.
     */
    public function down(): void
    {
        // Remove your data
    }
}
