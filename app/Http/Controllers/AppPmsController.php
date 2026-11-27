<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Authenticated PMS operational pages (mirrors hotel/react src/pages/app):
 * reservations, room map, check-in/out, guests, rates.
 */
class AppPmsController extends Controller
{
    public function reservations(): View
    {
        return view('pages.app.reservations', ['pageTitle' => 'Reservas']);
    }

    public function roomMap(): View
    {
        return view('pages.app.room-map', ['pageTitle' => 'Mapa de quartos']);
    }

    public function checkin(): View
    {
        return view('pages.app.checkin', ['pageTitle' => 'Check-in / Check-out']);
    }

    public function guests(): View
    {
        return view('pages.app.guests', ['pageTitle' => 'Hóspedes']);
    }

    public function rates(): View
    {
        return view('pages.app.rates', ['pageTitle' => 'Tarifas']);
    }
}
