<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiteController extends Controller
{

    public function mainPage(Request $request):View
    {
        $user   = $request->user();
        $short  = isset($request->short);

        $balance    = DB::scalar("SELECT `balance` FROM `balances` WHERE `user_id` = ? ;", [$user->id] );
        $operations = DB::select("SELECT * FROM `operations` WHERE `user_id` = ? ORDER BY `created_at` DESC LIMIT 5",
                                                                                                        [$user->id]);

        return view($short ? 'site.mainPageTable' : 'site.mainPage',[
            'balance'       => $balance,
            'operations'    => $operations,
        ]);
    }

    public function history(Request $request):View
    {
        $sort   = $request->sort    ?? '';
        $search = $request->search  ?? '';

        $db = DB::table('operations');

        if($search){
            $db = $db->where('message', 'like', "%$search%");
        }

        if($sort == 'asc'){
            $db = $db->orderBy('created_at', 'asc');
        }elseif($sort == 'desc'){
            $db = $db->orderBy('created_at', 'desc');
        }

        $operations = $db->get()->all();
        return view('site.history',[
            'operations' => $operations,
            'sort'       => $sort,
            'search'     => $search,
        ]);
    }
}
