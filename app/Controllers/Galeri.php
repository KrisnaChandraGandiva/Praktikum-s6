<?php

namespace App\Controllers;

class Galeri extends BaseController
{
    public function index()
    {
        helper('text');

        $dataGaleri = [
            [
                'judul' => 'Danau Pegunungan',
                'url_gambar' => 'https://picsum.photos/id/1011/600/400',
                'deskripsi' => 'Pemandangan danau jernih di kaki pegunungan dengan suasana alam yang tenang dan sejuk.',
                'kategori' => 'alam'
            ],
            [
                'judul' => 'Manusia Dan Anjing',
                'url_gambar' => 'https://picsum.photos/id/1012/600/400',
                'deskripsi' => 'Gambar Manusia dan anjing yang sedang menatap kepadang rumput.',
                'kategori' => 'manusia'
            ],
            [
                'judul' => 'Laptop Modern',
                'url_gambar' => 'https://picsum.photos/id/180/600/400',
                'deskripsi' => 'Laptop modern dengan desain elegan yang mendukung aktivitas teknologi dan pekerjaan digital.',
                'kategori' => 'teknologi'
            ],
            [
                'judul' => 'Wanita',
                'url_gambar' => 'https://picsum.photos/id/1013/600/400',
                'deskripsi' => 'Seorang wanita bergaun cantik dipegang oleh tangan seseorang.',
                'kategori' => 'manusia'
            ],
            [
                'judul' => 'Gedung Perkotaan',
                'url_gambar' => 'https://picsum.photos/id/1031/600/400',
                'deskripsi' => 'Deretan gedung tinggi mencerminkan kehidupan kota yang modern dan sibuk.',
                'kategori' => 'kota'
            ],
            [
                'judul' => 'Anjing Lucu',
                'url_gambar' => 'https://picsum.photos/id/1025/600/400',
                'deskripsi' => 'Seekor Anjing berbulu putih-oranye tampil lucu dengan tatapan yang menggemaskan.',
                'kategori' => 'hewan'
            ]
        ];

        $kategori = $this->request->getGet('kategori');

        if ($kategori) {
            $dataGaleri = array_filter($dataGaleri, function ($item) use ($kategori) {
                return $item['kategori'] === $kategori;
            });
        }

        return view('galeri/index', [
            'title' => 'Galeri',
            'galeri' => $dataGaleri,
            'kategori_aktif' => $kategori
        ]);
    }
}