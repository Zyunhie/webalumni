<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Alumni;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\HeroSlide;
use App\Models\Lowongan;
use App\Models\testimonials;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'heroSlides'    => HeroSlide::aktif()->get(),
            'testimonis'    => testimonials::where('status', 'approved')->latest()->take(7)->get(),
            'agendas'       => Agenda::latest('tanggal_mulai')->take(7)->get(),
            'beritas'       => Berita::latest()->take(7)->get(),
            'lowongans'     => Lowongan::latest()->take(7)->get(),
            'about'         => About::first(),
            'totalAlumni'   => Alumni::where('status', 'approved')->count(),
            'bekerja'       => Alumni::where('status', 'approved')->whereNotNull('pekerjaan')->where('pekerjaan', '!=', '')->count(),
        ]);
    }
}