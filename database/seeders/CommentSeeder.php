<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCommentsForProduct();
        $this->createCommentsForVoucher();
    }

    public function createCommentsForProduct():void
    {
        $product = Product::find("1");

        $comment = new Comment();
        $comment->email = "dhayus@gmail.com";
        $comment->title = "Title";
        $comment->commentable_id = $product->id;
        $comment->commentable_type = 'product';
        $comment->save();
    }
    public function createCommentsForVoucher():void
    {
        $voucher = Voucher::first();

        $comment = new Comment();
        $comment->email = "dhayus@gmail.com";
        $comment->title = "Title";
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();

    }
}
