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
}
