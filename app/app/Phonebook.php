<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phonebook extends Model
{
    /**
     * $fillable
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', "email", "phone"];
}
