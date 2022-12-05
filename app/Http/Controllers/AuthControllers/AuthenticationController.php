<?php

namespace App\Http\Controllers\AuthControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthenticationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => ['required'],
            'password' => ['required']
        ];
        $credentials = $request->validate($rules);

        $authenticated = Auth::attempt($credentials);
        if ($authenticated) {
            $user = auth()->user();
            if ($user->email_verified_at == null)
                return response()->json('invalid credentials', Response::HTTP_BAD_REQUEST);

            $token = User::getNewToken();
            $res = [
                'name' => $user->name,
                'email' => $user->email,
                'access_token' => $token,
                'is_admin' => !!($user->name == 'admin'),
                'user_roles' => $user->roles()->pluck('id', 'name'),
                'user_permissions' => $user->getAllPermissions()->pluck('id', 'name'),
            ];
            return response()->json($res);

        }
        return response()->json('invalid credentials', Response::HTTP_BAD_REQUEST);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        User::logout();
        return response()->json('logged out');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required']
        ];

        $userData = $request->validate($rules);

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($userData['password']),
        ]);

//        $roles = ['user'];
//        $user->syncRoles($roles);

        return response()->json('Account created successfully');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRoles(Request $request)
    {
        $roles = Role::query();
        if (isset($request->list) && $request->list) {
            $roles = $roles->get(['id', 'name']);
        } else {
            $roles = $roles->get();
        }

        return response()->json($roles);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        $users = User::all();
        return response()->json($users);

    }
}
