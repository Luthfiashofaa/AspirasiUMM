<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $user = User::latest()->paginate(5);
        return new UserResource(true, 'List Data User', $user);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'     => 'required',
            'nim'   => 'required|unique:users',
            'password'   => 'required|min:6',
            'role'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('posts', $image->hashName());

        // Generate remember token
        $remember_token = Str::random(60);

        // Create the user
        $user = User::create([
            'image'     => $image->hashName(),
            'name'     => $request->name,
            'nim'   => $request->nim,
            'password'   => Hash::make($request->password),
            'role'   => $request->role,
            'remember_token' => $remember_token
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User successfully registered!',
            'data' => $user,
            'token' => $remember_token
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('nim', $request->nim)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Update remember token
        $remember_token = Str::random(60);
        $user->remember_token = $remember_token;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $user,
            'token' => $remember_token
        ]);
    }

    public function show($nim) {
        $user = User::where('nim', $nim)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found!',
            ], 404);
        }

        return new UserResource(true, 'Detail Data User!', $user);
    }
}