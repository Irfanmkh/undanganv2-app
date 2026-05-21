<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Rsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    //

    public function index()
    {
        $data_rsvp = auth()->user()->invitations->pluck('id');

        $data_rsvp = Rsvp::whereIn("invitation_id", $data_rsvp)->latest()->get();

        return response()->json([
            'message' => 'Rsvp retrieved successfully',
            'data' => $data_rsvp
        ], 200);
    }
    public function store(Request $request)
    {
        $tamu = $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'nama_tamu' => 'required',
            'status_kehadiran' => 'required',
            'jumlah_kehadiran' => 'required',
            'pesan' => 'nullable|string'
        ]);

        $dataTamu = Rsvp::create($tamu);
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $dataTamu
        ], 201);
    }


    public function show($id)
    {
        $rsvp =  auth()->user()->invitations()->pluck('id');

        $rsvp = Rsvp::whereIn('invitation_id', $rsvp)->find($id);
        if(!$rsvp){
            return response()->json([
                "message"=>"data tidak ada",
                "data"=> null
            ],404);
        }

        return response()->json([
            'message' => 'Data Rsvp berhasil diambil',
            'data' => $rsvp
        ], 200);
    }

    public function update(Request $request, $id)
    {

    $rsvp = Rsvp::findOrFail($id);

    if($rsvp->invitation->user_id !== auth()->user()->id){
        return response()->json([
            'message' => 'Anda tidak memiliki akses untuk mengupdate data ini',
        ], 403);
    } 

        $data_rsvp = $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'nama_tamu' => 'sometimes|required',
            'status_kehadiran' => 'sometimes|required',
            'jumlah_kehadiran' => 'sometimes|required',
            'pesan'=>'sometimes|nullable|string'
        ]);
        
        if (!$rsvp) {
            return response()->json([
                'message' => 'Data  tidak ditemukan',
            ], 404);
        }
        $rsvp->update($data_rsvp);
        return response()->json([
            'message' => 'Data rsvp berhasil diperbarui',
            'data' => $rsvp->fresh()
        ], 200);
    }

    public function destroy($id)
    {

    $rsvp = Rsvp::findOrFail($id);

    if($rsvp->invitation->user_id !== auth()->user()->id){
        return response()->json([
            'message' => 'Anda tidak memiliki akses untuk mengupdate data ini',
        ], 403);
    } 
        
        $rsvp->delete();
        return response()->json([
            'message' => 'Data rsvp berhasil dihapus',
        ], 200);
    }


    public function showPesan($invitation_id)
    {

    $pesan = Rsvp::where('invitation_id', $invitation_id)
    ->whereNotNull('pesan')
    ->select('nama_tamu', 'pesan', 'created_at')
    ->latest()
    ->get();

    return response()->json([
        'message' => 'message retrieved successfully',
        'data' => $pesan
    ],200);
    }

    public function updatePesan(Request $request, $invitation_id)
    {
        $data = request->validate([
            'nama_tamu' => 'required|sometimes',
            'pesan' => 'required|string|sometimes'
        ]);
    }
}
