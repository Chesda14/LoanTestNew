<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\borrower;
use Carbon\Carbon;

class borrowerController extends Controller
{

    function borrowerList()
    {

        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
        $borrowers = DB::table('borrower')
            ->join('gender', 'borrower.genderId', '=', 'gender.genderId')
            ->select('borrower.*', 'gender.genderName')
            ->get();

        $genders = DB::table('gender')->get();
        return view('borrower', [


            'borrowers' => $borrowers,
            'genders' => $genders,
            'currentDate' => $currentDate

        ]);
    }

    public function addBorrower(Request $rq)
    {

        $rq->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'genderId' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'email' => 'required',
            'taxid' => 'required',

        ]);


        DB::table('borrower')->insert([
            'firstname' => $rq->input('firstname'),
            'lastname' => $rq->input('lastname'),
            'genderId' => $rq->input('genderId'),
            'contact' => $rq->input('contact'),
            'address' => $rq->input('address'),
            'email' => $rq->input('email'),
            'taxid' => $rq->input('taxid'),

        ]);


        return redirect('/borrower')->with('status', 'Proccess has been successfully.');
    }

    public function getborrower($borrowerid)
    {

        $borrower = DB::table('borrower')->where('borrowerid', $borrowerid)->first();
        $genders = DB::table('gender')->get();


        if (!$borrower) {
            return response()->json(['error' => 'Borrower not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'borrower' => $borrower,
            'genders' => $genders

        ]);
    }



    public function updateBorrower(Request $request)
    {

        $borrowerid = $request->input('borrowerid');

        DB::table('borrower')
            ->where('borrowerid', $borrowerid)
            ->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'genderId' => $request->input('genderId'),
                'contact' => $request->input('contact'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'taxid' => $request->input('taxid'),
            ]);

        return redirect('/borrower')->with('status', 'Borrower updated successfully.');

    }

    public function deleteBorrower(Request $request)
    {
        $borrowerid = $request->input('borrowerid');

        DB::table('borrower')->where('borrowerid', $borrowerid)->delete();

        return redirect('/borrower')->with('status', 'Borrower delete successfully.');
    }


    function userborrower()
    {
        $borrowers = DB::table('borrower')
            ->join('gender', 'borrower.genderId', '=', 'gender.genderId')
            ->select('borrower.*', 'gender.genderName')
            ->paginate();

        $genders = DB::table('gender')->get();

        return response()->json([

            'borrowers' => $borrowers,
            'genders' => $genders

        ]);
    }

    public function NewBorrower(Request $rq)
    {
        // Validate the request inputs
        $rq->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'genderId' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'email' => 'required',
            'taxid' => 'required',
        ]);

        // Insert the new borrower into the database
        try {
            DB::table('borrower')->insert([
                'firstname' => $rq->input('firstname'),
                'lastname' => $rq->input('lastname'),
                'genderId' => $rq->input('genderId'),
                'contact' => $rq->input('contact'),
                'address' => $rq->input('address'),
                'email' => $rq->input('email'),
                'taxid' => $rq->input('taxid'),
            ]);

            // Return a JSON response indicating success
            return response()->json([
                'status' => 'success',
                'message' => 'Process has been successfully completed.'
            ], 201);
        } catch (\Exception $e) {
            // Return a JSON response indicating an error
            return response()->json([
                'status' => 'error',
                'message' => 'There was an error processing your request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBorrowerById($borrowerid)
    {
        try {
            // Fetch the borrower by ID using the Query Builder
            $borrower = DB::table('borrower')->where('borrowerid', $borrowerid)->first();

            if ($borrower) {
                return response()->json([
                    'status' => 'success',
                    'data' => $borrower
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

    public function EditBorrower(Request $request)
    {
        // $request->validate([
        //     'borrowerid' => 'required|exists:borrower,borrowerid',
        //     'firstname' => 'required|string|max:255',
        //     'lastname' => 'required|string|max:255',
        //     'genderId' => 'required',
        //     'contact' => 'required|string|max:255',
        //     'address' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        //     'taxid' => 'required|string|max:255',
        // ]);

        $borrowerid = $request->input('borrowerid');

        DB::table('borrower')
            ->where('borrowerid', $borrowerid)
            ->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'genderId' => $request->input('genderId'),
                'contact' => $request->input('contact'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'taxid' => $request->input('taxid'),
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Process has been successfully completed.'
        ], 201);
    }


    public function BorrowerDelete($borrowerid)
    {
        try {
            // Check if borrower exists
            $borrower = DB::table('borrower')->where('borrowerid', $borrowerid)->first();

            if (!$borrower) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Borrower not found.'
                ], 404);
            }

            // Delete borrower
            DB::table('borrower')->where('borrowerid', $borrowerid)->delete();

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



}
