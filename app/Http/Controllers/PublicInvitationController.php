<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class PublicInvitationController extends Controller
{
    //

    public function show($slug, $invitation_id)
    {
        $invitation = Invitation::where('slug', $slug)->findOrFail($invitation_id);

        return response()->json([
            'message' => 'Data undangan berhasil diambil',
            'data' => $invitation
        ], 200);
    }
}
