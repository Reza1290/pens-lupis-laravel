<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailDosen;
use App\Models\DetailMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDOException;
use Tymon\JWTAuth\Facades\JWTAuth;

use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{   
    
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Register A User
     */
    public function register(Request $req){
            $req->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            User::create([
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password)
            ]);
            
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully'
            ]);
            
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        $token = JWTAuth::attempt($credentials);

        if (empty($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        
        $detail = 'No data';

        if (in_array($user->roles, ['dosen', 'mahasiswa'])) {
            
            if ($user->roles === 'dosen' && DetailDosen::where('users_id', $user->id)->count() === 0) {
                DetailDosen::create([
                    'users_id' => $user->id
                ]);
                
            } elseif ($user->roles === 'mahasiswa' && DetailMahasiswa::where('users_id', $user->id)->count() === 0) {
                DetailMahasiswa::create([
                    'users_id' => $user->id
                ]);
            }

            if($user->roles === 'dosen'){
                $detail = DetailDosen::where('users_id', $user->id)->get();
            }else if($user->roles === 'mahasiswa'){
                $detail = DetailMahasiswa::where('users_id', $user->id)->get();
            }
        }

        

        return response()->json([
            'data' => $user, 'detail' => $detail
        ]);
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ])->withCookie('token',$token)->setMaxAge(10000);
    }
}
