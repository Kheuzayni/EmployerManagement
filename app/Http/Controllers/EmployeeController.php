<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Manager;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function loadEmployeeHome()
    {
        $all_agents = Agent::join('users', 'users.id', '=', 'agents.user_id')
            ->get(['users.email', 'agents.first_name', 'agents.last_name', 'agents.phone_number', 'agents.description', 'agents.user_id']);

        return view('manager.manage-employee', compact('all_agents'));
    }

public function RegisterAgent(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fname' => 'required|string',
        'lname' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string',
        'description' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'msg' => $validator->errors()->toArray()]);
    } else {
        try {
            // Création de l'utilisateur
            $user = new User;
            $user->name = $request->fname . ' ' . $request->lname;
            $user->email = $request->email;
            $user->password = Hash::make('password'); // Mot de passe par défaut
            $user->role = 0; // Le rôle sera toujours 'agent' lors de la création par le manager
            $user->save();

            // Création de l'agent associé à l'utilisateur
            $agent = new Agent;
            $agent->user_id = $user->id;
            $agent->first_name = $request->fname;
            $agent->last_name = $request->lname;
            $agent->phone_number = $request->phone;
            $agent->description = $request->description;
            $agent->save();

            return response()->json(['success' => true, 'msg' => 'Agent ajouté avec succès']);
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