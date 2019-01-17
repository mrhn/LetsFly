<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Person;

class PersonController extends Controller
{
    public function all()
    {
        return PersonResource::collection(Person::all());
    }
}
