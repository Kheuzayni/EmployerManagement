<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function loadAllManagers(){
        $all_managers = Manager::all();
        return view('admin.manage-manager',compact('all_managers'));
    }

    public function RegisterManager(Request $request){
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            try {
                // Création de l'utilisateur
                $addAsUser = new User;
                $addAsUser->name = $request->fname . ' ' . $request->lname;
                $addAsUser->email = $request->email;
                $addAsUser->password = Hash::make('manager'); // Mot de passe par défaut
                $addAsUser->role = 1;
                $addAsUser->save();

                // Création du manager associé
                $manager = new Manager;
                $manager->user_id = $addAsUser->id;
                $manager->first_name = $request->fname;
                $manager->middle_name = $request->mname;
                $manager->last_name = $request->lname;
                $manager->phone_number = $request->phone;
                $manager->description = $request->description;
                $manager->save();

                return response()->json(['success' => true, 'msg' => 'Manager ajouté avec succès']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }
}
