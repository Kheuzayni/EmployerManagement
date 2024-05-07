<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Manager;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function loadAllManagers()
    {
        $all_managers = Manager::join('users', 'users.id', '=', 'managers.user_id')
            ->get(['users.email', 'managers.first_name', 'managers.last_name', 'managers.phone_number', 'managers.description', 'managers.user_id']);

        return view('admin.manage-manager', compact('all_managers'));
    }

    public function RegisterUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'description' => 'required|string',
            'role' => 'required|string|in:manager,agent', // Ajout de la validation du rôle
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
        } else {
            try {
                // Création de l'utilisateur
                $addAsUser = new User;
                $addAsUser->name = $request->fname . ' ' . $request->lname;
                $addAsUser->email = $request->email;
                $addAsUser->password = Hash::make('password'); // Mot de passe par défaut
                $addAsUser->role = ($request->role == 'manager') ? 1 : 0; // Détermination du rôle en fonction du choix
                $addAsUser->save();
    
                // Création du manager ou de l'agent associé en fonction du rôle sélectionné
                if ($request->role == 'manager') {
                    $manager = new Manager;
                    $manager->user_id = $addAsUser->id;
                    $manager->first_name = $request->fname;
                    $manager->last_name = $request->lname;
                    $manager->phone_number = $request->phone;
                    $manager->description = $request->description;
                    $manager->save();
                } else {
                    $agent = new Agent;
                    $agent->user_id = $addAsUser->id;
                    $agent->first_name = $request->fname;
                    $agent->last_name = $request->lname;
                    $agent->phone_number = $request->phone;
                    $agent->description = $request->description;
                    $agent->save();
                }
    
                return response()->json(['success' => true, 'msg' => 'Utilisateur ajouté avec succès']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }
    

    public function deleteManager($user_id)
    {
        try {
            User::where('id', $user_id)->delete();
            return response()->json(['success' => true, 'msg' => 'Manager supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function editManager(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|numeric',
            'description' => 'required|string',
            'email' => 'required|email',
            'manager_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        } else {
            try {
                Manager::where('user_id', $request->manager_id)->update([
                    'first_name' => $request->fname,
                    'last_name' => $request->lname,
                    'phone_number' => $request->phone,
                    'description' => $request->description,
                ]);

                User::where('id', $request->manager_id)->update([
                    'email' => $request->email
                ]);

                return response()->json(['success' => true, 'msg' => 'Manager mis à jour avec succès']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }
    public function deleteAgent($user_id)
    {
        try {
            User::where('id', $user_id)->delete();
            return response()->json(['success' => true, 'msg' => 'Agent supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function editAgent(Request $request){
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|numeric',
            'description' => 'required|string',
            'email' => 'required|email',
            'agent_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        } else {
            try {
                Agent::where('user_id', $request->agent_id)->update([
                    'first_name' => $request->fname,
                    'last_name' => $request->lname,
                    'phone_number' => $request->phone,
                    'description' => $request->description,
                ]);

                User::where('id', $request->agent_id)->update([
                    'email' => $request->email
                ]);

                return response()->json(['success' => true, 'msg' => 'Agent mis à jour avec succès']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
    }
}
