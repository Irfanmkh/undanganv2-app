<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{

    public function index()
    {
        $invitations = auth()->user()->invitations;
        // return response()->json([
        //     'message' => 'Invitations retrieved successfully',
        //     'data' => $invitations
        // ]);

        $tema = Tema::all();
        return \Inertia\Inertia::render('Invitations/Create',
        [
            'daftar_tema' => $tema
        ]);
    }



    public function store(Request $request)
    {
        $validasi = $request->validate([
            'slug' => 'required|unique:invitations,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'fullname_pria' => 'required|string',
            'nickname_pria' => 'required|string',
            'fullname_wanita' => 'required|string',
            'nickname_wanita' => 'required|string',
            'ayah_pria' => 'required|string',
            'ibu_pria' => 'required|string',
            'ayah_wanita' => 'required|string',
            'ibu_wanita' => 'required|string',
            'waktu_resepsi' => 'required|date',
            'waktu_akad' => 'required|date',
            'lokasi_akad' => 'required|string',
            'lokasi_resepsi' => 'required|string',
            'link_map_akad' => 'required|url',
            'link_map_resepsi' => 'required|url',
            'tema_id'=>'required|exists:temas,id'
        ]);


        $validasi['user_id'] = auth()->user()->id;  

        $invitation = Invitation::create($validasi);

        // return response()->json([
        //     'message' => 'Invitation created successfully',
        //     'data' => $invitation
        // ]);

        return redirect()->route('dashboard')->with('sukses_simpan', 'Undangan Sukses Disimpan! 🎉');
    }

    public function show($id)
    {

        $invitation = auth()->user()->invitations()->findOrFail($id);
        return response()->json([
            'message' => 'Invitation retrieved successfully',
            'data' => $invitation
        ]);
    }

    public function update(Request $request, $id)
    {

        $invitation = auth()->user()->invitations()->findOrFail($id);

        $dataBaru = $request->validate([
            'slug' => 'sometimes|unique:invitations,slug,' . $invitation->id,
            'fullname_pria' => 'sometimes|string',
            'nickname_pria' => 'sometimes|string',
            'fullname_wanita' => 'sometimes|string',
            'nickname_wanita' => 'sometimes|string',
            'ayah_pria' => 'sometimes|string',
            'ibu_pria' => 'sometimes|string',
            'ayah_wanita' => 'sometimes|string',
            'ibu_wanita' => 'sometimes|string',
            'tema' => 'sometimes|string',
            'waktu_resepsi' => 'sometimes|date',
            'waktu_akad' => 'sometimes|date',
            'lokasi_akad' => 'sometimes|string',
            'lokasi_resepsi' => 'sometimes|string',
            'link_map_akad' => 'sometimes|url',
            'link_map_resepsi' => 'sometimes|url'
        ]);

        $invitation->update($dataBaru);


        return response()->json([
            'message' => 'Invitation updated successfully',
            'data' => $invitation
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
