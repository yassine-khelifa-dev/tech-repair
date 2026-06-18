<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Dedoc\Scramble\Attributes\ExcludeRouteFromDocs;

class RegisteredUserController extends Controller
{


    #[ExcludeRouteFromDocs]
    public function store(RegisterRequest $request)
    {

        $user = $request->all();

        $user = User::create($user);

        return response([
            'user' => $user,
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);
    }
}
