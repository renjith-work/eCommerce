<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	UsersTableSeeder::class,
            // Settings
            SettingsTableSeeder::class,
        	// Post Seeder
            PostCategoryTableSeeder::class,
            // PostDesignTableSeeder::class,
            PostStatusTableSeeder::class,
            // PostTableSeeder::class,
            // PostTagTableSeeder::class,
            // postRTagTableSeeder::class,
            // Roles and Permissions Seeder
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            
            // Product Seeder
            ProductCategoryTableSeeder::class,
            // ProductAttributeTableSeeder::class,
            // ProductAttributeValueTableSeeder::class,
            // ProductDesignTableSeeder::class,    
            // BrandsTableSeeder::class,
            PoTypeTableSeeder::class,
            StatusTableSeeder::class,

        ]);
    }
}
