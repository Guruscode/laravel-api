<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
     private $status_code = 200;
      
     public function userSignup(Request $request) {
        $validator          =       Validator::make($request->all(), [
            "first_name"    =>      "required",
            "last_name"    =>      "required",
            "email"         =>      "required|email",
            "occupation"    =>      "required",
            "bussines_type"    =>    "required",
            "password"      =>      "required",
            "location"    =>         "required"
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => "failed",
                "message" => "validation_error",
                "errors" =>   $validator->errors()
            ]);
        }
        $name                   =       $request->first_name;
        $name                   =       explode(" ", $name);
        $first_name             =       $name[0];
        $last_name              =       "";
        if(isset($name[1])) {
            $last_name          =       $name[1];
        }
        $userDataArray          =       array(
            "first_name"         =>          $first_name,
            "last_name"          =>          $last_name,
            "occupation"          =>          $request->occupation,
            "email"              =>          $request->email,
            "bussines_type"       =>  $request->bussines_type,
            "password"           =>          md5($request->password),
            "location"           =>          $request->location
        );
        $user_status            =           User::where("email", $request->email)->first();

        if(!is_null($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! email already registered"]);
         }

         $user                   =           User::create($userDataArray);

         if(!is_null($user)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Registration completed successfully", "data" => $user]);
        }

        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "failed to register"]);
        }
    }


    
    // ------------ [ User Login ] -------------------
    public function userLogin(Request $request) {

        $validator          =       Validator::make($request->all(),
            [
                "email"             =>          "required|email",
                "password"          =>          "required"
            ]
        );

        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_error" => $validator->errors()]);
        }


        
        // check if entered email exists in db
        $email_status       =       User::where("email", $request->email)->first();

      

        // if email exists check password for the same email

        if(!is_null($email_status)) {
            $password_status    =   User::where("email", $request->email)->where("password", md5($request->password))->first();

            // if password is correct
            if(!is_null($password_status)) {
                $user           =       $this->userDetail($request->email);

                return response()->json([
                    "status" => $this->status_code,
                     "success" => true,
                      "message" => "You have logged in successfully",
                       "data" => $user
                    ]);
            }

            else {
                return response()->json(["status" => "failed",
                 "success" => false,
                  "message" => "Unable to login. Incorrect password."
                ]);
            }
        }

        else {
            return response()->json([
                "status" => "failed",
                 "success" => false,
                  "message" => "Unable to login. Email doesn't exist."
                ]);
        }
    }


    // ------------------ [ User Detail ] ---------------------
    public function userDetail($email) {
        $user               =       array();
        if($email != "") {
            $user           =       User::where("email", $email)->first();
            return $user;
        }
    }
}