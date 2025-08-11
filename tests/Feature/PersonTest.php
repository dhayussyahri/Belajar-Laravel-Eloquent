<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();
        $person->first_name = "Dhayus";
        $person->last_name = "Syahri";
        $person->save();

        self::assertEquals("DHAYUS Syahri", $person->fullName);

        $person->fullName = "Joko Morro";
        $person->save();

        self::assertEquals("JOKO", $person->first_name);
        self::assertEquals("Morro", $person->last_name);

    }
    public function testPersonToUpper()
    {
        $person = new Person();
        $person->first_name = "Dhayus";
        $person->last_name = "Syahri";
        $person->save();

        self::assertEquals("DHAYUS Syahri", $person->fullName);

        $person->fullName = "Joko Morro";
        $person->save();

        self::assertEquals("JOKO", $person->first_name);
        self::assertEquals("Morro", $person->last_name);
    }

    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = "Dhayus";
        $person->last_name = "Syahri";
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }

    public function testCustomCasts()
    {
        $person = new Person();
        $person->first_name = "Dhayus";
        $person->last_name = "Syahri";
        $person->address = new Address("Jalan Belum Jadi", "Jakarta", "Indonesia", "11111");
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        self::assertEquals("Jalan Belum Jadi", $person->address->street);
        self::assertEquals("Jakarta", $person->address->city);
        self::assertEquals("Indonesia", $person->address->country);
        self::assertEquals("11111", $person->address->postal_code);
    }
}
