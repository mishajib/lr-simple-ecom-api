<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthenticationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => ['bail', 'required', 'string', 'max:255'],
            'email'    => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'is_admin' => ['bail', 'required', 'boolean'],
            'password' => ['bail', 'required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return error_response(
                $validator->errors()->first(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('authToken')->accessToken;

        return success_response(
            'User registered successfully.',
            Response::HTTP_CREATED,
            $data
        );
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'bail|email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return error_response(
                $validator->errors()->first(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (!auth()->attempt($validator->validated())) {
            return error_response(
                'Invalid credentials!',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = auth()->user()->createToken('authToken')->accessToken;


        return success_response(
            'User logged in successfully!',
            Response::HTTP_OK,
            [
                'user'  => new UserResource(auth()->user()),
                'token' => $token
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return success_response(
            'User logged out successfully!',
            Response::HTTP_OK
        );
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        return success_response(
            'User data retrieved successfully!',
            Response::HTTP_OK,
            [
                'user' => new UserResource(auth()->user())
            ]
        );
    }
}
