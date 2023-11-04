<?php

namespace App\Http\Controllers\API;

use App\Models\MataKuliah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{

    public function __construct() {
        $this->middleware('auth.roles:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mataKuliahs = MataKuliah::all();
        
        if(!$mataKuliahs->isNotEmpty()){
            return response()->json([
                'status' => false,
            ],404);  
        }

        return response()->json([
            'status' => true,
            'data' => $mataKuliahs
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
            'matkul_name' => 'required',
            'desc' => 'required',
        ]);

        $mataKuliah = new MataKuliah;
        $mataKuliah->matkul_name = $request->matkul_name;
        $mataKuliah->desc = $request->desc;
        $mataKuliah->save();

        return response()->json([
            'status' => true,
            'message' => 'MataKuliah created successfully',
            'data' => $mataKuliah
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mataKuliah = MataKuliah::find($id);

        if (empty($mataKuliah)) {
            return response()->json([
                'status' => false,
                'message' => 'MataKuliah not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $mataKuliah
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
            'matkul_name' => 'required',
            'desc' => 'required',
        ]);

        $mataKuliah = MataKuliah::find($id);

        if (empty($mataKuliah)) {
            return response()->json([
                'status' => false,
                'message' => 'MataKuliah not found'
            ], 404);
        }

        $mataKuliah->matkul_name = $request->matkul_name;
        $mataKuliah->desc = $request->desc;
        $mataKuliah->save();

        return response()->json([
            'status' => true,
            'message' => 'MataKuliah updated successfully',
            'data' => $mataKuliah
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mataKuliah = MataKuliah::find($id);

        if (empty($mataKuliah)) {
            return response()->json([
                'status' => false,
                'message' => 'MataKuliah not found'
            ], 404);
        }

        $mataKuliah->delete();

        return response()->json([
            'status' => true,
            'message' => 'MataKuliah deleted successfully'
        ]);
    }
}
