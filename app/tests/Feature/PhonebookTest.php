<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Phonebook;

class PhonebookTest extends TestCase
{
    public function test_it_lists_all_entries()
    {
        $this->post(route("phonebook.store"), [
            "last_name" => "last",
            "first_name" => "first",
            "phone" => "8142729198",
            "email" => "testemail@email.com"
        ]);

        $this->post(route("phonebook.store"), [
            "last_name" => "lasdsdsdst",
            "first_name" => "sdsdsds",
            "phone" => "9142729198",
            "email" => "testemaidddl@email.com"
        ]);


        $this->get(route("phonebook.index"))
            ->assertJsonCount(2, "data");
    }

    public function test_it_stores_valid_phonebook_entries_in_the_database()
    {
        // given we have a valid entry
        // if we hit our endpoint
        $this->withoutExceptionHandling()->post(route("phonebook.store"), [
            "last_name" => "last",
            "first_name" => "first",
            "phone" => "9142729198",
            "email" => "testemail@email.com"
        ]);

        // then it should persist the data to the database
        $this->assertCount(1, Phonebook::all());
    }


    public function test_it_updates_a_valid_phonebook_entry_in_the_database()
    {
        $this->post(route("phonebook.store"), [
            "last_name" => "last",
            "first_name" => "first",
            "phone" => "9142729198",
            "email" => "testemail@email.com"
        ]);

        $entry = Phonebook::first();
        
        $this->assertEquals("9142729198", $entry->phone);

        // if we hit our update route
        $this->patch(route("phonebook.update", [$entry]), [
            "phone" => "9147777777",
        ]);

        // then the phone number should be changed
        $this->assertEquals("9147777777", $entry->fresh()->phone);
    }


    public function test_it_removes_an_entry_from_the_database()
    {
        $this->post(route("phonebook.store"), [
            "last_name" => "last",
            "first_name" => "first",
            "phone" => "9142729198",
            "email" => "testemail@email.com"
        ]);

        $entry = Phonebook::first();

        $this->assertEquals(1, $entry->count());

        // If we hit our deletion endpoint
        $this->delete(route("phonebook.destroy", [$entry]));

        // then we should have no items in our database
        $this->assertEquals(0, Phonebook::all()->fresh()->count());
    }
}
