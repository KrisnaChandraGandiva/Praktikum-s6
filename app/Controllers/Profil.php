<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Profil extends BaseController
{
    public function index()
    {
        $data = [
            'npm' => '2310010343', 
            'nama' => 'Krisna Chandra Gandiva', 
            'prodi' => 'Teknik Informatika',
            'angkatan' => '2023',
            'ipk' => 3.77,
            'matkul' => [
                'Testing',
                'Etika dan Profesi',
                'Fiqih',
                'pengolahan citra',
                'jaringan saraf tiruan',
            ]
        ];

        return view('profil/index', $data);
    }
}