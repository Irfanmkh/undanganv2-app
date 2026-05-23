<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Rsvplike;
use App\Models\Rsvpreply;
use App\Models\Rsvpreplylike;
use Illuminate\Http\Request;

class PublicRsvpController extends Controller
{
    //

    public function update(Request $request, $id)
    {
        $rsvp = Rsvp::findOrFail($id);

        if ($rsvp->guest_token !== $request->header("guestToken")) {
            return response()->json([
                "message" => "Unauthorized",
                "data" => null
            ], 401);
        }
        $pesan_rsvp = $request->validate([
            'nama_tamu' => 'required|sometimes',
            'status_kehadiran' => 'required|sometimes',
            'jumlah_kehadiran' => 'required|sometimes',
            'pesan' => 'nullable|string|sometimes'
        ]);

        $rsvp->update($pesan_rsvp);
        return response()->json([
            'message' => 'Data Rsvp berhasil diperbarui',
            'data' => $rsvp
        ], 200);
    }



    public function like(Request $request, $id)
    {
        $guestToken = $request->header("guestToken");

        $rsvp = Rsvp::findOrFail($id);

        $like = Rsvplike::firstOrCreate([
            "rsvp_id" => $id,
            "guest_token" => $guestToken
        ]);

        if ($guestToken === null) {
            return response()->json([
                "message" => "Guest token is required",
                "data" => null
            ], 400);
        }

        if ($like->wasRecentlyCreated) {
            Rsvp::where("id", $id)->increment("like_count");
            return response()->json([
                "message" => "Liked",
                "data" => $rsvp->fresh()->like_count
            ], 200);
        } else {
            $like->delete();
            Rsvp::where("id", $id)->decrement("like_count");
            return response()->json([
                "message" => "Unliked",
                "data" => $rsvp->fresh()->like_count

            ], 200);
        }
    }

    public function likeReply(Request $request, $id)
    {
        $guestToken = $request->header("guestToken");

        $reply = Rsvpreply::findOrFail($id);

        if ($guestToken === null) {
            return response()->json([
                "message" => "Guest token is required",
                "data" => null
            ], 400);
        }

        $like = Rsvpreplylike::firstOrCreate([
            "rsvpreply_id" => $id,
            "guest_token" => $guestToken
        ]);

        if ($like->wasRecentlyCreated) {
            Rsvpreply::where("id", $id)->increment("like_count");
            return response()->json([
                "message" => "Liked",
                "data" => $reply->fresh()->like_count
            ], 200);
        } else {
            $like->delete();
            Rsvpreply::where("id", $id)->decrement("like_count");
            return response()->json([
                "message" => "Unliked",
                "data" => $reply->fresh()->like_count
            ], 200);
        }
    }
}
