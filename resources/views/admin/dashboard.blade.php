<x-app-layout>
    <style>
        body {
            background: #f5f9f6 !important;
        }

        .hero {
            background: linear-gradient(135deg, #4CAF50, #6BCF8A);
            padding: 40px;
            border-radius: 16px;
            color: white;
            margin-bottom: 32px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 26px rgba(0,0,0,0.12);
        }

        .btn-primary {
            background: #1d4ed8;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-success {
            background: #16a34a;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>

    <div class="max-w-5xl mx-auto px-6 py-8">

        <!-- HERO SECTION -->
        <div class="hero">
            <h1 class="text-3xl font-bold">Selamat Datang, Admin! 👋</h1>
            <p class="mt-2 text-lg opacity-90">
                Kelola seluruh sistem Kidzy Store dari halaman ini.
            </p>
        </div>

        <!-- CARD MENU -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Verifikasi Toko -->
            <div class="card">
                <h2 class="text-xl font-semibold mb-3">Verifikasi Toko</h2>
                <p class="mb-4 text-gray-600">
                    Lihat dan kelola toko yang menunggu persetujuan.
                </p>
                <a href="/admin/store-verification" class="btn-primary">Masuk</a>
            </div>

            <!-- Manajemen User -->
            <div class="card">
                <h2 class="text-xl font-semibold mb-3">Manajemen User & Store</h2>
                <p class="mb-4 text-gray-600">
                    Kelola data user, seller, dan seluruh aktivitasnya.
                </p>
                <a href="/admin/users" class="btn-success">Kelola</a>
            </div>

        </div>

    </div>

</x-app-layout>
