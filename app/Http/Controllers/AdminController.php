<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public function dashboard(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('dashboard', $data);
    }

    public function settings(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        // Errors
        $data['errorlist'] = [
            1 => 'Email already exist',
            2 => 'Password must be 8 character long',
            3 => 'Password must match',
        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        // Notifications
        $data['notiflist'] = [
            1 => 'Settings successfully modified.',
            2 => 'System Settings returned to default.',
            3 => 'Password modified.',
            4 => 'Status modified.',
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }

        return view('settings', $data);
    }

    public function savesettings(Request $request){
        $data = array();
        $input = $request->input();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        if(!empty($input['title'])){
            DB::table('systemsettings')
                ->where('type', 'title')
                ->update([
                    'input' => $input['title'],
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed system settings.',
                    'content' => "Title has been modified to " . $input['title'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
        }

        if($request->hasFile('image')){
            DB::table('systemsettings')
                ->where('type', 'logo')
                ->update([
                    'input' => $this->fileProcess($request->file('image')),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed system settings.',
                    'content' => "Logo has been modified",
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
        }

        return redirect('/settings?n=1');
    }

    public function systemdefault(Request $request){
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        DB::table('systemsettings')
                ->where('type', 'title')
                ->update([
                    'input' => "Sales and Inventory Management System",
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

        DB::table('systemsettings')
                ->where('type', 'logo')
                ->update([
                    'input' => "img/logo.png",
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed system settings.',
                    'content' => "System Settings returned to default.",
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

        return redirect('/settings?n=2');
    }

    public function fileProcess($input){
        $now = Carbon::now()->format('Ymd_His');
        $destinationPath = "public/systemlogo";

        $image = $input;
        $extenstion = $image->getClientOriginalExtension();
        $filename = $now . '.' . $extenstion;
        $path = $image->storeAs($destinationPath, $filename);

        $publicpath = "storage/systemlogo/" . $filename;
        return $publicpath;
    }
}
