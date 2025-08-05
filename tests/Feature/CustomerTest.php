<?php

namespace Tests\Feature;

use App\Models\wallet;
use Tests\TestCase;
use App\Models\Customer;
use Database\Seeders\WalletSeeder;
use Database\Seeders\CustomerSeeder;
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
}
