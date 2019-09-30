<?php

use Pingu\Core\Seeding\MigratableSeeder;
use Pingu\Core\Seeding\DisableForeignKeysTrait;

class S2019_08_25_144649151232_Entity extends MigratableSeeder
{
    use DisableForeignKeysTrait;

    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Seed your data
    }

    /**
     * Reverts the database seeder.
     */
    public function down(): void
    {
        // Remove your data
    }
}
