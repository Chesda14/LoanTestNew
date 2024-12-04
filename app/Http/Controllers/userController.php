<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use App\Http\Middleware\userMiddleware;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\userMiddleware;
use App\Http\Controller\Log;
use Carbon\Carbon;

class userController extends Controller
{
    public function showHome()
    {

        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
        return view('home', compact('currentDate'));


    }



    public function showLogin()
    {
        return view('login.login');
    }
    // function showLoginPost(Request $request)
    // {
    //     $request -> validate([

    //         "email" => "required",
    //         "password" => "required",
    //     ]);
    //     $credentials = $request->only("email", "password");
    //     if(Auth::attempt($credentials))
    //     {

    //         return redirect()->intended(route("home"));
    //     }
    //     return redirect(route("login"))-> with("error", "login fail.");
    // }

    public function showLoginPost(Request $rq){

        $rq -> validate([

            "email" => "required",
            "password" => "required",
        ]);

        $email = $rq->input('email');
        $password = $rq->input('password');

        $result = DB::table('user')
        ->where([['email', '=',  $email],['password', '=', $password]])
        ->first();


        // echo  $result->id;

        if(isset($result)){
            // echo "Success";
            $userid = $result->userid;
            $username = $result->username;

            session(['userid'=>$userid,'username'=>$username]);

            return redirect('/home');


        }else{
            $rq->session()->flash('status', 'Invalid user or password');
            return redirect('/');
            //echo "Login Fail";
        }

    }


    // public function loginAPI(Request $rq)
    // {
    //     $rq->validate([
    //         'staff_email' => 'required|email',
    //         'staff_password' => 'required',
    //     ]);

    //     $email = $rq->input('staff_email');
    //     $password = $rq->input('staff_password');


    //     $result = DB::table('staff')
    //     ->where([['staff_email', '=',  $email],['staff_password', '=', $password]])
    //     ->first();

    //     if(isset($result)){
    //         // echo "Success";
    //         $staffId = $result->staffId;
    //         $staff_firstname = $result->staff_firstname;
    //         $staff_lastname = $result->staff_lastname;

    //         session(['staffId'=>$staffId,'staff_firstname'=>$staff_firstname, 'staff_lastname'=>$staff_lastname]);

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $result
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Borrower not found.'
    //         ], 404);
    //     }




    // }

//     public function loginAPI(Request $rq)
// {
//     $rq->validate([
//         'staff_email' => 'required|email',
//         'staff_password' => 'required',
//     ]);

//     $email = $rq->input('staff_email');
//     $password = $rq->input('staff_password');

//     $staff = DB::table('staff')
//                 ->where('staff_email', $email)
//                 ->where('staff_password', $password)
//                 ->first();

//     if ($staff) {
//         // Password matches, create session or token
//         session([
//             'staffId' => $staff->staffId,
//             'staff_firstname' => $staff->staff_firstname,
//             'staff_lastname' => $staff->staff_lastname,
//         ]);

//         return response()->json([
//             'status' => 'success',
//             'data' => $staff
//         ], 200);
//     } else {
//         // Staff not found or incorrect password
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Invalid credentials.'
//         ], 401);
//     }
// }





    public function Logout(Request $rq){
        $rq->session()->flush();
        return redirect('/');
    }


    // public function showRegister()
    // {
    //     return view('login.register');
    // }
    // function showRegisterPost(Request $request)
    // {
    //     $request -> validate([
    //         "username" => "required",
    //         "email" => "required",
    //         "password" => "required",
    //     ]);
    //     $user = new User();
    //     $user->username = $request->name;
    //     $user->email = $request->email;
    //     $user->password = Hash::make($request -> password);

    //     if($user->save())
    //     {
    //         return redirect(route("login"))
    //         ->with("Success", "User register successfully.");
    //     }
    //     return redirect(route("register"))
    //     ->with("error", "User register fail.");
    // }


    function userList()
    {
        $currentDate = Carbon::now()->format('F ,d D, Y'); // 'Y-m-d' format
        $user = DB::table('user')->get();
        return view('user', [
            'User'=>$user,
            'currentDate' => $currentDate
        ]);
    }
    // public function authenticate(Request $request)
    // {
    //     $validator = validator::make($request->all(),[
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if($validator ->passes())
    //     {
    //         if(Auth::attempt(['email'=>$request->username,'password' => $request->password]))
    //         {

    //         }else
    //         {
    //             return redirect()->route('login')->wtih('Username or Password is Incorrect');
    //         }

    //     }else
    //     {
    //         return redirect()->routes('login.login')
    //         ->withInput()
    //         ->withErrors($validator);
    //     }
    // }
    // public function processRegister(Request $request)
    // {
    //     $validator = validator::make($request->all(),[
    //         'email' => 'required|email|uniqe:users',
    //         'password' => 'required|comfirmed'
    //     ]);

    //     if($validator ->passes())
    //     {
    //         $user = new User();
    //         $user -> username = $request-> username ;
    //         $user -> password = Hash::make($request -> password);
    //         $user -> role = 'customer';
    //         $user -> save();

    //         return redirect()->route('login')->wtih('Success, You have register.');

    //         if(Auth::attempt(['email'=>$request->username,'password' => $request->password]))
    //         {

    //         }else
    //         {
    //             return redirect()->route('login')->wtih('Username or Password is Incorrect');
    //         }

    //     }else
    //     {
    //         return redirect()->routes('login.login')
    //         ->withInput()
    //         ->withErrors($validator);
    //     }
    // }

    public function getuser($id)
    {

        //$borrower = borrower::find($borrowerid);
        $users = DB::table('users')->where('id', $id)->first();
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

        $id = $request->input('id');

        DB::table('users')
            ->where('id', $id)
            ->update([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),



            ]);

        return redirect('/user')->with('status', 'User updated successfully.');
        //return response()->json(['status' => 'Borrower deleted successfully.']);
    }


    public function deleteUser(Request $rq){
        $userid = $rq->input('id');

        DB::table('users')->where('id', $userid)->delete();

        return redirect('/user')->with('status', 'User delete successfully.');
    }



    public function loginAPI(Request $rq)
{
    $rq->validate([
        'staff_email' => 'required|email',
        'staff_password' => 'required',
    ]);

    $email = $rq->input('staff_email');
    $password = $rq->input('staff_password');

    $staff = DB::table('staff')
                ->where('staff_email', $email)
                ->where('staff_password', $password)
                ->first();

    if ($staff) {
        // Password matches, create session or token
        session([
            'staffId' => $staff->staffId,
            'staff_firstname' => $staff->staff_firstname,
            'staff_lastname' => $staff->staff_lastname,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $staff
        ], 200);
    } else {
        // Staff not found or incorrect password
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials.'
        ], 401);
    }
}

public function logoutAPI(Request $rq){

    $rq->session()->flush();
    return response()->json([
        'status' => 'success',
        'message' => 'Logged out successfully.'
    ], 200);
}












}
