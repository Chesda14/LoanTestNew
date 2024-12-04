<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class loantypeController extends Controller
{
    public function loantypeList(Request $rq){

        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
        $loantypes = DB::table('loantype')->get();
        // $genders = DB::table('gender')->get();

        return view('loantype', [

            // 'borrow' => $borrow,

             'loantypes' => $loantypes,
             'currentDate'=> $currentDate

        ]);
    }

    // public function addLoantype(Request $rq){


    //     $rq->validate([
    //         'txttypename' => 'required|integer',
    //         'txtdesc' => 'required|numeric',

    //     ]);

    //     $typeId = $rq->input('txttypeId');  Ensure you get the correct input
    //     $typename = $rq->input('txttypename');
    //     $desc = $rq->input('txtdesc');




    //     if($typeId){
    //         DB::table('loantype')
    //         ->where('loantypeId', $typeId)
    //         ->update([
    //             'typename' => $typename,
    //             'desc' => $desc,


    //         ]);

    //         echo 1;
    //     }
    //     else{

    //         DB::table('loantype')->insert([
    //             'typename' => $typename,
    //             'desc' => $desc,


    //         ]);

    //         echo 1;

    //     }




    // }


    public function addLoantype(Request $rq){


        $rq->validate([
            'txttypename' => 'required',
            'txtdesc' => 'required',

        ]);

        $loantypeId = $rq->input('txttypeId');  //Ensure you get the correct input
        $typename = $rq->input('txttypename');
        $desc = $rq->input('txtdesc');

        //$loanplan = DB::table('loantype')->where('loantypeId', $loantypeId)->first();

        if($loantypeId){
            DB::table('loantype')
            ->where('loantypeId', $loantypeId)
            ->update([
                'typename' => $typename,
                'desc' => $desc,




            ]);

            echo 1;
        }
        else{

            DB::table('loantype')->insert([
                'typename' => $typename,
                'desc' => $desc,



            ]);

            echo 1;

        }

    }


    public function deleteLoantype(Request $request){
        $loantypeId = $request->input('loantypeId');

        DB::table('loantype')->where('loantypeId', $loantypeId)->delete();

        return redirect('/loantype');
    }
}
