<?php
namespace Perpus;

class Buku implements BookInterface {
    public $judul; 
    protected $penulis; 
    public $bidang;
    public $Genre;
    private $tahunTerbit; 
    protected $statusPinjam = false; 
    protected $gambar;

    public function __construct($judul, $penulis, $tahunTerbit, $bidang = null, $gambar = null) {
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahunTerbit = $tahunTerbit;
        $this->gambar = $gambar;
        $this->bidang = $bidang;
        $this->gambar = $gambar;
    }

    public function setJudul($judul) {
        $this->judul = $judul;
    }

    public function setPenulis($penulis) {
        $this->penulis = $penulis;
    }

    public function setTahunTerbit($tahunTerbit) {
        $this->tahunTerbit = $tahunTerbit;
    }

    public function setBidang($bidang) {
        $this->bidang = $bidang;
    }

    public function getJudul() {
        return $this->judul;
    }

    public function getPenulis() {
        return $this->penulis;
    }

    public function getTahunTerbit() { 
        return $this->tahunTerbit;
    }

    public function getGambar() {
        return $this->gambar;
    }

    public function cekStatus() {
        return $this->statusPinjam ? "Sedang dipinjam" : "Tersedia";
    }

    public function pinjamBuku() {
        if ($this->statusPinjam) {
            return "Buku '{$this->judul}' sudah dipinjam.";
        } else {
            $this->statusPinjam = true;
            return "Buku '{$this->judul}' berhasil dipinjam.";
        }
    }

    public function kembalikanBuku() {
        if ($this->statusPinjam) {
            $this->statusPinjam = false;
            return "Buku '{$this->judul}' berhasil dikembalikan.";
        } else {
            return "Buku '{$this->judul}' belum dipinjam.";
        }
    }

    public function setStatus($status) {
        $this->statusPinjam = $status;
    }
}