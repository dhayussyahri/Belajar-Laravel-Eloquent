<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();
        $person->first_name = "Dhayus";
        $person->last_name = "Syahri";
        $person->save();

        self::assertEquals("Dhayus Syahri", $person->fullName);

        $person->fullName = "Joko Morro";
        $person->save();

        self::assertEquals("Joko", $person->first_name);
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
}
