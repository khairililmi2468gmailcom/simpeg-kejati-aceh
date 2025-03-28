<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiBarchartController extends Controller
{
    public function index()
    {
        $data = collect([
            ['kabupaten' => 'Aceh Barat', 'jumlah' => 120],
            ['kabupaten' => 'Aceh Barat Daya', 'jumlah' => 90],
            ['kabupaten' => 'Aceh Besar', 'jumlah' => 150],
            ['kabupaten' => 'Aceh Jaya', 'jumlah' => 80],
            ['kabupaten' => 'Aceh Selatan', 'jumlah' => 110],
            ['kabupaten' => 'Aceh Singkil', 'jumlah' => 95],
            ['kabupaten' => 'Aceh Tamiang', 'jumlah' => 85],
            ['kabupaten' => 'Aceh Tengah', 'jumlah' => 130],
            ['kabupaten' => 'Aceh Tenggara', 'jumlah' => 140],
            ['kabupaten' => 'Aceh Timur', 'jumlah' => 100],
            ['kabupaten' => 'Aceh Utara', 'jumlah' => 160],
            ['kabupaten' => 'Bener Meriah', 'jumlah' => 105],
            ['kabupaten' => 'Bireuen', 'jumlah' => 125],
            ['kabupaten' => 'Gayo Lues', 'jumlah' => 75],
            ['kabupaten' => 'Nagan Raya', 'jumlah' => 115],
            ['kabupaten' => 'Pidie', 'jumlah' => 135],
            ['kabupaten' => 'Pidie Jaya', 'jumlah' => 145],
            ['kabupaten' => 'Simeulue', 'jumlah' => 70],
            ['kabupaten' => 'Subulussalam', 'jumlah' => 155],
            ['kabupaten' => 'Langsa', 'jumlah' => 165],
            ['kabupaten' => 'Lhokseumawe', 'jumlah' => 90],
            ['kabupaten' => 'Sabang', 'jumlah' => 60],
            ['kabupaten' => 'Banda Aceh', 'jumlah' => 180],
        ]);

        return view('admin.home.index', compact('data'));
    }
}
