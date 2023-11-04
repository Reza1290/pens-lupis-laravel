<?php

namespace App\Http\Controllers\API;

use App\Models\Tugas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TugasController extends Controller
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
        $tugas = Tugas::all();

        if(!$tugas->isNotEmpty()){
            return response()->json([
                'status' => false,
            ],404);  
        }

        return response()->json([
            'status' => true,
            'data' => $tugas
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
            'tugas_name' => 'required',
            'tugas_desc' => 'required',
            'credit_id' => 'required',
        ]);

        $tugas = new Tugas;
        $tugas->tugas_name = $request->tugas_name;
        $tugas->tugas_desc = $request->tugas_desc;
        $tugas->credit_id = $request->credit_id;
        $tugas->save();

        return response()->json([
            'status' => true,
            'message' => 'tugas created successfully',
            'data' => $tugas
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tugas = Tugas::find($id);

        if (empty($tugas)) {
            return response()->json([
                'status' => false,
                'message' => 'tugas not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $tugas
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
            'tugas_name' => 'required',
            'tugas_desc' => 'required',
            'credit_id' => 'required',
        ]);

        $tugas = Tugas::find($id);

        if (empty($tugas)) {
            return response()->json([
                'status' => false,
                'message' => 'tugas not found'
            ], 404);
        }

        $tugas->tugas_name = $request->tugas_name;
        $tugas->tugas_desc = $request->tugas_desc;
        $tugas->credit_id = $request->credit_id;
        $tugas->save();

        return response()->json([
            'status' => true,
            'message' => 'tugas created successfully',
            'data' => $tugas
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tugas = Tugas::find($id);

        if (empty($tugas)) {
            return response()->json([
                'status' => false,
                'message' => 'Tugas not found'
            ], 404);
        }

        $tugas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Tugas deleted successfully'
        ]);
    }
}
