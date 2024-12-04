<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class paymentController extends Controller
{


    function paymentList()
    {
        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
        $payments = DB::table('payment')
        ->join('loan', 'payment.lrcid', '=' , 'loan.lrcid')
        ->join('borrower', 'loan.borrowerid', '=' , 'borrower.borrowerid')
        ->join('loanplan', 'loan.loanplanId', '=' , 'loanplan.loanplanId')
        ->select(
            'payment.*',
            'loan.amount',
            'borrower.firstname',
            'borrower.lastname',
            'loanplan.month',
            'loanplan.interest',
            'loanplan.penalty',
            )->get();



        //$borrowers = DB::table('borrower')->paginate(5);
        $loans = DB::table('loan')
        ->join('borrower', 'loan.borrowerid', '=', 'borrower.borrowerid')
        ->join('loanplan', 'loan.loanplanId', '=', 'loanplan.loanplanId')
        ->join('loantype', 'loan.loantypeId', '=', 'loantype.loantypeId')
        ->select(
            'loan.*',
            'borrower.taxid',
            'borrower.firstname',
            'borrower.lastname',
            'borrower.genderId',
            'borrower.address',
            'borrower.contact',
            'loanplan.month',
            'loanplan.interest',
            'loanplan.penalty',
            'loantype.typename',
            'loantype.desc')->get() ->reverse(); // Reverse the collection

        return view('payment', [

             'payments' => $payments,
            'loans' => $loans,
            'currentDate' =>$currentDate


        ]);
    }

    // public function addPayment(Request $rq)
    // {

    //     $rq->validate([
    //         'loanId' => 'required',
    //         'returnamount' => 'required',
    //         'penaltyamount' => 'required',


    //     ]);



    //     DB::table('payment')->insert([
    //         'loanId' => $rq->input('loanId'),
    //         'returnamount' => $rq->input('returnamount'),
    //         'returnpenalty' => $rq->input('returnpenalty'),

    //     ]);



    //     return redirect('/payment')->with('status', 'Proccess has been successfully.');
    // }
    public function getloan(Request $request) {
        $loan = DB::table('loan')->where('lrcid', $request->lrcid)->first();
        return response()->json($loan);
    }

    public function addPayment(Request $request)
    {
        $request->validate([
            'lrcid' => 'required',
            'costAmount' => 'required',
            'penaltyAmount' => 'required',
            'datetime' => 'required',
        ]);

        $lrcid = $request->input('lrcid');
        $costAmount = $request->input('costAmount');
        $penaltyAmount = $request->input('penaltyAmount');
        $datetime = $request->input('datetime');
        // $nextpayment = $request->input('nextpayment');

        $nextpayment = Carbon::parse($request->input('datetime'))->addMonth()->format('Y-m-d');



        // Insert the loan record
        DB::table('payment')->insert([

            'lrcid' => $lrcid,
            'costAmount' => $costAmount,
            'penaltyAmount' => $penaltyAmount,
            'datetime' => $datetime,
            'nextpayment' => $nextpayment,
        ]);


        return redirect('/payment')->with('status', 'Proccess has been successfully.');
    }

//     public function addPayment(Request $rq)
// {
//     // Validate the request
//     $rq->validate([
//         'lrcid' => 'required',
//         'costAmount' => 'required',
//         'penaltyAmount' => 'required',
//         'datetime' => 'required',
//     ]);

//     try {
//         // Log the request data
//         Log::info('Request Data: ', $rq->all());

//         // Insert the validated data into the 'payments' table
//         DB::table('payment')->insert([
//             'lrcid' => $rq->input('lrcid'),
//             'costAmount' => $rq->input('costAmount'),
//             'penaltyAmount' => $rq->input('penaltyAmount'),
//             'datetime' => $rq->input('datetime'),
//         ]);

//         // Log success
//         Log::info('Payment added successfully.');

//         // Redirect back to /payment with a success message
//         return redirect('/payment')->with('status', 'Process has been successfully.');


//     } catch (\Exception $e) {
//         // Log the error
//         Log::error('Error adding payment: ', ['message' => $e->getMessage()]);

//         // Handle the error
//         return redirect('/payment')->with('error', 'An error occurred: ' . $e->getMessage());
//     }
// }

// public function getPayment($paymentId)
// {

//     $payments = DB::table('payment')->where('paymentId', $paymentId)->first();
//     $loans = DB::table('loan')

//     ->join('borrower', 'loan.borrowerid', '=' , 'borrower.borrowerid')

//     ->select(
//         'loan.*',
//         'borrower.taxid',
//         'borrower.firstname',
//         'borrower.lastname',

//         )->get();


//     if (!$paymentId) {
//         return response()->json(['error' => 'Loan not found'], 404);
//     }

//     return response()->json([
//         'payments' => $payments,
//         'loans' => $loans,


//     ]);
// }



public function getPayment($paymentId)
{
    $payments = DB::table('payment')->where('paymentId', $paymentId)->first();

    if (!$payments) {
        return response()->json(['error' => 'Payment not found'], 404);
    }

    $loans = DB::table('loan')

        ->select(
            'loan.*'
        )  ->get();


    return response()->json([
        'payments' => $payments,
        'loans' => $loans,
    ]);
}

public function updatePayment(Request $request)
{
    $paymentId = $request->input('paymentId');

    $lrcid = $request->input('lrcid');
    $costAmount = $request->input('costAmount');
    $penaltyAmount = $request->input('penaltyAmount');
    $datetime = $request->input('datetime');
    // $nextpayment = $request->input('nextpayment');

    $nextpayment = Carbon::parse($request->input('datetime'))->addMonth()->format('Y-m-d');




    DB::table('payment')
    ->where('paymentId', $paymentId)
    ->update([

        'lrcid' => $lrcid,
        'costAmount' => $costAmount,
        'penaltyAmount' => $penaltyAmount,
        'datetime' => $datetime,
        'nextpayment' => $nextpayment,
    ]);


    // DB::table('payment')
    //     ->where('paymentId', $paymentId)
    //     ->update([
    //         'lrcid' => $rq->input('lrcid'),
    //         'costAmount' => $rq->input('costAmount'),
    //         'penaltyAmount' => $rq->input('penaltyAmount'),
    //     ]);

    return redirect('/payment')->with('status', 'Payment updated successfully.');
    //return response()->json(['status' => 'Borrower deleted successfully.']);
}


public function deletePayment(Request $rq){
    $paymentId = $rq->input('paymentId');

    DB::table('payment')->where('paymentId', $paymentId)->delete();

    return redirect('/payment')->with('status', 'Borrower delete successfully.');
}



function userpayment()
{
    $payments = DB::table('payment')
    ->join('loan', 'payment.lrcid', '=' , 'loan.lrcid')
    ->join('borrower', 'loan.borrowerid', '=' , 'borrower.borrowerid')
    ->join('loanplan', 'loan.loanplanId', '=' , 'loanplan.loanplanId')
    ->select(
        'payment.*',
        'loan.amount',
        'borrower.firstname',
        'borrower.lastname',
        'loanplan.month',
        'loanplan.interest',
        'loanplan.penalty',
        )->get();



    //$borrowers = DB::table('borrower')->paginate(5);
    $loans = DB::table('loan')
    ->join('borrower', 'loan.borrowerid', '=', 'borrower.borrowerid')
    ->join('loanplan', 'loan.loanplanId', '=', 'loanplan.loanplanId')
    ->join('loantype', 'loan.loantypeId', '=', 'loantype.loantypeId')
    ->select(
        'loan.*',
        'borrower.taxid',
        'borrower.firstname',
        'borrower.lastname',
        'borrower.genderId',
        'borrower.address',
        'borrower.contact',
        'loanplan.month',
        'loanplan.interest',
        'loanplan.penalty',
        'loantype.typename',
        'loantype.desc')->get();

        return response()->json([
            'payments' => [
                'data' => $payments
            ],
            'loans' => $loans
        ]);
}

// function fetchPayment()
// {
//     $payments = DB::table('payment')
//     ->join('loan', 'payment.lrcid', '=' , 'loan.lrcid')
//     ->join('borrower', 'loan.borrowerid', '=' , 'borrower.borrowerid')
//     ->join('loanplan', 'loan.loanplanId', '=' , 'loanplan.loanplanId')
//     ->select(
//         'payment.*',
//         'loan.amount',
//         'borrower.firstname',
//         'borrower.lastname',
//         'loanplan.month',
//         'loanplan.interest',
//         'loanplan.penalty',
//         )->get();



//     //$borrowers = DB::table('borrower')->paginate(5);
//     $loans = DB::table('loan')
//     ->join('borrower', 'loan.borrowerid', '=', 'borrower.borrowerid')
//     ->join('loanplan', 'loan.loanplanId', '=', 'loanplan.loanplanId')
//     ->join('loantype', 'loan.loantypeId', '=', 'loantype.loantypeId')
//     ->select(
//         'loan.*',
//         'borrower.taxid',
//         'borrower.firstname',
//         'borrower.lastname',
//         'borrower.genderId',
//         'borrower.address',
//         'borrower.contact',
//         'loanplan.month',
//         'loanplan.interest',
//         'loanplan.penalty',
//         'loantype.typename',
//         'loantype.desc')->get();

//     return response()->json([

//          'payments' => $payments,
//         'loans' => $loans,


//     ]);
// }


public function fetchPayment(Request $request, $lrcid)
{
    if (!$lrcid) {
        return response()->json([
            'status' => 'error',
            'message' => 'lrcid is required'
        ], 400);
    }

    try {
        $loan = DB::table('loan')->where('lrcid', $lrcid)->first();
        if ($loan) {
            return response()->json($loan, 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "Loan details not found for lrcid: $lrcid"
            ], 404);
        }
    } catch (\Exception $e) {
        \Log::error('Failed to fetch loan: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch loan: ' . $e->getMessage()
        ], 500);
    }
}



public function getLrcList() {
    try {
        $lrcList = DB::table('loan')->select('lrcid')->distinct()->get();
        return response()->json($lrcList, 200);
    } catch (\Exception $e) {
        \Log::error('Failed to fetch lrc list: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch lrc list: ' . $e->getMessage()
        ], 500);
    }
}

public function GetPaymentbyId($paymentId)
{
    try {
        // Fetch the borrower by ID using the Query Builder
        $payment = DB::table('payment')->where('paymentId', $paymentId)->first();

        if ($payment) {
            return response()->json([
                'status' => 'success',
                'data' => $payment
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Borrower not found.'
            ], 404);
        }
    } catch (\Exception $e) {
        // Log the exception message
        \Log::error('Failed to fetch borrower: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch borrower: ' . $e->getMessage()
        ], 500);
    }
}


public function NewPayment(Request $request)
{
    $request->validate([
        'lrcid' => 'required',
        'costAmount' => 'required',
        'penaltyAmount' => 'required',
        'datetime' => 'required',
    ]);

    $lrcid = $request->input('lrcid');
    $costAmount = $request->input('costAmount');
    $penaltyAmount = $request->input('penaltyAmount');
    $datetime = $request->input('datetime');
    // $nextpayment = $request->input('nextpayment');

    $nextpayment = Carbon::parse($request->input('datetime'))->addMonth()->format('Y-m-d');



    // Insert the loan record
    DB::table('payment')->insert([

        'lrcid' => $lrcid,
        'costAmount' => $costAmount,
        'penaltyAmount' => $penaltyAmount,
        'datetime' => $datetime,
        'nextpayment' => $nextpayment,
    ]);


    return response()->json([
        'status' => 'success',
        'message' => 'Process has been successfully completed.'
    ], 201);
}

public function PaymentDelete($paymentId)
{
    try {
        // Check if borrower exists
        $payment = DB::table('payment')->where('paymentId', $paymentId)->first();

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Borrower not found.'
            ], 404);
        }

        // Delete borrower
        DB::table('payment')->where('paymentId', $paymentId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Borrower successfully deleted.'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete borrower: ' . $e->getMessage()
        ], 500);
    }
}

public function EditPayment(Request $request)
{
    $paymentId = $request->input('paymentId');

    $lrcid = $request->input('lrcid');
    $costAmount = $request->input('costAmount');
    $penaltyAmount = $request->input('penaltyAmount');
    $datetime = $request->input('datetime');
    // $nextpayment = $request->input('nextpayment');

    $nextpayment = Carbon::parse($request->input('datetime'))->addMonth()->format('Y-m-d');




    DB::table('payment')
    ->where('paymentId', $paymentId)
    ->update([

        'lrcid' => $lrcid,
        'costAmount' => $costAmount,
        'penaltyAmount' => $penaltyAmount,
        'datetime' => $datetime,
        'nextpayment' => $nextpayment,
    ]);


    // DB::table('payment')
    //     ->where('paymentId', $paymentId)
    //     ->update([
    //         'lrcid' => $rq->input('lrcid'),
    //         'costAmount' => $rq->input('costAmount'),
    //         'penaltyAmount' => $rq->input('penaltyAmount'),
    //     ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Process has been successfully completed.'
    ], 201);
}


}
