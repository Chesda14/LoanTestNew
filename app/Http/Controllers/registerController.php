<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class registerController extends Controller
{
    public function register(Request $rq)
    {



        // echo 1;
        return view('login.new_register');


    }
    // public function addregister(Request $rq)
    // {

    //     // $rq->validate([
    //     //     'username' => 'required',
    //     //     'email' => 'required',
    //     //     'password' => 'required',

    //     // ]);
    //       // Validate the request
    // $rq->validate([
    //     // 'username' => 'required|string|max:255',
    //     // 'email' => 'required|string|email|max:255|unique:users',
    //     // 'password' => 'required|string|min:8|confirmed',

    //     'username' => 'required',
    //     'email' => 'required',
    //     'password' => 'required',
    // ]);




    //     DB::table('user')->insert([
    //         'username' => $rq->input('username'),
    //         'email' => $rq->input('email'),
    //         'password' => $rq->input('password'),

    //     ]);


    //     // echo 1;
    //     return redirect('/user')->with('status', 'Proccess has been successfully.');


    // }

    public function addregister(Request $rq)
{
    // Validate the request
    $rq->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:user,email', // Ensure email is unique in the 'user' table
        'password' => 'required', // Add more password rules as necessary
    ]);

    // If validation passes, insert the new user record into the database
    DB::table('user')->insert([
        'username' => $rq->input('username'),
        'email' => $rq->input('email'),
        'password' => bcrypt($rq->input('password')), // Encrypt the password before storing it
    ]);

    // Redirect to the user page with a success message
    return redirect('/user')->with('status', 'Process has been successfully completed.');
}


    public function getuser($userid)
    {

        //$borrower = borrower::find($borrowerid);
        $users = DB::table('user')->where('userid', $userid)->first();
        // $genders = DB::table('gender')->get();


        if (!$users) {
            return response()->json(['error' => 'Borrower not found'], 404);
        }

        // return response()->json([
        //     'status' => 200,
        //     'users' => $users
        // ]);
        return view('edituser', [

            // 'borrow' => $borrow,
            'users' => $users


        ]);
    }



    public function updateUser(Request $request)
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

        $userid = $request->input('userid');

        DB::table('user')
            ->where('userid', $userid)
            ->update([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),



            ]);

        return redirect('/user')->with('status', 'User updated successfully.');
        //return response()->json(['status' => 'Borrower deleted successfully.']);
    }


    public function deleteUser(Request $rq){

        $userid = $rq->input('userid');

        DB::table('user')->where('userid', $userid)->delete();

        return redirect('/user')->with('status', 'User delete successfully.');
    }
}
