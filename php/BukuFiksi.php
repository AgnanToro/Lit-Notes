<?php
namespace Perpus;

class BukuFiksi extends Buku {
    public $genre; 

    public function setGenre($genre) {
        $this->genre = $genre;
    }

    public function informasi() {
        return "Judul: {$this->judul}, Penulis: {$this->penulis}, Tahun Terbit: {$this->getTahunTerbit()}, Genre: {$this->genre}.";
    }
}