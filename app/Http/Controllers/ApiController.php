<?php

namespace App\Http\Controllers;

use App\Http\Resources\MagazineResourceCollection;
use App\Models\Magazine;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function magazines()
    {

        return (new MagazineResourceCollection(Magazine::orderByDesc('id')->get()));
    }
}
