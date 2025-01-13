<?php
namespace Perpus;

class BukuNonFiksi extends Buku {
    public $bidang;

    public function __construct($judul, $penulis, $tahunTerbit, $bidang) {
        parent::__construct($judul, $penulis, $tahunTerbit);
        $this->bidang = $bidang;
    }

    public function setBidang($bidang) {
        $this->bidang = $bidang;
    }

    public function informasi() {
        return "Judul: {$this->judul}, Penulis: {$this->penulis}, Tahun Terbit: {$this->getTahunTerbit()}, Bidang: {$this->bidang}.";
    }
}