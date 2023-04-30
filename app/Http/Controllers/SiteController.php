<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiteController extends Controller
{

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
