<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;

class UserController extends BaseController
{


    public function index()
    {
        return User::all();
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'email',
            'user_name' => 'required|unique:users',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->handleError($validator->errors());
        }
        switch ($input['role']) {
            case 'admin':
                return $this->saveAdmin($request);
            case 'seller':
                return $this->saveUser($request);

            case 'super_admin':
                return $this->throwUnAuthorizedMessage();
            default:
                return $this->handleError('Wrong Data.', ['error' => 'Invalid role is provided'], 400);
        }
    }

    public function saveUser(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt('werkama123');
        $user = User::create($input);
        return $this->handleResponse($user, 'User registered!');
    }

    public function saveAdmin(Request $request)
    {
        if (Auth::user()->role == 'super_admin') {
            return $this->saveUser($request);
        }
        return $this->throwUnAuthorizedMessage();
    }
}
