<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function loginScreen(Request $request){
        $data = array();
        $data['errors'] = array(
            1 => ['Error: Username/Email and password combination OR Account does not exist.', 'danger'],
            2 => ['You are now logged out', 'primary'],
            5 => ['Error: Access Denied.', 'danger'],
            6 => ['Session Expired', 'danger'],
        );
        if(!empty($request->input('err'))){
            $data['err'] = $request->input('err');
        }

        return view('login', $data);
    }

    public function loginProcess(Request $request){
        $data = array();
        $input = $request->input();


        $userdata = DB::table('useraccounts')
            ->leftjoin('userdetails', 'userdetails.userid', '=', 'useraccounts.id')
            ->where('username', $input['username'])
            ->where('password', md5($input['password']))
            ->where('status', 'active')
            ->first();

        if(empty($userdata)){
            return redirect('/?err=1');
            die();
        }

        $userkey = [
            $userdata->id, //0
            $userdata->type, //1
            $userdata->username, //2
            $userdata->password, //3
            $userdata->branchid, //4
            $userdata->status, //5
            $userdata->firstname, //6
            $userdata->middlename, //7
            $userdata->lastname, //8
            $userdata->address, //9
            $userdata->contact, //10
            date('ymdHis') //11
        ];

        $userid = encrypt(implode( ',', $userkey,));
        $request->session()->put('sessionkey', $userid);
        session(['sessionkey' => $userid]);

        DB::table('activitylog')
            ->insert([
                'userid' => $userdata->id,
                'title' =>  $userdata->firstname . ' ' . $userdata->lastname . ' Logged In',
                'content' => "User logged in the system.",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        $goto = null;
        if($userdata->type == 'admin') $goto = 'dashboard';
        return redirect()->to($goto);
    }
}
