<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class loanplanController extends Controller
{

    public function loanplanList(Request $rq){

        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
        $loanplans = DB::table('loanplan')->get();
        // $genders = DB::table('gender')->get();

        return view('loanplan', [

            // 'borrow' => $borrow,

             'loanplans' => $loanplans,
             'currentDate' => $currentDate

        ]);
    }

    public function addLoanplan(Request $rq){


        $rq->validate([
            'txtmonth' => 'required|integer',
            'txtinterest' => 'required|numeric',
            'txtpenalty' => 'required|numeric',
        ]);

        $loanplanId = $rq->input('txtloanId'); // Ensure you get the correct input
        $month = $rq->input('txtmonth');
        $interest = $rq->input('txtinterest');
        $penalty = $rq->input('txtpenalty');

        if($loanplanId){
            DB::table('loanplan')
            ->where('loanplanId', $loanplanId)
            ->update([
                'month' => $month,
                'interest' => $interest,
                'penalty' => $penalty,



            ]);

            echo 1;
        }
        else{

            DB::table('loanplan')->insert([
                'month' => $month,
                'interest' => $interest,
                'penalty' => $penalty,



            ]);

            echo 1;

        }

    }

    public function deleteLoanplan(Request $request){
        $loanplanId = $request->input('loanplanId');

        DB::table('loanplan')->where('loanplanId', $loanplanId)->delete();

        return redirect('/loanplan')->with('status', 'Borrower delete successfully.');
    }
}
