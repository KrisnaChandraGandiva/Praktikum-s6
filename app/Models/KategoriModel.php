<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;

    protected $allowedFields = [
        'nama',
        'deskripsi'
    ];

    /**
     * Ambil semua kategori untuk dropdown
     */
    public function getDropdown(): array
    {
        $kategori = $this->orderBy('nama')->findAll();

        $result = [
            '' => '-- Pilih Kategori --'
        ];

        foreach ($kategori as $k) {
            $result[$k['id']] = $k['nama'];
        }

        return $result;
    }

    /**
     * Cek apakah nama kategori sudah ada
     */
    public function isNamaTaken(string $nama, int $excludeId = 0): bool
    {
        $qb = $this->where('nama', $nama);
        if ($excludeId > 0) {
            $qb->where('id !=', $excludeId);
        }
        return $qb->countAllResults() > 0;
    }

    /**
     * Ambil kategori dengan jumlah buku dan paginasi
     */
    public function getKategoriWithBukuCountPaginate(int $perPage = 10, string $keyword = '')
    {
        $this->select('kategori.*, COUNT(buku.id) AS jumlah_buku')
             ->join('buku', 'buku.kategori_id = kategori.id', 'left')
             ->groupBy('kategori.id')
             ->orderBy('kategori.nama', 'ASC');

        if (!empty($keyword)) {
            $this->groupStart()
                 ->like('kategori.nama', $keyword)
                 ->orLike('kategori.deskripsi', $keyword)
                 ->groupEnd();
        }

        return $this->paginate($perPage);
    }
}