<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'messages' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

      //      Mail::to($request['email'])->send(new Registered($user));

            return response()->json([
                'status' => true,
                'messages' => 'User Created Successfully',
                'token' => $user->createToken("TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'messages'
                'errors' => $th->getMessage()
            ], 401);
        }
    }



    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'messages' => 'les entrees sont invalides ',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $credentials = $request->only(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'messages' => 'Pas autoris??.',
                    'errors'=>'Pas autoris?? cl??.',
                ], 400);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'messages' => 'Vous etes connect??e',
                'user'=>$user,
                'token' => $user->createToken("TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errors'=>'Pas autoris??.',
                'status' => false,
                'messages' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *deconnection user
     */
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }
}
