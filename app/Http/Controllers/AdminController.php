<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function loadAllManagers(){
        $all_Managers = Manager::all();
        return view('admin.manage-manager', compact('all_Managers'));
    }

    public function RegisterManager(Request $request){
    }
    

}
