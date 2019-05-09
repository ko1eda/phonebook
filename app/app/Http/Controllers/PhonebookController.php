<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phonebook;

class PhonebookController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Phonebook::all();

        return response(["data" => $entries], 200);
    }

    /**
     * Create a new phonebook entry
     *
     * @param Request $req
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // validate the incoming request before we store it
        // 'phone' => 'required|string|regex:/[0-9]{10}/' if phone # needs to be validated
        // see https://stackoverflow.com/questions/36777840/how-to-validate-phone-number-in-laravel-5-2
        $v = $req->validate([
            'last_name' => 'string|required|max:255',
            'first_name' => 'string|required|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|min:10'
        ]);

        // store the validated entry in the db
        $entry = Phonebook::create($v);

        return response(["data" => $entry], 200);
    }

    /**
     * Update a phonebook entry
     *
     * @param Request $req
     * @param Phonebook $phonebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Phonebook $phonebook)
    {
        // validate the incoming request before we store it
        $v = $req->validate([
            'last_name' => 'string|max:255',
            'first_name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'phone' => 'string|min:10'
        ]);

        // store the validated entry in the db
        $phonebook->update($v);

        return response(["data" => $phonebook], 200);
    }

    /**
     * Remove a phonebook entry
     *
     * @param Request $req
     * @param Phonebook $phonebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phonebook $phonebook)
    {
        $phonebook->delete();

        return response([], 204);
    }
}
