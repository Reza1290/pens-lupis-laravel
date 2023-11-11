<?php

namespace App\Http\Controllers\API;

use App\Models\credits;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.roles:admin')->except('index','indexDosen','indexWali');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credits = Credits::with('kelas','dosen','matkul')->get();

        if(!$credits->isNotEmpty()){
            return response()->json([
                'status' => false,
            ],404);  
        }

        return response()->json([
            'status' => true,
            'data' => $credits
        ],200);
    }

    public function indexDosen(Request $request){
        $credits = Credits::with('kelas','dosen','matkul')->where('dosen_id',$request->dosen_id)->get();
        
        if ($credits->count() === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Credits not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $credits
        ]);
    }

    public function indexWali(Request $request){
        $credits = Credits::with(['kelas.wali', 'dosen', 'matkul'])
    ->whereHas('kelas.wali', function ($query) use ($request) {
        $query->where('id', $request->dosen_id);
    })
    ->get();

        
        if ($credits->count() === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Credits not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $credits
        ]);
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
            'kelas_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required'
        ]);

        $credits = new Credits;
        $credits->kelas_id = $request->kelas_id;
        $credits->matkul_id = $request->matkul_id;
        $credits->dosen_id = $request->dosen_id;
        $credits->save();

        return response()->json([
            'status' => true,
            'message' => 'Credits created successfully',
            'data' => $credits
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $id)
    {
        $credits = Credits::with('kelas','dosen','matkul')->where('id',$id)->get();
        
        if (empty($credits)) {
            return response()->json([
                'status' => false,
                'message' => 'Credits not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $credits
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
            'kelas_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required'
        ]);

        $credits = Credits::find($id);

        if (empty($credits)) {
            return response()->json([
                'status' => false,
                'message' => 'Credits not found'
            ], 404);
        }

        $credits->kelas_id = $request->kelas_id;
        $credits->matkul_id = $request->matkul_id;
        $credits->dosen_id = $request->dosen_id;
        $credits->save();

        return response()->json([
            'status' => true,
            'message' => 'Credits created successfully',
            'data' => $credits
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $credits = Credits::find($id);

        if (empty($credits)) {
            return response()->json([
                'status' => false,
                'message' => 'Credits not found'
            ], 404);
        }

        $credits->delete();

        return response()->json([
            'status' => true,
            'message' => 'Credits deleted successfully'
        ]);
    }
}
