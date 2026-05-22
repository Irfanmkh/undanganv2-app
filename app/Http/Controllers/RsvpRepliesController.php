<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Rsvp;
use App\Models\Rsvpreply;
use App\Models\User;
use Illuminate\Http\Request;

class RsvpRepliesController extends Controller
{
    //

public function storeReply(Request $request, $rsvp_id) // <-- Hanya menerima $rsvp_id
{
    // 1. CARI KOMENTAR INDUKNYA DULU
    $rsvpInduk = Rsvp::findOrFail($rsvp_id);

    // 2. SATPAM HAK AKSES: 
    // Ambil invitation_id dari komentar induk tadi, lalu cek apakah benar itu milik admin yang login
    $invitation = auth()->user()->invitations()->findOrFail($rsvpInduk->invitation_id);

    // 3. VALIDASI INPUT
    $balasan = $request->validate([
        "pesan_reply" => "required|string"
    ]);

    // 4. RAKIT DATA
    $balasan["rsvp_id"] = $rsvpInduk->id;
    $balasan["user_id"] = auth()->user()->id; 
    $balasan["nama_pembalas"] = $invitation->slug; 

    // 5. SIMPAN
    $publicReply = Rsvpreply::create($balasan);

    return response()->json([
        "message" => "Reply berhasil ditambahkan",
        "data" => $publicReply
    ], 201);
}

public function updateReply(Request $request, $reply_id)
{
    // 1. CARI REPLYNYA DULU
    $reply = Rsvpreply::findOrFail($reply_id);

    // 2. SATPAM HAK AKSES: 
    // Ambil invitation_id dari komentar induk, lalu cek apakah benar itu milik admin yang login
    $invitation = auth()->user()->invitations()->findOrFail($reply->rsvp->invitation_id);

    // 3. VALIDASI INPUT
    $data = $request->validate([
        "pesan_reply" => "required|string|sometimes"
    ]);

    // 4. UPDATE
    $reply->update($data);

    return response()->json([
        "message" => "Reply berhasil diupdate",
        "data" => $reply
    ], 200);
}

public function destroyReply($reply_id)
{
    // 1. CARI REPLYNYA DULU
    $reply = Rsvpreply::findOrFail($reply_id);

    // 2. SATPAM HAK AKSES: 
    // Ambil invitation_id dari komentar induk, lalu cek apakah benar itu milik admin yang login
    $invitation = auth()->user()->invitations()->findOrFail($reply->rsvp->invitation_id);

    // 3. HAPUS
    $reply->delete();

    return response()->json([
        "message" => "Reply berhasil dihapus"
    ], 200);
}

public function showReplies($rsvp_id)
{
    // 1. CARI KOMENTAR INDUKNYA DULU
    $rsvpInduk = Rsvp::findOrFail($rsvp_id);

    // 2. SATPAM HAK AKSES: 
    // Ambil invitation_id dari komentar induk tadi, lalu cek apakah benar itu milik admin yang login
    $invitation = auth()->user()->invitations()->findOrFail($rsvpInduk->invitation_id);

    // 3. AMBIL REPLYNYA
    $replies = $rsvpInduk->rsvpreplies()->with('user')->get();

    return response()->json([
        "message" => "Daftar reply untuk komentar dengan ID $rsvp_id",
        "data" => $replies
    ], 200);
}
}
