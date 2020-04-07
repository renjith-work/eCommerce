<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PoTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('po_types')->insert([
            [
            	'name' => 'Purchase',
            	'description' => 'This product can be directly purchased from the site.',
	            'created_at' => Carbon::now(),
	            'updated_at' => Carbon::now(),
	        ],
	        [
            	'name' => 'Enquiry',
            	'description' => 'This product cannot be directly purchased from the site. You may add to the enquiry list and make an enquiry.',
	            'created_at' => Carbon::now(),
	            'updated_at' => Carbon::now(),
	        ]
	    ]);
    }
}
