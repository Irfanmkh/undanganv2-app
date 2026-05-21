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
        $data_tamu = Rsvp::all();
        return response()->json([
            'message' => 'Data tamu berhasil diambil',
            'data' => $data_tamu
        ], 200);
    }
    public function store(Request $request)
    {
        $tamu = $request->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'nama_tamu' => 'required',
            'status_kehadiran' => 'required',
            'jumlah_kehadiran' => 'required'
        ]);

        $dataTamu = Rsvp::create($tamu);
        return response()->json([
            'message' => 'Data tamu berhasil disimpan',
            'data' => $dataTamu
        ], 201);
    }


    public function show($slug)
    {
        $invitaion = Invitation::where('slug', $slug)->firstOrFail();
        $data_tamu = Rsvp::where('invitation_id', $invitaion->id)->get();
        return response()->json([
            'message' => 'Data tamu berhasil diambil',
            'data' => $data_tamu
        ], 200);
    }

    public function showdetail($id)
    {
        $data_tamu = Rsvp::find($id);
        if (!$data_tamu) {
            return response()->json([
                'message' => 'Data tamu tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'message' => 'Data tamu berhasil diambil',
            'data' => $data_tamu
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $tamu = $request()->validate([
            'invitation_id' => 'required|exists:invitations,id',
            'nama_tamu' => 'sometimes|required',
            'status_kehadiran' => 'sometimes|required',
            'jumlah_kehadiran' => 'sometimes|required'
        ]);
        $data_tamu = Rsvp::find($id);
        if (!$data_tamu) {
            return response()->json([
                'message' => 'Data tamu tidak ditemukan',
            ], 404);
        }
        $data_tamu->update($tamu);
        return response()->json([
            'message' => 'Data tamu berhasil diperbarui',
            'data' => $data_tamu
        ], 200);
    }

    public function destroy($id)
    {
        $data_tamu = Rsvp::find($id);
        if (!$data_tamu) {
            return response()->json([
                'message' => 'Data tamu tidak ditemukan',
            ], 404);
        }
        $data_tamu->delete();
        return response()->json([
            'message' => 'Data tamu berhasil dihapus',
        ], 200);
    }
}
