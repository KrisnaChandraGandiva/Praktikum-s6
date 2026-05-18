<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\BukuModel;

class Kategori extends BaseController
{
    private KategoriModel $kategoriModel;
    private BukuModel $bukuModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->bukuModel     = new BukuModel();
    }

    // ──────────────────────────────────────
    // READ - Daftar Kategori dengan Search & Paginasi
    // ──────────────────────────────────────
    public function index(): string
    {
        $keyword  = $this->request->getGet('q') ?? '';
        $perPage  = 10;
        $kategori = $this->kategoriModel->getKategoriWithBukuCountPaginate($perPage, $keyword);
        $pager    = $this->kategoriModel->pager;

        $data = [
            'title'    => 'Daftar Kategori',
            'kategori' => $kategori,
            'pager'    => $pager,
            'keyword'  => $keyword,
            'total'    => $pager->getTotal(),
        ];
        return view('kategori/index', $data);
    }

    // ──────────────────────────────────────
    // CREATE - Form tambah
    // ──────────────────────────────────────
    public function tambah(): string
    {
        return view('kategori/form', [
            'title'    => 'Tambah Kategori',
            'kategori' => null,
        ]);
    }

    // ──────────────────────────────────────
    // CREATE - Proses simpan
    // ──────────────────────────────────────
    public function simpan()
    {
        $nama = trim($this->request->getPost('nama'));
        
        if (empty($nama)) {
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        // Validasi nama unik
        if ($this->kategoriModel->isNamaTaken($nama)) {
            session()->setFlashdata('error', 'Nama kategori sudah digunakan.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nama'      => $nama,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $this->kategoriModel->insert($data);
        session()->setFlashdata('sukses', "Kategori '{$nama}' berhasil ditambahkan.");
        return redirect()->to('/kategori');
    }

    // ──────────────────────────────────────
    // UPDATE - Form edit
    // ──────────────────────────────────────
    public function edit(int $id): string
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('kategori/form', [
            'title'    => 'Edit Kategori: ' . $kategori['nama'],
            'kategori' => $kategori,
        ]);
    }

    // ──────────────────────────────────────
    // UPDATE - Proses update
    // ──────────────────────────────────────
    public function update(int $id)
    {
        $nama = trim($this->request->getPost('nama'));
        
        if (empty($nama)) {
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.');
            return redirect()->back()->withInput();
        }

        // Validasi nama unik, kecuali kategori yang sedang diedit
        if ($this->kategoriModel->isNamaTaken($nama, $id)) {
            session()->setFlashdata('error', 'Nama kategori sudah digunakan kategori lain.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nama'      => $nama,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $this->kategoriModel->update($id, $data);
        session()->setFlashdata('sukses', "Kategori '{$nama}' berhasil diperbarui.");
        return redirect()->to('/kategori');
    }

    // ──────────────────────────────────────
    // DELETE
    // ──────────────────────────────────────
    public function hapus(int $id)
    {
        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan.');
            return redirect()->to('/kategori');
        }

        // Cek apakah ada buku yang menggunakan kategori ini
        $jumlahBuku = $this->bukuModel->where('kategori_id', $id)->countAllResults();
        if ($jumlahBuku > 0) {
            session()->setFlashdata('error', "Kategori '{$kategori['nama']}' tidak dapat dihapus karena masih digunakan oleh {$jumlahBuku} buku.");
            return redirect()->to('/kategori');
        }

        $this->kategoriModel->delete($id);
        session()->setFlashdata('sukses', "Kategori '{$kategori['nama']}' berhasil dihapus.");
        return redirect()->to('/kategori');
    }
}
