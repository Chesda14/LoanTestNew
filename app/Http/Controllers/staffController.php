<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class staffController extends Controller
{
    function staffList()
    {
        //$borrow = $borrowerid ? DB::table('borrower')->where('borrowerid', $borrowerid)->first() : null;

        $staffs = DB::table('staff')
        ->join('gender', 'staff.genderId', '=', 'gender.genderId')
        ->join('position', 'staff.positionId', '=', 'position.positionId')
        ->select('staff.*', 'gender.genderName', 'position.positionName')

        ->paginate(5);

        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
         $genders = DB::table('gender')->get();
         $positions = DB::table('position')->get() ->reverse(); // Reverse the collection

        return view('staff', [

            // 'borrow' => $borrow,
            'staffs' => $staffs,
             'genders' => $genders,
             'positions' => $positions,
             'currentDate' => $currentDate

        ]);
    }


    public function addStaff(Request $rq)
    {
        // echo 1;
        $rq->validate([
            'staff_firstname' => 'required',
            'staff_lastname' => 'required',
            'genderId' => 'required',
            'staff_contact' => 'required',
            'staff_address' => 'required',
            'staff_email' => 'required',
            'staff_password' => 'required',
            'positionId' => 'required',

        ]);


        // $fname = $rq->fname;
        // $lname = $rq->lname;
        // $genid = $rq->genid;
        // $con = $rq->con;
        // $add = $rq->add;
        // $em = $rq->em;
        // $tax = $rq->tax;

        // echo $fname." ".$lname." ".$genid." ".$$con." ".$add." ".$em." ".$tax;

        DB::table('staff')->insert([
            'staff_firstname' => $rq->input('staff_firstname'),
            'staff_lastname' => $rq->input('staff_lastname'),
            'genderId' => $rq->input('genderId'),
            'staff_contact' => $rq->input('staff_contact'),
            'staff_address' => $rq->input('staff_address'),
            'staff_email' => $rq->input('staff_email'),
            'staff_password' => $rq->input('staff_password'),
            'positionId' => $rq->input('positionId'),

        ]);


        // echo 1;
        return redirect('/staff')->with('status', 'Proccess has been successfully.');
    }

    public function getStaff($staffId)
    {

        //$borrower = borrower::find($borrowerid);
        $staffs = DB::table('staff')->where('staffId', $staffId)->first();
        $genders = DB::table('gender')->get();
        $positions = DB::table('position')->get();


        if (!$staffs) {
            return response()->json(['error' => 'Borrower not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'staffs' => $staffs,
            'genders' => $genders,
            'positions'=>$positions

        ]);
    }


    public function updateStaff(Request $rq)
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

        $staffId = $rq->input('staffId');

        DB::table('staff')
            ->where('staffId', $staffId)
            ->update([
                'staff_firstname' => $rq->input('staff_firstname'),
                'staff_lastname' => $rq->input('staff_lastname'),
                'genderId' => $rq->input('genderId'),
                'staff_contact' => $rq->input('staff_contact'),
                'staff_address' => $rq->input('staff_address'),
                'staff_email' => $rq->input('staff_email'),
                'staff_password' => $rq->input('staff_password'),
                'positionId' => $rq->input('positionId'),
            ]);

        return redirect('/staff')->with('status', 'Staff updated successfully.');
        //return response()->json(['status' => 'Borrower deleted successfully.']);
    }

    public function deleteStaff(Request $rq){
        $staffId = $rq->input('staffId');

        DB::table('staff')->where('staffId', $staffId)->delete();

        return redirect('/staff')->with('status', 'Staff delete successfully.');
    }


    // public function staffLogin(Request $rq){

    //     $rq -> validate([

    //         "staff_email" => "required",
    //         "staff_password" => "required",
    //     ]);

    //     $staff_email = $rq->input('staff_email');
    //     $staff_password = $rq->input('staff_password');

    //     $result = DB::table('staff')
    //     ->where([['staff_email', '=',  $staff_email],['staff_password', '=', $staff_password]])
    //     ->first();




    //     if ($result && Hash::check($staff_password, $result->staff_password)) {
    //         // Return the staff member data in JSON format
    //         return response()->json($result, 200);
    //     } else {
    //         // Return an error response if the login fails
    //         return response()->json(['error' => 'Invalid email or password'], 401);
    //     }



    // }


    public function staffLogin(Request $rq)
    {
        $rq->validate([
            'staff_email' => 'required|email',
            'staff_password' => 'required',
        ]);

        $staff_email = $rq->input('staff_email');
        $staff_password = $rq->input('staff_password');

        $staff = DB::table('staff')
            ->where('staff_email', $staff_email)
            ->first();

        if ($staff && Hash::check($staff_password, $staff->staff_password)) {
            $token = bin2hex(random_bytes(32)); // Simple token generation
            // Store token in database or use a package like Passport for more robust token handling
            return response()->json(['token' => $token, 'success' => true], 200);
        } else {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }
}
