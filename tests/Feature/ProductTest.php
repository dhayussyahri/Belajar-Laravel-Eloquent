<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Tag;
use App\Models\Voucher;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PDO;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
    }

    public function testHasOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find("FOOD");
        self::assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals("1", $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProducet;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals("2", $mostExpensiveProduct->id);
    }

    public function testOneToOnePolyMorphic()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $image = $product->image;
        self::assertNotNull($image);

        self::assertEquals("http://www.haiiyusss.com/image/2.jpg", $image->url);
    }

    public function testOneToManyPolyMorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::find("1");
        self::assertNotNull($product);

        $comments = $product->comments;
        foreach($comments as $comment) {
            self::assertEquals(Product::class, $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testOneOfManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::first();
        $latestComment = $product->latestComment;
        self::assertNotNull($latestComment);

        $oldestComment = $product->oldestComment;
        self::assertNotNull($oldestComment);

    }

    public function testManyToManyPolyMorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);

        $product = Product::find("1");
        $tags = $product->tags;
        self::assertNotNull($tags);
        self::assertCount(1, $tags);

        foreach( $tags as $tag){
            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);

            $vouchers = $tag->vouchers;
            self::assertNotNull($vouchers);
            self::assertCount(1, $vouchers);

        }
    }
}
