<?php

namespace App\Http\Controllers\API;

use App\Models\DetailCredit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailCreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DetailCredit::all();
    }


    public function indexMahasiswa(Request $request){
        
        $sks = DetailCredit::with('sks.matkul','sks.dosen','sks.kelas')->where('mahasiswa_id',$request->id)->get();

        if($sks->count() !== 0){
            return response()->json([
                "status" => true,
                "data" => $sks
            ]);
        }else{
            return response()->json([
                "status" => false,
                "data" => "null"
            ]);
        }


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
            'credits_id' => 'required',
            'mahasiswa_id' => 'required',
        ]);

        if (DetailCredit::where([
            'mahasiswa_id' => $request->mahasiswa_id,
            'credits_id' => $request->credits_id
        ])->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Sks Already Requested!'
            ]);
        }

        $credits = new DetailCredit;
        $credits->credits_id = $request->credits_id;
        $credits->mahasiswa_id = $request->mahasiswa_id;
        $credits->save();

        return response()->json([
            'status' => true,
            'message' => 'Sks created successfully',
            'data' => $credits
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {   
        // $request->validate([
        //     'mahasiswa_id' => 'required'
        // ]);

        // $sks = DetailCredit::with('sks.matkul','sks.dosen')->where('mahasiswa_id',$request->mahasiswa_id)->get();

        // if(!empty($sks)){
        //     return response()->json([
        //         'status' => true,
        //         'data' => $sks
        //     ])
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailCredit $DetailCredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailCredit $DetailCredit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailCredit $DetailCredit)
    {
        //
    }
}
