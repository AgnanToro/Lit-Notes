<?php
// filepath: /c:/xampp/htdocs/hewan/A Tubes/login.php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


// Inisialisasi objek buku dengan benar
require 'autoload.php';

use Perpus\Buku;
use Perpus\BukuFiksi;
use Perpus\BukuNonFiksi;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$buku1 = new BukuFiksi("Cyber Physical Systems", "Anitha Kumari K.", 2024);
$buku1->setGenre("Pendidikan");

$buku2 = new BukuNonFiksi("Laskar Pelangi", "Andrea Hirata", 2005, "drama");

$buku3 = new BukuFiksi("Atomic Habits", "James Clear", 2019);
$buku3->setGenre("Inspiratif");

$books = [
    [
        'book' => $buku1,
        'image' => 'foto/cyber.png'
    ],
    [
        'book' => $buku2,
        'image' => 'foto/laskar.png'
    ],
    [
        'book' => $buku3,
        'image' => 'foto/bukuatomic.png'
    ],
];

$searchResults = $books;

if (isset($_GET['search'])) {
    $searchQuery = strtolower($_GET['search']);
    $searchResults = array_filter($books, function($item) use ($searchQuery) {
        $book = $item['book'];
        return strpos(strtolower($book->getJudul()), $searchQuery) !== false ||
               strpos(strtolower($book->getPenulis()), $searchQuery) !== false ||
               strpos(strtolower($book->informasi()), $searchQuery) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Lit Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .book-card {
            max-width: 300px;
            margin: 0 auto;
            transition: transform 0.2s;
        }
        .book-card:hover {
            transform: scale(1.05);
        }
        .book-image {
            height: 200px;
            object-fit: cover;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }
        .social-icons a {
            color: #333;
            margin: 0 10px;
            font-size: 24px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            font-weight: bold;
        }
        .profile-card {
            max-width: 400px;
            margin: 0 auto;
        }
        .bg-custom {
            background-color: #f8f9fa;
        }
        .text-custom {
            color: #343a40;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-book"></i> Lit Notes
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#book">Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#contact">Contact Me</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="bg-warning text-white text-center py-5" id="home">
            <h1>Lit Notes Apps</h1>
            <p>Mudah mengelola buku dengan Lit Notes Apps. Ayo, coba sekarang!</p>
        </section>

        <section class="container my-5" id="book">
            <h1 class="text-center mb-5">Daftar Buku</h1>
            <form class="d-flex mb-4" method="GET" action="login.php">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari buku..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
            <div class="row">
                <?php
                if (empty($searchResults)) {
                    echo '<p class="text-center">Tidak ada buku yang ditemukan.</p>';
                } else {
                    foreach ($searchResults as $item) {
                        $book = $item['book'];
                        $image = $item['image'];
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card book-card shadow-sm">';
                        echo "<img src=\"{$image}\" class=\"card-img-top book-image\" alt=\"Book Image\">";
                        echo '<div class="card-body">';
                        echo "<h5 class=\"card-title text-custom\">{$book->getJudul()}</h5>";
                        echo "<p class=\"card-text text-custom\">{$book->informasi()}</p>";
                        echo "<p class=\"card-text text-muted\" id=\"status-{$book->getJudul()}\">Status: {$book->cekStatus()}</p>";
                        echo "<button class='btn btn-primary' onclick='ubahStatus(\"{$book->getJudul()}\", \"Tersedia\")'>Pinjam Buku</button>";
                        echo "<button class='btn btn-secondary' onclick='ubahStatus(\"{$book->getJudul()}\", \"Sedang dipinjam\")'>Kembalikan Buku</button>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </section>

        <section class="profile-section text-center mb-5" id="contact">
            <div class="profile-card bg-white p-4 rounded shadow-sm d-inline-block box-shadow-sm">
                <img src="foto/avatar.jpeg" alt="Avatar" class="avatar rounded-circle mb-3" style="width: 100px; height: 100px;">
                <h2 class="profile-name">Agnan Toro</h2>
                <p class="profile-job text-muted">Mahasiswa</p>
                <div class="book-count text-warning font-weight-bold">
                    JUMLAH BUKU: <span id="bookCount"><?php echo count($books); ?></span>
                </div>
                <div class="social-icons mt-3">
                    <a href="https://www.linkedin.com/in/agnan-toro2005?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" class="d-inline-block me-2">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://github.com/agnantoro" target="_blank" class="d-inline-block me-2">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.instagram.com/agnantoro_10?igsh=eHk4a2s5Z3F2YzZp" target="_blank" class="d-inline-block me-2">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-warning text-white text-center py-3">
        <p>&copy; 2025 Lit Notes | Agnan Toro.</p>
    </footer>

    <script>
        function ubahStatus(judul, status) {
            fetch('php/ubah_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ judul: judul, status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status buku berhasil diubah');
                    document.getElementById(`status-${judul}`).innerText = `Status: ${data.status}`;
                } else {
                    alert('Gagal mengubah status buku: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah status buku');
            });
        }
    </script>
</body>
</html>