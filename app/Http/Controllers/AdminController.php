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
        $all_managers = Manager::join('users','users.id','=','managers.user_id')
        ->get(['users.email','managers.first_name','managers.middle_name','managers.last_name','managers.phone_number','managers.user_id']);  //here specify columns to select from both two tables
        //this will join the two 
        return view('admin.manage-manager',compact('all_managers'));
    }

    public function RegisterManager(Request $request){
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
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
                $manager->save();

                return response()->json(['success' => true, 'msg' => 'Manager ajouté avec succès']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }

      // delete functionality
    // in this function i just deleted the managers data from users table only and it will delete data from managers table
    // this is because users table is a parent table and managers table is a child table also i added this
    public function deleteManager($user_id){ //for good readability use user_id
        try {
            User::where('id',$user_id)->delete();
            // if success print success msg
            return response()->json(['success' => true, 'msg' => 'Manager Deleted Successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function editManager(Request $request){
        // validate form
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'manager_id' => 'required|numeric',
            // now these data come from this form
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{
            // perform edit functionality here
            try {
                Manager::where('user_id',$request->manager_id)->update([
                    'first_name' => $request->fname,
                    'middle_name' => $request->mname,
                    'last_name' => $request->lname,
                    'phone_number' => $request->phone,
                ]);

                // i did not update the users table as the name field from users table have no functionality to us for now
                // so just leave it but for users email it is important as we use it as username for our users
                // so update just the email as follows
                User::where('id',$request->manager_id)->update([
                    'email' => $request->email
                ]);

                // i think we are good now try to edit the manager
                return response()->json(['success' => true, 'msg' => 'manager updated successfully']);

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);

            }
            
        }

    }
}
