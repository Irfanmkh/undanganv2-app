<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{

    public function index()
    {
        $invitations = Invitation::all();
        return response()->json([
            'message' => 'Invitations retrieved successfully',
            'data' => $invitations
        ]);
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
            'slug' => 'required|unique:invitations,slug',
            'fullname_pria' => 'required|string',
            'nickname_pria' => 'required|string',
            'fullname_wanita' => 'required|string',
            'nickname_wanita' => 'required|string',
            'ayah_pria' => 'required|string',
            'ibu_pria' => 'required|string',
            'ayah_wanita' => 'required|string',
            'ibu_wanita' => 'required|string',
            'tema' => 'required|string',
            'waktu_resepsi' => 'required|date_format:Y-m-d H:i:s',
            'waktu_akad' => 'required|date_format:Y-m-d H:i:s',
            'lokasi_akad' => 'required|string',
            'lokasi_resepsi' => 'required|string',
            'link_map_akad' => 'required|url',
            'link_map_resepsi' => 'required|url'
        ]);


        $invitation = Invitation::create($validasi);

        return response()->json([
            'message' => 'Invitation created successfully',
            'data' => $invitation
        ]);
    }

    public function show($slug)
    {
        $invitation = Invitation::where('slug', $slug)->firstOrFail();
        return response()->json([
            'message' => 'Invitation retrieved successfully',
            'data' => $invitation
        ]);
    }

    public function update(Request $request, $slug)
    {
        $dataLama = Invitation::where('slug', $slug)->firstOrFail();

        $dataBaru = $request->validate([
            'slug' => 'sometimes|unique:invitations,slug,' . $dataLama->id,
            'fullname_pria' => 'sometimes|string',
            'nickname_pria' => 'sometimes|string',
            'fullname_wanita' => 'sometimes|string',
            'nickname_wanita' => 'sometimes|string',
            'ayah_pria' => 'sometimes|string',
            'ibu_pria' => 'sometimes|string',
            'ayah_wanita' => 'sometimes|string',
            'ibu_wanita' => 'sometimes|string',
            'tema' => 'sometimes|string',
            'waktu_resepsi' => 'sometimes|date_format:Y-m-d H:i:s',
            'waktu_akad' => 'sometimes|date_format:Y-m-d H:i:s',
            'lokasi_akad' => 'sometimes|string',
            'lokasi_resepsi' => 'sometimes|string',
            'link_map_akad' => 'sometimes|url',
            'link_map_resepsi' => 'sometimes|url'
        ]);


        return response()->json([
            'message' => 'Invitation updated successfully',
            'data' => $dataLama->update($dataBaru)
        ]);
    }

    public function destroy($id)
    {
        $data = Invitation::findOrFail($id);
        $data->delete();
        return response()->json([
            'message' => 'Invitation deleted successfully'
        ]);
    }
}
