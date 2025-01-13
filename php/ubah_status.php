<?php
require '../autoload.php';

use Perpus\Buku;
use Perpus\BukuFiksi;
use Perpus\BukuNonFiksi;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inisialisasi beberapa buku sebagai contoh
$buku1 = new BukuFiksi("Cyber Physical Systems", "Anitha Kumari K.", 2024);
$buku1->setGenre("Pendidikan");

$buku2 = new BukuNonFiksi("Laskar Pelangi", "Andrea Hirata", 2005, "drama");

$buku3 = new BukuFiksi("Atomic Habits", "James Clear", 2019);
$buku3->setGenre("Inspiratif");

$bukuList = [$buku1, $buku2, $buku3];

// Fungsi untuk mengubah status buku
function ubahStatusBuku($judul, $status, $bukuList) {
    foreach ($bukuList as $book) {
        if ($book->judul === $judul) {
            // Tambahkan pengecekan untuk buku 1
            if ($judul === "Cyber Physical Systems") {
                throw new Exception("Buku 1 tidak dapat diakses.");
            }
            $book->setStatus($status === "Tersedia" ? false : true);
            return ["success" => true, "message" => "Status buku berhasil diubah", "status" => $book->cekStatus()];
        }
    }
    return ["success" => false, "message" => "Buku tidak ditemukan"];
}

// Proses permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['judul']) && isset($data['status'])) {
        $judul = $data['judul'];
        $status = $data['status'];
        try {
            $result = ubahStatusBuku($judul, $status, $bukuList);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Judul atau status buku tidak diberikan"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Metode permintaan tidak valid"]);
}
?>