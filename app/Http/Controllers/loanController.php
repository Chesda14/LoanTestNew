<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class loanController extends Controller
{

    public function loanList() {

        $loans = DB::table('loan')
            ->join('borrower', 'loan.borrowerid', '=', 'borrower.borrowerid')
            ->join('gender', 'borrower.genderId', '=', 'gender.genderId')
            ->join('loanplan', 'loan.loanplanId', '=', 'loanplan.loanplanId')
            ->join('loantype', 'loan.loantypeId', '=', 'loantype.loantypeId')
            ->join('staff', 'loan.staffId', '=', 'staff.staffId')
            ->select(
                'loan.*',
                'gender.genderName',
                'borrower.firstname',
                'borrower.lastname',
                'borrower.genderId',
                'borrower.address',
                'borrower.contact',
                'loanplan.month',
                'loanplan.interest',
                'loanplan.penalty',
                'loantype.typename',
                'loantype.desc',
                'staff.staff_firstname',
                'staff.staff_lastname')
                ->get()
                 ; // Reverse the collection

//dd($loans);

        // $genders = DB::table('gender')
        // ->join('gender', 'borrower.genderId', '=', 'gender.genderId')->select('gender.genderName')->get();

        // $borrowers = DB::table('borrower')
        // ->join('gender', 'borrower.genderId', '=', 'gender.genderId')
        // ->select('borrower.*', 'gender.genderName')
        // ->get();
        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format

        $borrowers = DB::table('borrower')->get();
        $loanplans = DB::table('loanplan')->get();
        $loantypes = DB::table('loantype')->get();
        $staffs = DB::table('staff')->get();



        return view('loan', [
            'loans' => $loans,
            'borrowers' => $borrowers,
            'loanplans' => $loanplans,
            'loantypes' => $loantypes,
            'staffs' => $staffs,
            'currentDate' => $currentDate,

        ]);
    }



    public function addLoan(Request $request)
{
    $request->validate([
        'borrowerid' => 'required',
        'loanplanId' => 'required',
        'loantypeId' => 'required',
        'staffId' => 'required',
        'lrcid' => 'required',
        'startdate' => 'required',
        'status' => 'required',
        'amount' => 'required|numeric'
    ]);

    $borrowerId = $request->input('borrowerid');
    $loanplanId = $request->input('loanplanId');
    $loantypeId = $request->input('loantypeId');
    $staffId = $request->input('staffId');
    $amount = $request->input('amount');
    $lrcid = $request->input('lrcid');
    $startdate = $request->input('startdate');
    $status = $request->input('status');

    // Fetch the relevant loan plan, borrower, and loan type data
    $borrower = DB::table('borrower')->where('borrowerid', $borrowerId)->first();
    $loanplan = DB::table('loanplan')->where('loanplanId', $loanplanId)->first();
    $loantype = DB::table('loantype')->where('loantypeId', $loantypeId)->first();
    $staff = DB::table('staff')->where('staffId', $staffId)->first();

    // Error handling for missing records
    if (!$borrower || !$loanplan || !$loantype || !$staff) {
        return back()->with('error', 'Invalid borrower, loan plan, or loan type.');
    }

    // Calculate the loan details
    $costAmount = $amount / $loanplan->month;
    $interestAmount = ($amount * $loanplan->interest) / 100;
    $penaltyAmount = ($amount * $loanplan->penalty) / 100;
    $totalAmount = $costAmount + $interestAmount ;

    // Calculate the end date
    $startDateCarbon = Carbon::createFromFormat('Y-m-d', $startdate);
    $enddate = $startDateCarbon->addMonths(intval($loanplan->month));



    // Insert the loan record
    DB::table('loan')->insert([
        'borrowerid' => $borrowerId,
        'loanplanId' => $loanplanId,
        'loantypeId' => $loantypeId,
        'staffId' => $staffId,
        'amount' => $amount,
        'costAmount' => $costAmount,
        'interestAmount' => $interestAmount,
        'penaltyAmount' => $penaltyAmount,
        'totalAmount' => $totalAmount,
        'lrcid' => $lrcid,
        'startdate' => $startdate,
        'enddate' => $enddate,
        'status' => $status
    ]);


    return redirect('/loans')->with('status', 'Proccess has been successfully.');
}

public function getloan($loanId)
{

    $loans = DB::table('loan')->where('loanId', $loanId)->first();
    $borrowers = DB::table('borrower')->get();
    $loanplans = DB::table('loanplan')->get();
    $loantypes = DB::table('loantype')->get();
    $staffs = DB::table('staff')->get();



    if (!$loans) {
        return response()->json(['error' => 'Loan not found'], 404);
    }

    return response()->json([
        'loans' => $loans,
        'borrowers' => $borrowers,
        'loanplans' => $loanplans,
        'loantypes' => $loantypes,
        'staffs' => $staffs,

    ]);
}

public function updateLoan(Request $request)
{
    $loanId = $request->input('loanId');
    $borrowerId = $request->input('borrowerid');
    $loanplanId = $request->input('loanplanId');
    $loantypeId = $request->input('loantypeId');
    $staffId = $request->input('staffId');
    $amount = $request->input('amount');
    $lrcid = $request->input('lrcid');
    $startdate = $request->input('startdate');
    $status = $request->input('status');

    // Fetch the relevant loan plan, borrower, and loan type data
    $borrower = DB::table('borrower')->where('borrowerid', $borrowerId)->first();
    $loanplan = DB::table('loanplan')->where('loanplanId', $loanplanId)->first();
    $loantype = DB::table('loantype')->where('loantypeId', $loantypeId)->first();
    $staff = DB::table('staff')->where('staffId', $staffId)->first();

    // Error handling for missing records
    if (!$borrower || !$loanplan || !$loantype || !$staff) {
        return back()->with('error', 'Invalid borrower, loan plan, or loan type.');
    }

    // Calculate the loan details
    $costAmount = $amount / $loanplan->month;
    $interestAmount = ($amount * $loanplan->interest) / 100;
    $penaltyAmount = ($amount * $loanplan->penalty) / 100;
    $totalAmount = $costAmount + $interestAmount ;

      // Calculate the end date
      $startDateCarbon = Carbon::createFromFormat('Y-m-d', $startdate);
      $enddate = $startDateCarbon->addMonths($loanplan->month);


    DB::table('loan')
        ->where('loanId', $loanId)
        ->update([
            'borrowerid' => $borrowerId,
            'loanplanId' => $loanplanId,
            'loantypeId' => $loantypeId,
            'staffId' => $staffId,
            'amount' => $amount,
            'costAmount' => $costAmount,
            'interestAmount' => $interestAmount,
            'penaltyAmount' => $penaltyAmount,
            'totalAmount' => $totalAmount,
            'lrcid' => $lrcid,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'status' => $status
        ]);

    return redirect('/loans')->with('status', 'Loan updated successfully.');

}
// public function getloan($LoanId)
// {
//     $loan = DB::table('loan')
//         ->join('borrower', 'loan.borrowerid', '=', 'borrower.borrowerid')
//         ->join('loanplan', 'loan.loanplanId', '=', 'loanplan.loanplanId')
//         ->join('loantype', 'loan.loantypeId', '=', 'loantype.loantypeId')
//         ->select('loan.*', 'borrower.firstname', 'borrower.lastname', 'loanplan.month', 'loantype.loantypeName')
//         ->where('loan.loanid', $LoanId)
//         ->first();

//     $borrowers = DB::table('borrower')->get();
//     $loanplans = DB::table('loanplan')->get();
//     $loantypes = DB::table('loantype')->get();

//     if ($loan) {
//         return response()->json([
//             'loan' => $loan,
//             'borrowers' => $borrowers,
//             'loanplans' => $loanplans,
//             'loantypes' => $loantypes,
//         ]);
//     } else {
//         return response()->json(['error' => 'Loan not found'], 404);
//     }
// }
public function deleteLoan(Request $request){
    $LoanId = $request->input('LoanId');

    DB::table('loan')->where('LoanId', $LoanId)->delete();

    return redirect('/loans')->with('status', 'Borrower delete successfully.');
}


public function userloan() {
    $loans = DB::table('loan')
        ->join('borrower', 'loan.borrowerid', '=', 'borrower.borrowerid')
        ->join('gender', 'borrower.genderId', '=', 'gender.genderId')
        ->join('loanplan', 'loan.loanplanId', '=', 'loanplan.loanplanId')
        ->join('loantype', 'loan.loantypeId', '=', 'loantype.loantypeId')
        ->join('staff', 'loan.staffId', '=', 'staff.staffId')
        ->select(
            'loan.*',
            'gender.genderName',
            'borrower.firstname',
            'borrower.lastname',
            'borrower.genderId',
            'borrower.address',
            'borrower.contact',
            'loanplan.month',
            'loanplan.interest',
            'loanplan.penalty',
            'loantype.typename',
            'loantype.desc',
            'staff.staff_firstname',
            'staff.staff_lastname'
        )->get();

    $borrowers = DB::table('borrower')->get();
    $loanplans = DB::table('loanplan')->get();
    $loantypes = DB::table('loantype')->get();
    $staffs = DB::table('staff')->get();

    return response()->json([
        'loans' => $loans,
        'borrowers' => $borrowers,
        'loanplans' => $loanplans,
        'loantypes' => $loantypes,
        'staffs' => $staffs
    ]);
}

public function getBorrowers() {
    $borrowers = DB::table('borrower')->get();
    // return response()->json($borrowers);
    return response()->json([

        'borrowers' => $borrowers
    ]);
}

public function getLoanPlans() {
    $loanplans = DB::table('loanplan')->get();
    // return response()->json($loanplans);
     return response()->json([

        'loanplans' => $loanplans
    ]);
}


public function getLoanTypes() {
    $loantypes = DB::table('loantype')->get();
    // return response()->json($loantypes);
    return response()->json([

        'loantypes' => $loantypes
    ]);
}


public function getStaffs() {
    $staffs = DB::table('staff')->get();
    // return response()->json($staffs);

    return response()->json([

        'staffs' => $staffs
    ]);
}


public function NewLoan(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'borrowerid' => 'required',
        'loanplanId' => 'required',
        'loantypeId' => 'required',
        'staffId' => 'required',
        'lrcid' => 'required',
        'startdate' => 'required|date',
        'status' => 'required',
        'amount' => 'required|numeric'
    ]);

    try {
        // Retrieve input data
        $borrowerId = $request->input('borrowerid');
        $loanplanId = $request->input('loanplanId');
        $loantypeId = $request->input('loantypeId');
        $staffId = $request->input('staffId');
        $amount = $request->input('amount');
        $lrcid = $request->input('lrcid');
        $startdate = $request->input('startdate');
        $status = $request->input('status');

        // Fetch related data
        $borrower = DB::table('borrower')->where('borrowerid', $borrowerId)->first();
        $loanplan = DB::table('loanplan')->where('loanplanId', $loanplanId)->first();
        $loantype = DB::table('loantype')->where('loantypeId', $loantypeId)->first();
        $staff = DB::table('staff')->where('staffId', $staffId)->first();

        // Error handling for missing records
        if (!$borrower || !$loanplan || !$loantype || !$staff) {
            return response()->json(['error' => 'Invalid borrower, loan plan, loan type, or staff.'], 400);
        }

        // Calculate loan details
        $costAmount = $amount / $loanplan->month;
        $interestAmount = ($amount * $loanplan->interest) / 100;
        $penaltyAmount = ($amount * $loanplan->penalty) / 100;
        $totalAmount = $costAmount + $interestAmount;

        // Calculate end date
        $startDateCarbon = Carbon::createFromFormat('Y-m-d', $startdate);
        $enddate = $startDateCarbon->addMonths(intval($loanplan->month))->format('Y-m-d');

        // Insert loan record
        DB::table('loan')->insert([
            'borrowerid' => $borrowerId,
            'loanplanId' => $loanplanId,
            'loantypeId' => $loantypeId,
            'staffId' => $staffId,
            'amount' => $amount,
            'costAmount' => $costAmount,
            'interestAmount' => $interestAmount,
            'penaltyAmount' => $penaltyAmount,
            'totalAmount' => $totalAmount,
            'lrcid' => $lrcid,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'status' => $status
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Process has been successfully completed.'
        ], 201);
    } catch (\Exception $e) {
        // Log the error for debugging
        Log::error('NewLoan Error: ' . $e->getMessage());

        // Return error response
        return response()->json([
            'status' => 'error',
            'message' => 'There was an error processing your request.',
            'error' => $e->getMessage()
        ], 500);
    }
}



// public function NewLoans(Request $request)
// {
//     $validatedData = $request->validate([
//         'borrowerid' => 'required|exists:borrower,borrowerid',
//         'loanplanId' => 'required|exists:loanplan,loanplanId',
//         'loantypeId' => 'required|exists:loantype,loantypeId',
//         'staffId' => 'required|exists:staff,staffId',
//         'lrcid' => 'required|string|max:255',
//         'startdate' => 'required|date_format:Y-m-d',
//         'amount' => 'required|numeric|min:0',
//         'status' => 'nullable|string|max:255'
//     ]);

//     $borrowerId = $request->input('borrowerid');
//     $loanplanId = $request->input('loanplanId');
//     $loantypeId = $request->input('loantypeId');
//     $staffId = $request->input('staffId');
//     $amount = $request->input('amount');
//     $lrcid = $request->input('lrcid');
//     $startdate = $request->input('startdate');
//     $status = $request->input('status', 'pending'); // Default status if not provided

//     // Fetch the relevant loan plan, borrower, and loan type data
//     $loanplan = DB::table('loanplan')->where('loanplanId', $loanplanId)->first();
//     $startDateCarbon = Carbon::createFromFormat('Y-m-d', $startdate);
//     $enddate = $startDateCarbon->copy()->addMonths(intval($loanplan->month));

//     // Calculate the loan details
//     $costAmount = $amount / $loanplan->month;
//     $interestAmount = ($amount * $loanplan->interest) / 100;
//     $penaltyAmount = ($amount * $loanplan->penalty) / 100;
//     $totalAmount = $costAmount + $interestAmount;

//     // Insert the loan record
//     DB::table('loan')->insert([
//         'borrowerid' => $borrowerId,
//         'loanplanId' => $loanplanId,
//         'loantypeId' => $loantypeId,
//         'staffId' => $staffId,
//         'amount' => $amount,
//         'costAmount' => $costAmount,
//         'interestAmount' => $interestAmount,
//         'penaltyAmount' => $penaltyAmount,
//         'totalAmount' => $totalAmount,
//         'lrcid' => $lrcid,
//         'startdate' => $startdate,
//         'enddate' => $enddate,
//         'status' => $status
//     ]);

//     return response()->json([
//         'status' => 'success',
//         'message' => 'Process has been successfully completed.'
//     ], 201);
// }


public function getLoanById($loanId)
{
    try {
        // Fetch the borrower by ID using the Query Builder
        $loan = DB::table('loan')->where('loanId', $loanId)->first();

        if ($loan) {
            return response()->json([
                'status' => 'success',
                'data' => $loan
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

public function EditLoan(Request $request)
{
    $loanId = $request->input('loanId');
    $borrowerId = $request->input('borrowerid');
    $loanplanId = $request->input('loanplanId');
    $loantypeId = $request->input('loantypeId');
    $staffId = $request->input('staffId');
    $amount = $request->input('amount');
    $lrcid = $request->input('lrcid');
    $startdate = $request->input('startdate');
    // $status = $request->input('status');

    // Fetch the relevant loan plan, borrower, and loan type data
    $borrower = DB::table('borrower')->where('borrowerid', $borrowerId)->first();
    $loanplan = DB::table('loanplan')->where('loanplanId', $loanplanId)->first();
    $loantype = DB::table('loantype')->where('loantypeId', $loantypeId)->first();
    $staff = DB::table('staff')->where('staffId', $staffId)->first();

    // Error handling for missing records
    if (!$borrower || !$loanplan || !$loantype || !$staff) {
        return back()->with('error', 'Invalid borrower, loan plan, or loan type.');
    }

    // Calculate the loan details
    $costAmount = $amount / $loanplan->month;
    $interestAmount = ($amount * $loanplan->interest) / 100;
    $penaltyAmount = ($amount * $loanplan->penalty) / 100;
    $totalAmount = $costAmount + $interestAmount ;

      // Calculate the end date
      $startDateCarbon = Carbon::createFromFormat('Y-m-d', $startdate);
      $enddate = $startDateCarbon->addMonths($loanplan->month);


    DB::table('loan')
        ->where('loanId', $loanId)
        ->update([
            'borrowerid' => $borrowerId,
            'loanplanId' => $loanplanId,
            'loantypeId' => $loantypeId,
            'staffId' => $staffId,
            'amount' => $amount,
            'costAmount' => $costAmount,
            'interestAmount' => $interestAmount,
            'penaltyAmount' => $penaltyAmount,
            'totalAmount' => $totalAmount,
            'lrcid' => $lrcid,
            'startdate' => $startdate,
            'enddate' => $enddate

        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Loan successfully updated.'
        ], 200);


}

public function LoanDelete($loanId)
{
    try {
        // Check if borrower exists
        $loan = DB::table('loan')->where('loanId', $loanId)->first();

        if (!$loan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Borrower not found.'
            ], 404);
        }

        // Delete borrower
        DB::table('loan')->where('loanId', $loanId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Loan successfully deleted.'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete borrower: ' . $e->getMessage()
        ], 500);
    }
}


}
