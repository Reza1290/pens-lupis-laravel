<?php

namespace App\Http\Controllers\API;

use App\Models\JawabanTugas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JawabanTugasController extends Controller
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
        $jawaban = JawabanTugas::all();

        if(!$jawaban->isNotEmpty()){
            return response()->json([
                'status' => false,
            ],404);  
        }

        return response()->json([
            'status' => true,
            'data' => $jawaban
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
            'comment' => 'required',
            'file_path' => 'required|mimes:doc,pdf,docx,zip',
            'tugas_id' => 'required',
            'mahasiswa_id' => 'required'
        ]);

        $jawaban = new JawabanTugas;
        $jawaban->comment = $request->comment;
        $jawaban->file_path = $request->file_path; // nanti aja
        $jawaban->tugas_id = $request->tugas_id;
        $jawaban->mahasiswa_id = $request->mahasiswa_id;
        $jawaban->save();

        return response()->json([
            'status' => true,
            'message' => 'jawaban created successfully',
            'data' => $jawaban
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jawaban = JawabanTugas::find($id);

        if (empty($jawaban)) {
            return response()->json([
                'status' => false,
                'message' => 'jawaban not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $jawaban
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
            'comment' => 'required',
            'file_path' => 'required|mimes:doc,pdf,docx,zip',
            'tugas_id' => 'required',
            'mahasiswa_id' => 'required'
        ]);

        $jawaban = JawabanTugas::find($id);

        if (empty($jawaban)) {
            return response()->json([
                'status' => false,
                'message' => 'jawaban not found'
            ], 404);
        }

        $jawaban->comment = $request->comment;
        $jawaban->file_path = $request->file_path; // nanti aja
        $jawaban->tugas_id = $request->tugas_id;
        $jawaban->mahasiswa_id = $request->mahasiswa_id;
        $jawaban->save();

        return response()->json([
            'status' => true,
            'message' => 'jawaban created successfully',
            'data' => $jawaban
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jawaban = JawabanTugas::find($id);

        if (empty($jawaban)) {
            return response()->json([
                'status' => false,
                'message' => 'Jawaban not found'
            ], 404);
        }

        $jawaban->delete();

        return response()->json([
            'status' => true,
            'message' => 'Jawaban deleted successfully'
        ]);
    }
}
