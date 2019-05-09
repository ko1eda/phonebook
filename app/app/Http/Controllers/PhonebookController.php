<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Phonebook;

class PhonebookController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(Request $req)
    {
        $entries = Phonebook::all();

        // When we load the endpoint via ajax,
        if ($req->wantsJson()) {
            return response(["data" => $entries], 200);
        }

        return view("phonebook.index");
    }

 
    /**
     * Create a new phonebook entry
     *
     * @param Request $req
     * @return void
     */
    public function store(Request $req)
    {
        // validate the incoming request before we store it
        $v = $req->validate([
            'last_name' => 'string|required|max:255',
            'first_name' => 'string|required|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|numeric|min:10'
        ]);

        // store the validated entry in the db
        $entry = Phonebook::create($v);

        // if we get an ajax request return the new entry and 200 status code
        if ($req->wantsJson()) {
            return response(["data" => $entry], 200);
        }


        return redirect()
            ->route("home");
    }

    /**
     * Create a new phonebook entry
     *
     * @param Request $req
     * @return void
     */
    public function update(Request $req, Phonebook $phonebook)
    {
        // validate the incoming request before we store it
        $v = $req->validate([
            'last_name' => 'string|max:255',
            'first_name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'phone' => 'string|numeric|min:10'
        ]);

        // store the validated entry in the db
        $phonebook->update($v);

        // if we get an ajax request return the updated entry and 200 status code
        if ($req->wantsJson()) {
            return response(["data" => $phonebook], 200);
        }

        return redirect()
            ->route("home");
    }

    /**
     * Remove an entry from the phonebook
     *
     * @param Request $req
     * @param Phonebook $p
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req, Phonebook $phonebook)
    {
        $phonebook->delete();

        if ($req->wantsJson()) {
            return response([], 204);
        }

        return redirect()
            ->route("home");
    }
}
