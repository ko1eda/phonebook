<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phonebook;

class PhonebookController extends Controller
{
    /**
     * Return all phonebook entries
     *
     * @return void
     */
    public function index()
    {
        $entries = Phonebook::all();

        return view("phonebook.index", [
            "entries" => $entries
        ]);
    }
}
