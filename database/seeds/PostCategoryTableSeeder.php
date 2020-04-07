<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factory;
use App\Models\Post\PostCategory;
use Carbon\Carbon;
use Faker\Generator as Faker;

class PostCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('post_categories')->insert([
            [
            	'name'      => 'Root',
		        'slug'      => 'root',
		        'description'   =>  'This is the root category',
		        'parent_id' => null,
                'metatag' => 'Root Category',
                'metadescp' => 'Root Category',
                'image' => null,
	            'created_at' => Carbon::now(),
	            'updated_at' => Carbon::now(),
	        ],
            [
                'name'      => 'Blog',
                'slug'      => 'blog',
                'description'   =>  'This is the blog category',
                'parent_id' => 1,
                'metatag' => 'Blog Category',
                'metadescp' => 'Blog Category',
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'News and Updates',
                'slug'      => 'news-and-updates',
                'description'   =>  'This is the News and Updates category',
                'parent_id' => 1,
                'metatag' => 'News and Updates Category',
                'metadescp' => 'News and Updates Category',
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name'      => 'Promotions',
                'slug'      => 'Promotions',
                'description'   =>  'This is the Promotions category',
                'parent_id' => 1,
                'metatag' => 'Promotions Category',
                'metadescp' => 'Promotions Category',
                'image' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
