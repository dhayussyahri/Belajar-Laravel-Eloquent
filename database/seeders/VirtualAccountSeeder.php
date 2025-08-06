<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = wallet::where("customer_id", "DHAYUS")->firstOrFail();

        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = "BCA";
        $virtualAccount->va_number = "1234567890";
        $virtualAccount->wallet_id = $wallet->id;
        $virtualAccount->save();
    }
}
