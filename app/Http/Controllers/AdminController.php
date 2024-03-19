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
        $query = $request->query();

        // Errors
        $data['errorlist'] = [
            1 => 'Email already exist',
            2 => 'Branch already exist',
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
            3 => 'New Branch Added.',
            4 => 'Branch successfully modified.',
            5 => 'Branch status modified.',
        ];
        $data['notif'] = 0;
        if(!empty($_GET['n'])){
            $data['notif'] = $_GET['n'];
        }

        // Line Per Page
        $lpp = 25;
        $lineperpage = [3, 25, 50, 100, 200];
        if(!empty($query['lpp'])){
            if(in_array($query['lpp'], $lineperpage)){
                $lpp = $query['lpp'];
            }
        }
        $data['lpp'] = $qstring['lpp'] = $lpp;

        // Keywords
        $keyword = '';
        if(!empty($query['keyword'])){
            $qstring['keyword'] = $keyword = $query['keyword'];
            $data['keyword'] = $keyword;
        }

        // Sort
        $data['sort'] = 0;
        $data['orderbylist'] = [
            ['display' => 'Default', 'field' => 'branches.id'],
            ['display' => 'Name', 'field' => 'branches.name'],
            ['display' => 'Address', 'field' => 'branches.address'],
            ['display' => 'Status', 'field' => 'branches.status'],
        ];
        if(!empty($query['sort'])){
            $data['sort'] = $qstring['sort'] = $query['sort'];
        }
        // Paging
        $page = 1;
        if(!empty($query['page'])){
            $page = $query['page'];
        }
        $qstring['page'] = $page;

        $countdata = DB::table('branches')
            ->count();

        $dbdata = DB::table('branches');

        if(!empty($keyword)){
            $countdata = DB::table('branches')
                ->where('branches.name', 'like', "%$keyword%")
                ->orWhere('branches.address', 'like', "%$keyword%")
                ->orWhere('branches.description', 'like', "%$keyword%")
                ->count();

            $dbdata->where('branches.name', 'like', "%$keyword%");
            $dbdata->orWhere('branches.address', 'like', "%$keyword%");
            $dbdata->orWhere('branches.description', 'like', "%$keyword%");
        }

        $dbdata->orderby($data['orderbylist'][$data['sort']]['field']);


        $data['totalpages'] = ceil($countdata/$lpp);
        $data['page'] = $page;
        $data['totalitems'] = $countdata;
        $dataoffset = ($page*$lpp) - $lpp;

        $dbdata->offset($dataoffset)->limit($lpp);
        $data['qstring'] = http_build_query($qstring);
        $data['qstring2'] = $qstring;

        if ($page < 2) {
            $data['page_first_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style=""><i class="fa-solid fa-angles-left"></i> </a>';
            $data['page_prev_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style=""><i class="fa-solid fa-angle-left"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = 1;
            $data['page_first_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style=""><i class="fa-solid fa-angles-left"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] - 1;
            $data['page_prev_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style=""><i class="fa-solid fa-angle-left"></i> </a>';
        }
        if ($page >= $data['totalpages']) {
            $data['page_last_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style=""><i class="fa-solid fa-angles-right"></i> </a>';
            $data['page_next_url'] = '<a class="btn btn-dark disabled" href="#" role="button" aria-disabled="true" style=""><i class="fa-solid fa-angle-right"></i> </a>';
        } else {
            $urlvar = $qstring; $urlvar['page'] = $data['totalpages'];
            $data['page_last_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style=""><i class="fa-solid fa-angles-right"></i> </a>';
            $urlvar = $qstring; $urlvar['page'] = $urlvar['page'] + 1;
            $data['page_next_url'] = '<a class="btn btn-dark" href="?'.http_build_query($urlvar).'" role="button" style=""><i class="fa-solid fa-angle-right"></i> </a>';
        }

        $data['dbresult'] = $dbresult = $dbdata->get()->toArray();


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

    public function settings_addbranch(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('settings_addbranch', $data);
    }

    public function settings_addbranchprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        $branchexist = DB::table('branches')
            ->where('name', $input['name'])
            ->count();

        if($branchexist > 0){
            return redirect('/settings?e=2');
        }

        DB::table('branches')
            ->insert([
                'name' => $input['name'],
                'address' => $input['address'],
                'description' => $input['description'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        DB::table('activitylog')
            ->insert([
                'userid' => $userinfo[0],
                'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Added a new Branch.',
                'content' => $input['name'] . " Branch has been added to the system.",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        return redirect('/settings?n=3');
    }

    public function settings_editbranch(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $data['db'] = $db = DB::table('branches')
            ->where('id', $query['id'])
            ->first();

        return view('settings_editbranch', $data);
    }

    public function settings_editbranchprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $res = DB::table('branches')
            ->where('id', $input['id'])
            ->update([
                'name' => $input['name'],
                'address' => $input['address'],
                'description' => $input['description'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('activitylog')
            ->insert([
                'userid' => $userinfo[0],
                'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Edited a Branch.',
                'content' => $res->name . " Branch has been modified to " . $input['name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        return redirect('/settings?n=4');
    }

    public function settings_lockunlockprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $res = DB::table('branches')
            ->where('id', $query['id'])
            ->first();

        if($res->status == 'active'){
            DB::table('branches')
                ->where('id', $query['id'])
                ->update([
                    'status' => 'inactive',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Branch Status.',
                    'content' => $res->name . " Branch status  has been modified to inactive.",
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
        } else {
            DB::table('branches')
                ->where('id', $query['id'])
                ->update([
                    'status' => 'active',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Branch Status.',
                    'content' => $res->name . " Branch status has been modified to active.",
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
        }

        return redirect('/settings?n=5');
    }
}
