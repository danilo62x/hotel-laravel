<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Authenticated PMS area — dashboard + settings. Operational pages (reservations,
 * room map, check-in/out, guests, rates) live in AppPmsController.
 * (mirrors hotel/react src/pages/app)
 */
class AppController extends Controller
{
    public function dashboard(): View
    {
        return view('pages.app.dashboard', ['pageTitle' => 'Dashboard']);
    }

    public function settings(): View
    {
        return view('pages.app.settings', ['pageTitle' => 'Configurações']);
    }
}
