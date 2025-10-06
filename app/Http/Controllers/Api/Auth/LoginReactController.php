<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponseTrait;

class LoginReactController extends Controller
{
    use ApiResponseTrait;
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $companyUser = User::find($user->created_by);
        $status = $companyUser ? $companyUser->delete_status : 1;
        if ($user->delete_status == 0 || $status == 0) {
            return $this->errorResponse('Your Account is deleted by admin, please contact your Administrator.', 403);
        }
        if ($user->is_active == 0) {
            return $this->errorResponse('Your Account is deactive by admin, please contact your Administrator.', 403);
        }
        if ($user->is_disable == 0 && $user->type != 'company' && $user->type != 'super admin') {
            return $this->errorResponse('Your Account is disabled, please contact your Administrator.', 403);
        }
        if (($user->is_enable_login == 0 || ($companyUser && $companyUser->is_enable_login == 0)) && $user->type != 'super admin') {
            return $this->errorResponse('Your Account is disabled from company.', 403);
        }

        $token = $user->createToken('API Token')->plainTextToken;
        return $this->successResponse([
            'token' => $token,
            'user' => new UserResource($user),
        ], 'Login successful');
    }
}
