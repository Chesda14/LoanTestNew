<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class genderController extends Controller
{
    public function genderList()
    {
        $gender = DB::table('gender')->get();
        return view('borrower', ['genders'=> $gender]);
    }




}
