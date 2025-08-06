<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PgSql\Lob;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->product_id = "1";
        $review->customer_id = "DHAYUS";
        $review->rating = 5;
        $review->comment = "Bagus Banget Bro";
        $review->save();

        $review2 = new Review();
        $review2->product_id = "2";
        $review2->customer_id = "DHAYUS";
        $review2->rating = 3;
        $review2->comment = "Biasa Banget Bro";
        $review2->save();
    }
}
