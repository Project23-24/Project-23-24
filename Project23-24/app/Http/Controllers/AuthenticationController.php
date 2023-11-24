<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessTokenResult;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request) 
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:10|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($data){
            
            if(User::firstWhere('phone', $data['phone']) ){
                return response()->json([
                    'message' => 'User already exists'
                ]);
            }else{
                $newuser = User::create([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'status' => 'Active',
                ]);
                
                $token = $newuser->createToken('API_Token');

                return response()->json([
                    'message' => 'Account has been added',
                    'token' => $token->plainTextToken
                ]);
            }  
        }

        return response()->json([
            'message' => 'Invalid data'
        ]);
    }

    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone' => 'required|string|max:10|exists:users',
            'password' => 'required|string|min:8',
            'user_type' => 'required|in:user,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()
            ], 400);
        }

        $data = $validator->validated();

        $credentials = [
            'phone' => $data['phone'],
            'password' => $data['password'],
            'user_type' => $data['user_type']
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::guard('sanctum')->user();
            if ($user->user_type != $data['user_type']) {
                return response()->json([
                    'message'=>'User type doesn\'t match'
                ], 400);
            }

            $token = $user->createToken('API_Token');
            return response()->json([
                'message' => 'Logged in',
                'token' => $token->plainTextToken,
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'There is error in your information'
        ], 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'You are logged out'
        ]);
    }

    // public function register_admin(Request $request) 
    // {
    //     $admin_data = $request->validate([
    //         'admin_name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:10|unique:users',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     if(User::firstWhere('phone', $request->phone_number) || User::firstWhere('admin_name', $request->username)){
    //         return response()->json([
    //             'message' => 'Admin already exists'
    //         ]);
    //     }else{
    //         $newadmin = User::create([
    //             'admin_name' => $admin_data['admin_name'],
    //             'phone' => $admin_data['phone'],
    //             'password' => Hash::make($admin_data['password']),
    //             'permision' => '1',
    //             'status' => 'Active'
    //         ]);
                
    //         $admin_token = $newuser->createToken('RegisterdAdminToken', ['login'])->plainTextToken;
    //         $newadmin->token = $admin_token;

    //         // $newUser = new User();
    //         // $newUser->username = $data['username'];
    //         // $newUser->phone_number = $data['phone_number'];
    //         // $newUser->password = Hash::make($data['password']);
    //         // $newUser->status = 'Active';
    //         // $newUser->save();
    
    //         return response()->json([
    //             'message' => 'Account has been added, confirmation code has been sent'
    //         ]);
    //     } 
    // }

    // public function register_confirmation()
    // {

    // }

    // public function login_admin(Request $request)
    // {
    //     $credentials = [
    //         'phone' => $request->phone,
    //         'password' => $request->password,
    //         'status' => 'Active'
    //     ];
    
    //     if(Auth::attempt($credentials)){
    //         $user = User::firstWhere('phone', $credentials['phone']);
    //         $token = $user->createToken('UserLoggedInToken', [
    //             'showall', 
    //             'categories/{category::name}',
    //             'show/{med:Commercial_Name}',
    //             '/edit/{med:Commercial_Name}',
    //             '/delete/{id}',
    //             '/edit/{med:Commercial_Name}'
    //         ]);
    
    //         return response()->json([
    //             'message' => 'Logged in',
    //             'token' => $token->plainTextToken
    //         ]);
    //     }else{
    //         return response()->json([
    //             'message' => 'There is error in your information'
    //         ]);
    //     }
    // }
}
