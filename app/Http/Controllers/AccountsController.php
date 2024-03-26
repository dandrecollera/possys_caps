<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccountsController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('axuadmin');
    }

    public function accounts(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        // Errors
        $data['errorlist'] = [
            1 => 'Password does not match.',
            2 => 'Username already exist',
            3 => 'Image is over 2MB',
        ];
        $data['error'] = 0;
        if(!empty($_GET['e'])){
            $data['error'] = $_GET['e'];
        }

        // Notifications
        $data['notiflist'] = [
            1 => 'Account added.',
            2 => 'Account details modified.',
            3 => 'Account password modified.',
            4 => 'Account image modified.',
            5 => 'Account status modified.',
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
            ['display' => 'Default', 'field' => 'useraccounts.id'],
            ['display' => 'Username', 'field' => 'useraccounts.username'],
            ['display' => 'First Name', 'field' => 'userdetails.firstname'],
            ['display' => 'Last Name', 'field' => 'userdetails.lastname'],
            ['display' => 'Type', 'field' => 'useraccounts.type'],
            ['display' => 'Status', 'field' => 'useraccounts.status'],
            ['display' => 'Branch', 'field' => 'branches.name'],
            ['display' => 'Last Active', 'field' => 'useraccounts.last_active'],
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

        $countdata = DB::table('useraccounts')
            ->leftjoin('userdetails', 'userdetails.userid', '=', 'useraccounts.id')
            ->leftjoin('branches', 'branches.id', '=', 'useraccounts.branchid')
            ->count();

        $dbdata   = DB::table('useraccounts')
            ->leftjoin('userdetails', 'userdetails.userid', '=', 'useraccounts.id')
            ->leftjoin('branches', 'branches.id', '=', 'useraccounts.branchid')
            ->select([
                'useraccounts.id',
                'useraccounts.username',
                'userdetails.firstname',
                'userdetails.middlename',
                'userdetails.lastname',
                'useraccounts.type',
                'useraccounts.status',
                'branches.name',
                'useraccounts.last_active',
                'userdetails.photo'
            ]);

        if(!empty($keyword)){
            $countdata = DB::table('useraccounts')
                ->leftjoin('userdetails', 'userdetails.userid', '=', 'useraccounts.id')
                ->leftjoin('branches', 'branches.id', '=', 'useraccounts.branchid')
                ->where('useraccounts.username', 'like', "%$keyword%")
                ->orWhere('userdetails.firstname', 'like', "%$keyword%")
                ->orWhere('userdetails.lastname', 'like', "%$keyword%")
                ->orWhere('branches.name', 'like', "%$keyword%")
                ->count();

            $dbdata->where('useraccounts.username', 'like', "%$keyword%");
            $dbdata->orWhere('userdetails.firstname', 'like', "%$keyword%");
            $dbdata->orWhere('userdetails.lastname', 'like', "%$keyword%");
            $dbdata->orWhere('branches.name', 'like', "%$keyword%");
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


        return view('accounts', $data);
    }

    public function accounts_add(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');

        return view('accounts_add', $data);
    }

    public function accounts_addprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $checkusername = DB::table('useraccounts')
            ->where('username', '=', $input['username'])
            ->count();

        if($checkusername > 0){
            return redirect('/accounts?e=2');
            die();
        }

        if($input['password'] != $input['password2']){
            return redirect('/accounts?e=1');
            die();
        }

        $maxSize = 2 * 1024 * 1024;
        if($request->hasFile('image')){
            $size = $request->file('image')->getSize();
            if($size > $maxSize){
                return redirect('/accounts?e=3');
                die();
            }
        }

        $userid = DB::table('useraccounts')
            ->insertGetId([
                'username' => $input['username'],
                'password' => md5( $input['password']),
                'type' => $input['type'],
                'branchid' => $input['branch'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        $photo = 'blank.webp';
        if($request->hasFile('image')){
            $destinationPath = 'public/images';
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $userid . '.' . $extension;
            $path = $request->file('image')->storeAs($destinationPath, $filename);
            $photo = $filename;
        }

        DB::table('userdetails')
            ->insert([
                'userid' => $userid,
                'firstname' => $input['firstname'],
                'middlename' => $input['middlename'],
                'lastname' => $input['lastname'],
                'address' => $input['address'],
                'contact' => $input['mobilenumber'],
                'photo' => $photo,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return redirect('/accounts?n=1');
    }

    public function accounts_edit(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $data['db'] = $db = DB::table('useraccounts')
            ->leftjoin('userdetails', 'userdetails.userid', '=', 'useraccounts.id')
            ->where('useraccounts.id', $query['id'])
            ->first();

        return view('accounts_edit', $data);
    }

    public function accounts_editprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();

        $current = DB::table('useraccounts')
            ->where('id', '=', $input['id'])
            ->first();

        if($current->username != $input['username']){
            $checkusername = DB::table('useraccounts')
                ->where('username', '=', $input['username'])
                ->count();

            if($checkusername > 0){
                return redirect('/accounts?e=2');
                die();
            }
        }

        $userid = DB::table('useraccounts')
            ->where('id', $input['id'])
            ->update([
                'username' => $input['username'],
                'type' => $input['type'],
                'branchid' => $input['branch'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('userdetails')
            ->where('id', $input['id'])
            ->update([
                'firstname' => $input['firstname'],
                'middlename' => $input['middlename'],
                'lastname' => $input['lastname'],
                'address' => $input['address'],
                'contact' => $input['mobilenumber'],
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('activitylog')
            ->insert([
                'userid' => $userinfo[0],
                'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Account details.',
                'content' => "Account details has been modified.",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        return redirect('/accounts?n=2');
    }

    public function accounts_passprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        if($input['password'] != $input['password2']){
            return redirect('/accounts?e=1');
            die();
        }

        $userid = DB::table('useraccounts')
            ->where('id', $input['id'])
            ->update([
                'password' => md5( $input['password']),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('activitylog')
            ->insert([
                'userid' => $userinfo[0],
                'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Account password.',
                'content' => "Account password has been modified.",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        return redirect('/accounts?n=3');
    }

    public function accounts_imageprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $input = $request->input();


        $maxSize = 2 * 1024 * 1024;
        if($request->hasFile('image')){
            $size = $request->file('image')->getSize();
            if($size > $maxSize){
                return redirect('/accounts?e=3');
                die();
            }
        }

        $photo = 'blank.webp';
        if($request->hasFile('image')){
            $destinationPath = 'public/images';
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = $input['id'] . '.' . $extension;
            $path = $request->file('image')->storeAs($destinationPath, $filename);
            $photo = $filename;
        }

        DB::table('userdetails')
            ->where('id', $input['id'])
            ->update([
                'photo' => $photo,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        DB::table('activitylog')
            ->insert([
                'userid' => $userinfo[0],
                'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Account Image.',
                'content' => "Account image has been modified.",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

        return redirect('/accounts?n=4');
    }

    public function accounts_lockunlockprocess(Request $request){
        $data = array();
        $data['userinfo'] = $userinfo = $request->get('userinfo');
        $query = $request->query();

        $res = DB::table('useraccounts')
            ->where('id', $query['id'])
            ->first();

        if($res->status == 'active'){
            DB::table('useraccounts')
                ->where('id', $query['id'])
                ->update([
                    'status' => 'inactive',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Account Status.',
                    'content' => $res->username . " Account status has been modified to inactive.",
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
        } else {
            DB::table('useraccounts')
                ->where('id', $query['id'])
                ->update([
                    'status' => 'active',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            DB::table('activitylog')
                ->insert([
                    'userid' => $userinfo[0],
                    'title' =>  $userinfo[6] . ' ' . $userinfo[8] . ' Changed Account Status.',
                    'content' => $res->username . " Account status has been modified to active.",
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
        }


        return redirect('/accounts?n=5');
    }
}
