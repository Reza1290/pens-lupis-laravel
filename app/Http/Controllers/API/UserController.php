<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailDosen;
use App\Models\DetailMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.roles:admin');
    }

    public function index(){
        $res = User::all();

        return response()->json([
            'status' => true,
            'data' => $res
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'roles' => 'required',
        ]);

        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);
        
        if (in_array($req->roles, ['dosen', 'mahasiswa'])) {
            
            if ($req->roles === 'dosen') {
                DetailDosen::create([
                    'users_id' => $req->id,
                    'nip' => $req->nip
                ]);
                
            } elseif ($req->roles === 'mahasiswa') {
                DetailMahasiswa::create([
                    'users_id' => $req->id,
                    'nrp' => $req->nrp
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $res = User::find($id);

        if(empty($res)){
            return response()->json([
                'status' => false
            ],404); 
        }
        return response()->json([
            'status' => true,
            'data' => $res
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $res = User::find($id);

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $res
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $user = User::find($id);

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|confirmed',
            'roles' => 'required',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

 
        $detailDosen = DetailDosen::where('users_id', $user->id)->first();

        $detailMahasiswa = DetailMahasiswa::where('users_id', $user->id)->first();

        if ($detailDosen) {
            $detailDosen->delete();
        }

        if ($detailMahasiswa) {
            $detailMahasiswa->delete();
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User and related records deleted successfully'
        ], 200);

    }
}
