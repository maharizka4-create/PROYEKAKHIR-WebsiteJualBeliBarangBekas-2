<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $product->name }} - SEKENOVA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        .container {
            max-width: 1150px;
            margin: auto;
            padding: 0 24px;
        }

        header {
            background: white;
            border-bottom: 1px solid #eadfd3;
        }

        .navbar {
            min-height: 78px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #503321;
        }

        .logo-icon {
            background: #503321;
            color: white;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 20px;
            font-weight: 700;
        }

        .logo-text strong {
            display: block;
            font-size: 19px;
            letter-spacing: 2px;
        }

        .logo-text small {
            display: block;
            color: #98745b;
            font-size: 10px;
        }

        nav {
            display: flex;
            gap: 25px;
            align-items: center;
            font-size: 14px;
        }

        nav a:hover {
            color: #a77a52;
        }

        .breadcrumb {
            padding: 30px 0;
            font-size: 13px;
            color: #927c6b;
        }

        .breadcrumb a:hover {
            color: #503321;
        }

        .detail-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 45px;
            background: white;
            padding: 35px;
            border: 1px solid #eadfd3;
            border-radius: 20px;
            margin-bottom: 70px;
        }

        .product-image {
            background: #eee3d7;
            min-height: 400px;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #98745b;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            min-height: 400px;
            object-fit: contain;
        }

        .product-info {
            padding: 15px 5px;
        }

        .category {
            color: #98745b;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 30px;
            line-height: 1.4;
            margin-bottom: 20px;
        }

        .price {
            font-size: 30px;
            font-weight: 700;
            color: #503321;
            margin-bottom: 25px;
        }

        .info-list {
            border-top: 1px solid #eadfd3;
            border-bottom: 1px solid #eadfd3;
            padding: 20px 0;
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: #927c6b;
        }

        .info-value {
            font-weight: 600;
            text-align: right;
        }

        .description-title {
            font-size: 17px;
            margin-bottom: 12px;
        }

        .description {
            color: #806d5e;
            font-size: 13px;
            line-height: 1.9;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .back-button {
            display: inline-block;
            background: #503321;
            color: white;
            padding: 13px 23px;
            border-radius: 9px;
            margin-top: 30px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-button:hover {
            background: #704a32;
        }

        footer {
            background: #301b11;
            color: #e9d7c3;
            padding: 30px 20px;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 750px) {
            .detail-card {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 20px;
            }

            .product-image,
            .product-image img {
                min-height: 280px;
            }

            h1 {
                font-size: 24px;
            }

            .price {
                font-size: 25px;
            }

            .navbar {
                flex-wrap: wrap;
                padding: 15px 0;
                gap: 15px;
            }

            nav {
                gap: 15px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

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
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </nav>

    </div>
</header>

<main class="container">

    <div class="breadcrumb">
        <a href="/">Beranda</a>
        /
        <a href="{{ route('catalog.index') }}">Katalog</a>
        /
        <span>{{ $product->name }}</span>
    </div>

    <section class="detail-card">

        {{-- FOTO PRODUK --}}
        <div class="product-image">

            @if ($product->image)

                <img
                    src="{{ filter_var($product->image, FILTER_VALIDATE_URL)
                        ? $product->image
                        : asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
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

            <h1>{{ $product->name }}</h1>

            <div class="price">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <div class="info-list">

                <div class="info-row">
                    <span class="info-label">Kondisi Barang</span>

                    <span class="info-value">
                        {{ match($product->condition) {
                            'seperti_baru' => 'Seperti Baru',
                            'baik' => 'Baik',
                            'cukup' => 'Cukup',
                            default => $product->condition
                        } }}
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Stok Tersedia</span>

                    <span class="info-value">
                        {{ $product->stock }} unit
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Status Produk</span>

                    <span class="info-value">
                        Tersedia
                    </span>
                </div>

            </div>

            <h3 class="description-title">
                Deskripsi Barang
            </h3>

            <p class="description">
                {{ $product->description }}
            </p>

            <a href="{{ route('catalog.index') }}" class="back-button">
                ← Kembali ke Katalog
            </a>

        </div>

    </section>

</main>

<footer>
    © {{ date('Y') }} SEKENOVA. Every item deserves a second story.
</footer>

</body>
</html>