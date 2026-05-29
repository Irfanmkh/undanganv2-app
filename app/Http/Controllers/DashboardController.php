<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //

    public function index(){
        $undanganku = Invitation::with('tema')->where('user_id', auth()->user()->id)->latest()->get();

        return Inertia::render('Dashboard', [
            'invitations'=> $undanganku
        ]);
    }
}
