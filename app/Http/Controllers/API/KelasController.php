<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.roles:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();

        if(!$kelas->isNotEmpty()){
            return response()->json([
                'status' => false,
            ],404);  
        }

        return response()->json([
            'status' => true,
            'data' => $kelas
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'wali_id' => 'required',
        ]);

        $kelas = new Kelas;
        $kelas->name = $request->name;
        $kelas->wali_id = $request->wali_id;
        $kelas->save();

        return response()->json([
            'status' => true,
            'message' => 'kelas created successfully',
            'data' => $kelas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = Kelas::find($id);

        if (empty($kelas)) {
            return response()->json([
                'status' => false,
                'message' => 'kelas not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $kelas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'wali_id' => 'required',
        ]);

        $kelas = Kelas::find($id);

        if (empty($kelas)) {
            return response()->json([
                'status' => false,
                'message' => 'kelas$kelas not found'
            ], 404);
        }

        $kelas->name = $request->name;
        $kelas->wali_id = $request->wali_id;
        $kelas->save();

        return response()->json([
            'status' => true,
            'message' => 'kelas created successfully',
            'data' => $kelas
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::find($id);

        if (empty($kelas)) {
            return response()->json([
                'status' => false,
                'message' => 'Kelas not found'
            ], 404);
        }

        $kelas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Kelas deleted successfully'
        ]);
    }
}
