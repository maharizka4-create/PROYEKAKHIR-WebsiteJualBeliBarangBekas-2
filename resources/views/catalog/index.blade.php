<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang - SEKENOVA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9f6f1;
            color: #493629;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 24px;
        }

        header {
            background: white;
            border-bottom: 1px solid #eadfd3;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding-top: 22px;
            padding-bottom: 22px;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        nav {
            display: flex;
            gap: 24px;
            font-size: 14px;
        }

        nav a:hover {
            color: #ad846a;
        }

        .hero {
            background: #efe6da;
            padding: 65px 0;
        }

        .hero small {
            color: #9b765c;
            letter-spacing: 3px;
            font-weight: bold;
        }

        .hero h1 {
            font-size: 40px;
            margin: 15px 0;
        }

        .hero p {
            color: #806d5e;
            line-height: 1.7;
        }

        main {
            padding-top: 40px !important;
            padding-bottom: 60px !important;
        }

        .filter-box {
            background: white;
            padding: 26px;
            border-radius: 16px;
            border: 1px solid #eadfd3;
            margin-bottom: 40px;
        }

        .filter-box h2 {
            margin-top: 0;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        input, select {
            padding: 13px;
            border: 1px solid #dfd2c3;
            border-radius: 8px;
            width: 100%;
            background: white;
            color: #493629;
        }

        .btn {
            background: #684735;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 13px 20px;
            cursor: pointer;
        }

        .btn:hover {
            background: #503526;
        }

        .reset {
            display: inline-block;
            margin-top: 16px;
            font-size: 13px;
            color: #98745b;
        }

        .section-title {
            margin-bottom: 24px;
        }

        .section-title h2 {
            margin-bottom: 8px;
        }

        .section-title p {
            margin: 0;
            color: #8b786b;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .product-card {
            background: white;
            border: 1px solid #eadfd3;
            border-radius: 16px;
            overflow: hidden;
        }

        .product-image {
            height: 220px;
            background: #ebe0d4;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #9a8575;
            font-size: 13px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
        }

        .category {
            font-size: 11px;
            color: #98745b;
            text-transform: uppercase;
        }

        .product-info h3 {
            font-size: 17px;
            margin: 12px 0;
        }

        .condition {
            font-size: 13px;
            color: #8b786b;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0 12px;
        }

        .stock {
            color: #8b786b;
            font-size: 12px;
        }

        .empty {
            background: white;
            padding: 70px 20px;
            text-align: center;
            border: 1px dashed #d8c7b6;
            border-radius: 16px;
            color: #8b786b;
        }

        .pagination {
            margin-top: 35px;
        }

        footer {
            text-align: center;
            padding: 28px;
            background: white;
            color: #8b786b;
            font-size: 13px;
            border-top: 1px solid #eadfd3;
        }

        @media (max-width: 900px) {
            .filter-form {
                grid-template-columns: repeat(2, 1fr);
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
            }

            .hero h1 {
                font-size: 28px;
            }

            .filter-form,
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="container navbar">
        <a href="/" class="logo">SEKENOVA</a>

        <nav>
            <a href="/">Beranda</a>
            <a href="{{ route('catalog.index') }}">Katalog</a>

            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Masuk</a>
            @endauth
        </nav>
    </div>
</header>

<section class="hero">
    <div class="container">
        <small>PRELOVED MARKETPLACE</small>

        <h1>Temukan Cerita Baru dari Barang Lama</h1>

        <p>
            Jelajahi koleksi barang bekas berkualitas
            yang siap menemukan pemilik barunya.
        </p>
    </div>
</section>

<main class="container">

    <section class="filter-box">
        <h2>Cari Barang Impianmu</h2>

        <form method="GET"
              action="{{ route('catalog.index') }}"
              class="filter-form">

            <input
                type="search"
                name="search"
                placeholder="Cari nama barang..."
                value="{{ $filters['search'] ?? '' }}"
            >

            <select name="category">
                <option value="">Semua Kategori</option>

                @foreach (['Elektronik', 'Fashion', 'Buku', 'Furnitur', 'Hobi', 'Lainnya'] as $category)
                    <option value="{{ $category }}"
                        @selected(($filters['category'] ?? '') === $category)>
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            <select name="condition">
                <option value="">Semua Kondisi</option>
                <option value="seperti_baru"
                    @selected(($filters['condition'] ?? '') === 'seperti_baru')>
                    Seperti Baru
                </option>
                <option value="baik"
                    @selected(($filters['condition'] ?? '') === 'baik')>
                    Baik
                </option>
                <option value="cukup"
                    @selected(($filters['condition'] ?? '') === 'cukup')>
                    Cukup
                </option>
            </select>

            <button type="submit" class="btn">
                Cari Barang
            </button>
        </form>

        <a href="{{ route('catalog.index') }}" class="reset">
            Hapus semua filter
        </a>
    </section>

    <section class="section-title">
        <h2>Koleksi Pilihan</h2>
        <p>{{ $products->total() }} barang ditemukan</p>
    </section>

    @if ($products->count() > 0)

        <section class="product-grid">

            @foreach ($products as $product)

                <article class="product-card">

                    <div class="product-image">
                        @if ($product->image)
                            <img
                                src="{{ filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                            >
                        @else
                            Foto belum tersedia
                        @endif
                    </div>

                    <div class="product-info">

                        <div class="category">
                            {{ $product->category }}
                        </div>

                        <h3>{{ $product->name }}</h3>

                        <p class="condition">
                            Kondisi:
                            {{ match($product->condition) {
                                'seperti_baru' => 'Seperti Baru',
                                'baik' => 'Baik',
                                'cukup' => 'Cukup',
                                default => $product->condition
                            } }}
                        </p>

                        <p class="price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <p class="stock">
                            Stok: {{ $product->stock }}
                        </p>

                    </div>
                </article>

            @endforeach

        </section>

        <div class="pagination">
            {{ $products->links() }}
        </div>

    @else

        <div class="empty">
            <h3>Belum Ada Barang Ditemukan</h3>
            <p>Coba gunakan kata kunci atau filter lainnya.</p>
        </div>

    @endif

</main>

<footer>
    © 2026 SEKENOVA. Every item deserves a second story.
</footer>

</body>
</html>