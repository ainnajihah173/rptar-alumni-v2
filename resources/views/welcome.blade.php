<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Portal RPTAR Alumni</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link rel="shortcut icon" href="{{ asset('assets/images/cuba.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        /* Event Section Styling */
        .events .event-item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Ensure all cards take full height */
        }

        .events .event-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .events .event-image {
            position: relative;
            overflow: hidden;
            flex: 1;
            /* Allow image to take remaining space */
        }

        .events .event-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .events .event-item:hover .event-image img {
            transform: scale(1.1);
        }

        .events .event-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .events .event-item:hover .event-overlay {
            opacity: 1;
        }

        .events .cta-btn {
            background: #ff4757;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .events .cta-btn:hover {
            background: #ff6b81;
        }

        .events .event-content {
            padding: 20px;
            flex: 1;
            /* Allow content to take remaining space */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* Space out content evenly */
        }

        .events .event-content h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .events .event-content .description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            flex: 1;
            /* Allow description to grow and push details to the bottom */
        }

        .events .event-details {
            font-size: 0.9rem;
            color: #555;
        }

        .events .event-details i {
            margin-right: 8px;
            color: #ff4757;
        }

        /* Featured Event Styling */
        .events .event-item.featured {
            border: 2px solid #ff4757;
        }

        /* Ayat Quran Styling */
        .ayat-quraan {
            /* background: rgba(0, 0, 0, 0.5); */
            /* Semi-transparent background for better readability */
            padding: 20px;
            border-radius: 10px;
            /* margin-top: 20px; */
            max-width: 800px;
            /* Adjust width as needed */
            animation: fadeIn 2s ease-in-out;
            /* Smooth fade-in animation */
        }

        .translation {
            font-size: 1rem;
            color: #fff;
            font-style: italic;
            line-height: 1.6;
        }

        /* Animation for Ayat Quran */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Donation Section Styling */
        .donation-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Ensure all cards have the same height */
        }

        .donation-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .donation-image {
            height: 200px;
            /* Fixed height for images */
            overflow: hidden;
        }

        .donation-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Ensure images cover the container */
            transition: transform 0.3s ease;
        }

        .donation-card:hover .donation-image img {
            transform: scale(1.1);
            /* Zoom effect on hover */
        }

        .donation-content {
            padding: 20px;
            flex: 1;
            /* Allow content to take remaining space */
            display: flex;
            flex-direction: column;
        }

        .donation-content h3 {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #333;
        }

        .donation-content .description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            flex: 1;
            /* Allow description to grow and push details to the bottom */
        }

        .donation-details {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 15px;
        }

        .donation-details i {
            margin-right: 8px;
            color: #ff4757;
            /* Icon color */
        }

        .donation-button {
            text-align: center;
            /* Center the button */
        }

        .cta-btn {
            background: #ff4757;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            /* Ensure button alignment */
        }

        .cta-btn:hover {
            background: #ff6b81;
        }

        /* Featured Donation Card */
        .donation-card.featured {
            border: 2px solid #ff4757;
        }
    </style>

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!--<img src="assets/images/RP.png" alt="">-->
                <h1 class="sitename text-danger">RPTAR Alumni</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.html#hero" class="active">Utama</a></li>
                    <li><a href="index.html#about">Tentang Kami</a></li>
                    <li><a href="index.html#events">Acara</a></li>
                    <li><a href="index.html#news">Berita</a></li>
                    <li><a href="index.html#donations">Derma</a></li>
                    <li><a href="index.html#contact">Hubungi Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted bg-danger" href="{{ route('login') }}">Log Masuk</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h1 data-aos="fade-up" class="text-white" style="font-size: 3.0rem;">
                        Selamat Datang ke <span class="text-danger">RPTAR Alumni</span>
                    </h1>
                    </h1>
                    <p data-aos="fade-up" data-aos-delay="100" class="text-white" style="opacity: 0.4;">
                        Portal alumni untuk Rumah Penyayang Tun Abdul Razak<br>
                    </p>

                    <!-- Ayat Quran Section -->
                    <div class="ayat-quraan" data-aos="fade-up" data-aos-delay="200">
                        <p class="translation mb-3" style="font-size: 1rem; color: #fff; font-style: italic;">
                            “Barangsiapa yang memelihara anak yatim dan memberinya makan dan minum, nescaya Allah
                            akan
                            memasukkannya ke dalam syurga, kecuali jika dia melakukan dosa yang tidak dapat
                            diampuni.”
                            <br>(Riwayat al-Tirmidzi, no. 1917)
                        </p>
                        <a href="{{ route('login') }}" class="btn-get-started mb-2">Derma Sekarang</a>
                    </div>
                </div>

            </div>
            <div class="hero-bg">
                <img src="{{ asset('assets/images/slide3.jpg') }}" alt="">
            </div>
        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container">
                <div class="row gy-4">
                    <!-- About Content -->
                    <div class="col-lg-7 content" data-aos="fade-up" data-aos-delay="100">
                        <p class="who-we-are">Sejarah Kami</p>
                        <h3>Rumah Penyayang Tun Abdul Razak (RPTAR)</h3>
                        <p class="fst-italic">
                            Rumah Penyayang Tun Abdul Razak dibina pada tahun 2004 dan mula beroperasi pada
                            Januari 2005. Dibangun oleh Yayasan Othman bersama Yayasan Rahah di Pekan, Pahang, dengan
                            kos RM 2.5 juta.
                        </p>
                        <p>
                            Rumah ini menampung sekitar 100 anak yatim dan miskin dari kawasan Parlimen Pekan.
                            Fasilitasnya termasuk asrama, dewan serbaguna, surau, dewan makan, bilik televisyen, pusat
                            sumber, dan padang bola.
                        </p>
                        <ul>
                            <li><i class="bi bi-check-circle"></i> <span>Semua keperluan anak-anak ditanggung
                                    sepenuhnya, termasuk pakaian, makanan, dan pendidikan.</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Anak-anak boleh tinggal sehingga tamat
                                    pendidikan menengah (SPM/STPM).</span></li>
                            <li><i class="bi bi-check-circle"></i> <span>Purata umur penghuni adalah antara 8 hingga 19
                                    tahun.</span></li>
                        </ul>
                    </div>

                    <!-- About Images -->
                    <div class="col-lg-5 about-images" data-aos="fade-up" data-aos-delay="200">
                        <div class="row gy-4">
                            <div class="col-lg-6">
                                <div class="row gy-4">
                                    <div class="col-lg-12">
                                        <img src="assets/images/rptar.jpg" class="img-fluid"
                                            alt="Asrama Rumah Penyayang Tun Abdul Razak">
                                    </div>
                                    <div class="col-lg-12">
                                        <img src="assets/images/rptar1.jpg" class="img-fluid"
                                            alt="Dewan Serbaguna RPTAR">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row gy-4">
                                    <div class="col-lg-12">
                                        <img src="assets/images/rptar2.jpg" class="img-fluid"
                                            alt="Aktiviti Anak-anak di RPTAR">
                                    </div>
                                    <div class="col-lg-12">
                                        <img src="assets/images/rptar3.jpg" class="img-fluid"
                                            alt="Padang Bola RPTAR">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /About Section -->

        <!-- Donation Section -->
        <section id="donations" class="pricing section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Sokong Inisiatif Kami</h2>
                <p>Sumbangan anda membuat perubahan. Mari bersama-sama menyokong inisiatif ini.</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    @foreach ($donations as $donation)
                        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="donation-card">
                                <!-- Donation Image -->
                                <div class="donation-image">
                                    <img src="{{ asset('storage/' . $donation->image_path) }}"
                                        alt="{{ $donation->title }}" class="img-fluid">
                                </div>
                                <!-- Donation Content -->
                                <div class="donation-content">
                                    <h3>{{ $donation->title }}</h3>
                                    <p class="description">{{ $donation->description }}</p>
                                    <div class="donation-details">
                                        <p><i class="bi bi-cash-stack"></i> Jumlah Sasaran:
                                            RM{{ number_format($donation->target_amount, 2) }}</p>
                                            <p><i class="bi bi-cash"></i> Jumlah Kutipan:
                                                RM{{ number_format($donation->current_amount, 2) }}</p>
                                        <p><i class="bi bi-calendar-check"></i> Tarikh Tutup:
                                            @php
                                            $startDate = \Carbon\Carbon::parse($donation->start_date);
                                            $endDate = \Carbon\Carbon::parse($donation->end_date);
                                        @endphp
                                        {{ $startDate->format('d M Y') }} -
                                        {{ $endDate->format('d M Y') }}</p>
                                    </div>
                                    <!-- Donation Button -->
                                    <div class="donation-button">
                                        <a href="{{ route('login') }}" class="cta-btn">Derma Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Donation Item -->
                    @endforeach
                </div>
            </div>
        </section><!-- /Donation Section -->

        <!-- Event Section -->
        <section id="events" class="events section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Acara Akan Datang</h2>
                <p>Sertai acara menarik kami dan kekal berhubung dengan RPTAR.</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    @foreach ($events as $event)
                        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="event-item {{ $event->featured ? 'featured' : '' }}">
                                <!-- Event Image -->
                                <div class="event-image">
                                    <img src="{{ asset('storage/' . $event->image_path) }}"
                                        alt="{{ $event->name }}" class="img-fluid">
                                    <div class="event-overlay">
                                        <a href="{{ route('login') }}" class="cta-btn background-danger">Daftar
                                            Sekarang</a>
                                    </div>
                                </div>
                                <div class="event-content">
                                    <h3>{{ $event->name }}</h3>
                                    <p class="description">{{ $event->description }}</p>
                                    <div class="event-details">
                                        <p><i class="bi bi-calendar-week-fill"></i>
                                            @if ($event->start_date == $event->end_date)
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} -
                                                {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                                            @endif
                                        </p>
                                        <p><i class="bi bi-clock-fill"></i>
                                            {{ date('h:i A', strtotime($event->start_time)) }} -
                                            {{ $event->end_time ? date('h:i A', strtotime($event->end_time)) : 'TBD' }}
                                        </p>
                                        <p><i class="bi bi-geo-alt-fill"></i> {{ $event->location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Event Item -->
                    @endforeach

                </div>
            </div>

        </section><!-- /Event Section -->

        <!-- News Section -->
        <section id="news" class="services section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Berita</h2>
                <p>Kekal terkini dengan berita dan cerita dari kami.</p>
            </div>

            <div class="container">
                <div class="row g-5">
                    @foreach ($news as $newsItem)
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-item item-cyan position-relative">
                                <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}"
                                    class="img-fluid p-3" style="width: 40%; height: 100px; object-fit: cover;">
                                <div>
                                    <h3>{{ $newsItem->title }}</h3>
                                    <p>{{ Str::limit($newsItem->content, 100) }}</p>
                                    <a href="{{ route('login') }}" class="read-more stretched-link">Baca Lagi <i
                                            class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Hubungi Kami</h2>
                <p>Hubungi kami untuk sebarang pertanyaan atau bantuan</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center"
                            data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Alamat</h3>
                            <p>Lot 324, Kampung Ulu Parit, 26600 Pekan, Pahang</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center"
                            data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone"></i>
                            <h3>Hubungi Kami</h3>
                            <p>+609-4228050</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="info-item d-flex flex-column justify-content-center align-items-center"
                            data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-globe2"></i>
                            <h3>Blogspot Kami</h3>
                            <p>https://rumah-penyayang.blogspot.com/</p> <!-- You can change the email if needed -->
                        </div>
                    </div><!-- End Info Item -->

                </div><!-- End Row -->

                <div class="row gy-4 mt-1">
                    <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
                        <!-- You can update the map link to Rumah Penyayang's location -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15930.013202817157!2d103.3837851!3d3.4700457!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cf5077646451bf%3A0xdd69afade6d0fa4a!2sRumah%20Penyayang%20Tun%20Abdul%20Razak!5e0!3m2!1sen!2smy!4v1732824146976!5m2!1sen!2smy"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div><!-- End Google Maps -->

                </div><!-- End Row -->

            </div><!-- End Container -->

        </section><!-- /Contact Section -->


    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container copyright text-center mt-4">
            <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">RPTAR Alumni</strong><span>Semua Hak
                    Terpelihara</span></p>
        </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
