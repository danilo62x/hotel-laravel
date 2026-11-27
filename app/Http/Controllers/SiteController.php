<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Public booking site (mirrors hotel/react src/pages/public): home, rooms list,
 * room detail + booking wizard, amenities, about, contact.
 */
class SiteController extends Controller
{
    public function home(): View
    {
        return view('pages.public.home', ['pageTitle' => null]);
    }

    public function rooms(): View
    {
        return view('pages.public.rooms', ['pageTitle' => 'Acomodações']);
    }

    public function roomDetail(string $slug): View
    {
        return view('pages.public.room-detail', ['pageTitle' => 'Acomodação', 'slug' => $slug]);
    }

    public function amenities(): View
    {
        return view('pages.public.amenities', ['pageTitle' => 'Comodidades']);
    }

    public function about(): View
    {
        return view('pages.public.about', ['pageTitle' => 'Sobre']);
    }

    public function contact(): View
    {
        return view('pages.public.contact', ['pageTitle' => 'Contato']);
    }
}
