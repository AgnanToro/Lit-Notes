<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Baca data pengguna dari file users.txt
    $file = fopen('users.txt', 'r');
    $isValid = false;

    while (($line = fgets($file)) !== false) {
        list($storedUsername, $storedPassword) = explode(',', trim($line));
        if ($username === $storedUsername && password_verify($password, $storedPassword)) {
            $isValid = true;
            break;
        }
    }

    fclose($file);

    if ($isValid) {
        // Login berhasil, redirect ke halaman utama
        $_SESSION['username'] = $username;
        header('Location: login.php');
        exit();
    } else {
        // Login gagal, kembali ke halaman login dengan pesan error
        header('Location: lojin.php?error=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://ai-public.creatie.ai/gen_page/tailwind-custom.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com/3.4.5?plugins=forms@0.5.7,typography@0.5.13,aspect-ratio@0.4.2,container-queries@0.1.1"></script>
    <script src="https://ai-public.creatie.ai/gen_page/tailwind-config.min.js" data-color="#000000" data-border-radius="small"></script>
</head>
<body class="bg-gray-50 font-sans">
    <main class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex min-h-screen items-center justify-center bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-sm space-y-6 bg-white p-8 rounded-xl shadow-lg">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Masuk</h2>
                </div>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Registrasi berhasil!</strong>
                        <span class="block sm:inline">Silakan login.</span>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">Username atau password salah!</span>
                    </div>
                <?php endif; ?>
                <form class="mt-6 space-y-6" action="lojin.php" method="POST">
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Nama Pengguna</label>
                            <input type="text" name="username" required class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-yellow-500 focus:outline-none focus:ring-yellow-500" placeholder="Masukkan nama pengguna"/>
                        </div>
                        <div class="mt-4">
                            <label class="text-sm font-medium text-gray-700">Kata Sandi</label>
                            <input type="password" name="password" required class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-yellow-500 focus:outline-none focus:ring-yellow-500" placeholder="********"/>
                        </div>
                    </div>
                    <button type="submit" class="w-full rounded-md bg-yellow-500 py-2.5 px-4 text-white font-medium hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">Masuk</button>
                </form>
                <p class="mt-4 text-center text-sm text-gray-600">Belum punya akun? <a href="register.php" class="text-yellow-500 hover:text-yellow-600 font-medium">Daftar</a></p>
            </div>
        </div>
    </main>
</body>
</html>