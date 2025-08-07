<?php

namespace Tests\Feature;

use App\Models\wallet;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\VirtualAccount;
use Database\Seeders\CategorySeeder;
use Database\Seeders\WalletSeeder;
use Database\Seeders\CustomerSeeder;
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
}
