<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang - SEKENOVA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f6f1;
            color: #493629;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input, select {
            font-family: inherit;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: auto;
            padding: 0 24px;
        }

        /* NAVBAR */
        header {
            background: white;
            border-bottom: 1px solid #eadfd3;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            min-height: 78px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #503321;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #503321;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
        }

        .logo-text strong {
            display: block;
            font-size: 20px;
            letter-spacing: 2px;
        }

        .logo-text small {
            display: block;
            font-size: 10px;
            color: #98745b;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 28px;
            font-size: 14px;
            font-weight: 500;
        }

        nav a:hover {
            color: #a77a52;
        }

        .nav-button {
            background: #503321;
            color: white;
            padding: 11px 22px;
            border-radius: 9px;
        }

        /* HERO */
        .hero {
            padding: 48px 0;
        }

        .hero-box {
            background: linear-gradient(120deg, #301b11, #68432d, #95613b);
            border-radius: 24px;
            padding: 55px 60px;
            color: white;
        }

        .hero-label {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 30px;
            padding: 9px 18px;
            color: #ffebaa;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-size: 38px;
            line-height: 1.25;
            max-width: 650px;
            margin-bottom: 16px;
        }

        .hero p {
            color: #f0e3d6;
            font-size: 14px;
            line-height: 1.8;
            max-width: 650px;
        }

        .hero-highlight {
            color: #ffe58a;
        }

        main {
            padding-bottom: 75px;
        }

        /* FILTER */
        .filter-box {
            background: white;
            padding: 28px;
            border-radius: 18px;
            border: 1px solid #eadfd3;
            margin-bottom: 45px;
            box-shadow: 0 5px 20px rgba(73,54,41,0.04);
        }

        .filter-box h2 {
            font-size: 21px;
            margin-bottom: 8px;
        }

        .filter-box > p {
            color: #927c6b;
            font-size: 13px;
            margin-bottom: 22px;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 13px;
        }

        input, select {
            width: 100%;
            padding: 14px;
            border: 1px solid #dfd2c3;
            border-radius: 9px;
            outline: none;
            background: white;
            color: #493629;
            font-size: 13px;
        }

        input:focus, select:focus {
            border-color: #80583d;
            box-shadow: 0 0 0 3px rgba(128,88,61,0.1);
        }

        .btn {
            border: none;
            background: #503321;
            color: white;
            border-radius: 9px;
            padding: 13px 22px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            background: #704a32;
        }

        .reset {
            display: inline-block;
            margin-top: 16px;
            color: #98745b;
            font-size: 12px;
        }

        .reset:hover {
            text-decoration: underline;
        }

        /* SECTION TITLE */
        .section-title {
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .section-title h2 {
            font-size: 24px;
        }

        .section-title p {
            color: #927c6b;
            font-size: 13px;
        }

        /* PRODUCT GRID */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 23px;
        }

        .product-card {
            display: block;
            background: white;
            border: 1px solid #eadfd3;
            border-radius: 16px;
            overflow: hidden;
            transition: 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(73,54,41,0.10);
            border-color: #c8aa8e;
        }

        .product-image {
            height: 220px;
            background: #eee3d7;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: #98745b;
            font-size: 13px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.04);
        }

        .product-info {
            padding: 19px;
        }

        .category {
            color: #98745b;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-info h3 {
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.5;
            min-height: 48px;
        }

        .condition {
            font-size: 12px;
            color: #8b786b;
            margin-bottom: 14px;
        }

        .price {
            color: #503321;
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stock {
            color: #8b786b;
            font-size: 11px;
        }

        .detail-label {
            display: inline-block;
            margin-top: 14px;
            color: #80583d;
            font-size: 12px;
            font-weight: 600;
        }

        /* EMPTY */
        .empty {
            background: white;
            padding: 70px 20px;
            text-align: center;
            border: 1px dashed #d8c7b6;
            border-radius: 16px;
            color: #8b786b;
        }

        .empty h3 {
            color: #503321;
            margin-bottom: 10px;
        }

        .empty p {
            font-size: 13px;
        }

        /* PAGINATION */
        .pagination {
            margin-top: 35px;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        .pagination svg {
            width: 18px;
        }

        .pagination span,
        .pagination a {
            font-size: 13px;
        }

        /* FOOTER */
        footer {
            background: #301b11;
            color: #e9d7c3;
            padding: 45px 0 22px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            padding-bottom: 30px;
        }

        .footer-brand h3 {
            letter-spacing: 2px;
            color: white;
            margin-bottom: 12px;
        }

        .footer-brand p {
            font-size: 12px;
            line-height: 1.8;
            max-width: 350px;
        }

        .footer-links h4 {
            color: white;
            margin-bottom: 13px;
        }

        .footer-links a {
            display: block;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .footer-links a:hover {
            color: #ffe58a;
        }

        .copyright {
            border-top: 1px solid rgba(255,255,255,0.15);
            padding-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #bd9876;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .filter-form {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .navbar {
                flex-wrap: wrap;
                padding-top: 15px;
                padding-bottom: 15px;
            }

            nav {
                gap: 15px;
                font-size: 12px;
            }

            .hero {
                padding: 25px 0;
            }

            .hero-box {
                padding: 35px 25px;
                border-radius: 17px;
            }

            .hero h1 {
                font-size: 27px;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 13px;
            }

            .product-image {
                height: 160px;
            }

            .product-info {
                padding: 13px;
            }

            .product-info h3 {
                font-size: 13px;
            }

            .price {
                font-size: 16px;
            }

            .footer-content {
                flex-direction: column;
            }
        }

        @media (max-width: 430px) {
            .container {
                padding: 0 15px;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .section-title {
                align-items: flex-start;
                flex-direction: column;
            }

            .logo-text strong {
                font-size: 17px;
            }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<header>
    <div class="container navbar">

        <a href="/" class="logo">
            <div class="logo-icon">S</div>

            <div class="logo-text">
                <strong>SEKENOVA</strong>
                <small>Every item deserves a second story</small>
            </div>
        </a>

        <nav>
            <a href="/">Beranda</a>
            <a href="{{ route('catalog.index') }}">Katalog</a>

            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}" class="nav-button">Daftar</a>
            @endauth
        </nav>

    </div>
</header>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="hero-box">

            <span class="hero-label">
                Marketplace Barang Bekas Berkualitas
            </span>

            <h1>
                Temukan Barang Favorit,
                <span class="hero-highlight">Mulai Cerita Baru.</span>
            </h1>

            <p>
                Belanja barang bekas berkualitas dengan harga bersahabat.
                Temukan pakaian, tas, sepatu, dan berbagai kebutuhan
                lainnya melalui SEKENOVA.
            </p>

        </div>
    </div>
</section>

<main class="container">

    {{-- FILTER --}}
    <section class="filter-box">

        <h2>Cari Barang Impianmu</h2>

        <p>
            Temukan barang sesuai kebutuhan dan keinginanmu.
        </p>

        <form
            method="GET"
            action="{{ route('catalog.index') }}"
            class="filter-form"
        >

            <input
                type="search"
                name="search"
                placeholder="Cari nama barang..."
                value="{{ $filters['search'] ?? '' }}"
            >

            <select name="category">
                <option value="">Semua Kategori</option>

                @foreach (
                    ['Elektronik', 'Fashion', 'Buku', 'Furnitur', 'Hobi', 'Lainnya']
                    as $category
                )
                    <option
                        value="{{ $category }}"
                        @selected(($filters['category'] ?? '') === $category)
                    >
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            <select name="condition">
                <option value="">Semua Kondisi</option>

                <option
                    value="seperti_baru"
                    @selected(($filters['condition'] ?? '') === 'seperti_baru')
                >
                    Seperti Baru
                </option>

                <option
                    value="baik"
                    @selected(($filters['condition'] ?? '') === 'baik')
                >
                    Baik
                </option>

                <option
                    value="cukup"
                    @selected(($filters['condition'] ?? '') === 'cukup')
                >
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

    {{-- DAFTAR PRODUK --}}
    <section class="section-title">

        <div>
            <h2>Koleksi Pilihan</h2>
            <p>Temukan barang berkualitas pilihanmu.</p>
        </div>

        <p>
            {{ $products->total() }} barang ditemukan
        </p>

    </section>

    @if ($products->count() > 0)

        <section class="product-grid">

            @foreach ($products as $product)

                <a
                    href="{{ route('catalog.show', $product) }}"
                    class="product-card"
                >

                    {{-- FOTO PRODUK --}}
                    <div class="product-image">

                        @if ($product->image)

                            <img
                                src="{{ filter_var($product->image, FILTER_VALIDATE_URL)
                                    ? $product->image
                                    : asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                            >

                        @else

                            <span>Foto belum tersedia</span>

                        @endif

                    </div>

                    {{-- INFORMASI PRODUK --}}
                    <div class="product-info">

                        <div class="category">
                            {{ $product->category }}
                        </div>

                        <h3>
                            {{ $product->name }}
                        </h3>

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
                            Stok tersedia: {{ $product->stock }}
                        </p>

                        <span class="detail-label">
                            Lihat Detail →
                        </span>

                    </div>

                </a>

            @endforeach

        </section>

        {{-- PAGINATION --}}
        <div class="pagination">
            {{ $products->links() }}
        </div>

    @else

        {{-- PRODUK TIDAK DITEMUKAN --}}
        <div class="empty">

            <h3>Belum Ada Barang Ditemukan</h3>

            <p>
                Coba gunakan kata kunci atau filter lainnya.
            </p>

            <a
                href="{{ route('catalog.index') }}"
                class="btn"
                style="display:inline-block;margin-top:20px;"
            >
                Lihat Semua Barang
            </a>

        </div>

    @endif

</main>

{{-- FOOTER --}}
<footer>
    <div class="container">

        <div class="footer-content">

            <div class="footer-brand">
                <h3>SEKENOVA</h3>

                <p>
                    Marketplace barang bekas yang memberikan
                    kesempatan baru bagi setiap barang.
                    Every item deserves a second story.
                </p>
            </div>

            <div class="footer-links">

                <h4>Navigasi</h4>

                <a href="/">Beranda</a>
                <a href="{{ route('catalog.index') }}">Katalog</a>

                @guest
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endguest

            </div>

        </div>

        <div class="copyright">
            © {{ date('Y') }} SEKENOVA. Every item deserves a second story.
        </div>

    </div>
</footer>

</body>
</html>