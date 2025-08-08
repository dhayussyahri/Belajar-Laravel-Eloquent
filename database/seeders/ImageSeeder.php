<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $image = new Image();
            $image->url = "http://www.haiiyusss.com/image/1.jpg";
            $image->imageable_id = "DHAYUS";
            $image->imageable_type = Customer::class;
            $image->save();
        }

        {
            $image = new Image();
            $image->url = "http://www.haiiyusss.com/image/2.jpg";
            $image->imageable_id = "1";
            $image->imageable_type = Product::class;
            $image->save();
        }
    }
}
