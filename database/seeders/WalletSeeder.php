<?php

namespace Database\Seeders;

use App\Models\wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = new wallet();
        $wallet->ammount = 1000000;
        $wallet->customer_id = "DHAYUS";
        $wallet->save();
    }
}
