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
}
