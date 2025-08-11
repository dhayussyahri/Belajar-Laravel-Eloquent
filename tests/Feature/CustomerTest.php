<?php

namespace Tests\Feature;

use App\Models\wallet;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use App\Models\VirtualAccount;
use Database\Seeders\CategorySeeder;
use Database\Seeders\WalletSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find("DHAYUS");
        self::assertNotNull($customer);

        // $wallet = wallet::where("customer_id", $customer->id)->first();
        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(1000000, $wallet->ammount);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customer();
        $customer->id = "DHAYUS";
        $customer->name = "Dhayus";
        $customer->email = "dhayus@gmail.com";
        $customer->save();

        $wallet = new wallet();
        $wallet->ammount = 1000000;

        $customer->wallet()->save($wallet);
        self::assertNotNull($wallet->customer_id);

    }

    public function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::find("DHAYUS");
        self::assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals("BCA", $virtualAccount->bank);
    }
    public function testManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find("DHAYUS");
        self::assertNotNull($customer);

        $customer->likesProducts()->attach("1");

        $products = $customer->likesProducts;
        self::assertCount(1, $products);

        self::assertEquals("1", $products[0]->id);

    }

    public function testManyToManyDetach()
    {
        $this->testManyToMany();

        $customer = Customer::find("DHAYUS");
        $customer->likesProducts()->detach("1");

        $products = $customer->likesProducts;
        self::assertCount(0, $products);

    }
    public function testPivotAttribute()
    {
        $this->testManyToMany();

        $customer = Customer::find("DHAYUS");
        $products = $customer->likesProducts;

        foreach($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotAttributeCondition()
    {
        $this->testManyToMany();

        $customer = Customer::find("Dhayus");
        $products = $customer->likesProductsLastWeek;

        foreach($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }
    public function testPivotModel()
    {
        $this->testManyToMany();

        $customer = Customer::find("DHAYUS");
        $products = $customer->likesProducts;

        foreach($products as $product) {
            $pivot = $product->pivot; // object model like
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            self::assertNotNull($pivot->customer);
            self::assertNotNull($pivot->product);

        }
    }

    public function testOneToOnePolyMorphic()
    {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::find("DHAYUS");
        self::assertNotNull($customer);

        $image = $customer->image;
        self::assertNotNull($image);

        self::assertEquals("http://www.haiiyusss.com/image/1.jpg", $image->url);
    }

    public function testEager()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::with(["wallet", "image"])->find("DHAYUS");
        self::assertNotNull($customer);
    }
    public function testEagerModel()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::with(["wallet", "image"])->find("DHAYUS");
        self::assertNotNull($customer);
    }
}
