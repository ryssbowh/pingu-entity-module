<?php

use Pingu\Content\Entities\Content;
use Pingu\Core\Seeding\DisableForeignKeysTrait;
use Pingu\Core\Seeding\MigratableSeeder;
use Pingu\Entity\Entities\ViewMode;
use Pingu\Entity\Entities\ViewModesMapping;
use Pingu\Field\Entities\DisplayField;
use Pingu\User\Entities\User;

class S2020_03_23_193836872820_EntityAddViewModes extends MigratableSeeder
{
    use DisableForeignKeysTrait;

    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $viewMode = ViewMode::create(['name' => 'Default', 'machineName' => 'default']);
        foreach (DisplayField::all() as $display) {
            $display->viewMode()->associate($viewMode);
            $display->save();
        }
        foreach ([User::class, Content::class] as $class) {
            $a =new ViewModesMapping;
            $a->entity = (new $class)->identifier();
            $a->view_mode()->associate($viewMode)->save();
        }

        $admin = Menu::findByMachineName('admin-menu');
        $content = MenuItem::findByMachineName('admin-menu.content');

        MenuItem::create(
            [
            'name' => 'View modes',
            'weight' => 0,
            'active' => 1,
            'deletable' => 0,
            'url' => 'entity.admin.view-modes',
            'permission_id' => \Permissions::getByName('manage display')->id;
            ], $admin, $content
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
