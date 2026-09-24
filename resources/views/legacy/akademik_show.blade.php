@extends('layouts.main')

@section('content')

<style>
/* ===== VARIABLES & RESET ===== */
:root {
    --green-primary: #059669;
    --green-dark: #047857;
    --green-light: #10b981;
    --green-soft: #d1fae5;
    --green-bg: #ecfdf5;
    --gray-dark: #1f2937;
    --gray-light: #6b7280;
}

/* ===== HERO SECTION ===== */
.hero-prodi {
    background: linear-gradient(135deg, #059669, #065f46, #047857);
    padding: 80px 60px;
    border-radius: 40px;
    color: white;
    margin-bottom: 60px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(5, 150, 105, 0.3);
}

.hero-prodi::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -20%;
    width: 80%;
    height: 150%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-20px, -20px) rotate(5deg); }
}

.hero-prodi::after {
    content: '🎓';
    position: absolute;
    bottom: 20px;
    right: 30px;
    font-size: 120px;
    opacity: 0.1;
    animation: bounce 3s ease infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

.hero-prodi h1 {
    font-weight: 800;
    font-size: 3.5rem;
    margin-bottom: 20px;
    animation: slideUp 0.6s ease;
    position: relative;
    display: inline-block;
}

.hero-prodi h1::before {
    content: '📖';
    font-size: 2rem;
    margin-right: 15px;
    animation: wave 1.5s ease infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(15deg); }
    75% { transform: rotate(-10deg); }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-prodi p {
    font-size: 1.2rem;
    opacity: 0.95;
    animation: slideUp 0.6s ease 0.2s both;
    max-width: 80%;
}

/* ===== CARDS MODERN ===== */
.card-modern {
    border: none;
    border-radius: 28px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 35px;
    transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    background: white;
    position: relative;
}

.card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 45px rgba(5, 150, 105, 0.15);
}

.section-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #065f46;
    margin-bottom: 30px;
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 12px;
}

.section-title i {
    font-size: 2rem;
    color: #059669;
    animation: pulse 2s ease infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -12px;
    left: 0;
    width: 70px;
    height: 4px;
    background: linear-gradient(90deg, #059669, #34d399);
    border-radius: 4px;
    transition: width 0.4s ease;
}

.card-modern:hover .section-title::after {
    width: 120px;
}

/* ===== FASILITAS CARD ===== */
.fasilitas-card {
    background: linear-gradient(135deg, #ffffff, #f0fdf4);
    padding: 30px 20px;
    border-radius: 24px;
    box-shadow: 0 8px 20px rgba(5, 150, 105, 0.08);
    height: 100%;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    cursor: pointer;
    border: 1px solid rgba(5, 150, 105, 0.1);
    position: relative;
    overflow: hidden;
}

.fasilitas-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
    transition: left 0.6s ease;
}

.fasilitas-card:hover::before {
    left: 100%;
}

.fasilitas-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 35px rgba(5, 150, 105, 0.2);
    border-color: #059669;
}

.fasilitas-icon {
    font-size: 2.5rem;
    color: #059669;
    margin-bottom: 18px;
    transition: all 0.3s ease;
    display: inline-block;
}

.fasilitas-card:hover .fasilitas-icon {
    transform: scale(1.2) rotate(360deg);
    color: #065f46;
}

/* ===== FAQ ITEM ===== */
.faq-item {
    background: linear-gradient(135deg, #ffffff, #fafefc);
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 18px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    cursor: pointer;
    border-left: 4px solid #059669;
}

.faq-item:hover {
    transform: translateX(8px);
    box-shadow: 0 10px 30px rgba(5, 150, 105, 0.12);
    background: white;
}

.faq-item h6 {
    font-weight: 700;
    color: #065f46;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0;
}

.faq-item h6::after {
    content: '\f107';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #059669;
    transition: transform 0.3s ease;
    font-size: 1.2rem;
}

.faq-item.active h6::after {
    transform: rotate(180deg);
}

.faq-item p {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    margin: 0;
    color: #4b5563;
    line-height: 1.6;
}

.faq-item.active p {
    max-height: 300px;
    margin-top: 15px;
}

/* ===== DOWNLOAD BUTTON ===== */
.download-btn {
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    padding: 14px 24px;
    border-radius: 60px;
    text-decoration: none;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    margin: 8px 0;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.download-btn i {
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.download-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(5, 150, 105, 0.4);
    background: linear-gradient(135deg, #047857, #065f46);
}

.download-btn:hover i {
    transform: translateY(2px);
}

.download-btn:active {
    transform: translateY(0);
}

/* ===== STATS BADGE ===== */
.stats-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--green-soft);
    color: #065f46;
    padding: 6px 14px;
    border-radius: 40px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-left: 12px;
}

/* ===== ANIMATION CLASSES ===== */
.fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.7s ease;
}

.fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ===== TOAST NOTIFICATION ===== */
.green-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #065f46;
    color: white;
    padding: 14px 24px;
    border-radius: 60px;
    z-index: 9999;
    opacity: 0;
    transition: all 0.3s ease;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    background: rgba(5, 150, 105, 0.95);
}

.green-toast.show {
    opacity: 1;
    transform: translateY(-10px);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .hero-prodi {
        padding: 40px 25px;
    }
    .hero-prodi h1 {
        font-size: 2rem;
    }
    .hero-prodi p {
        max-width: 100%;
        font-size: 1rem;
    }
    .hero-prodi::after {
        font-size: 60px;
        bottom: 10px;
        right: 15px;
    }
    .section-title {
        font-size: 1.4rem;
    }
}
</style>

<!-- HERO SECTION -->
<div class="hero-prodi fade-up">
    <h1>
        {{ $program->nama_prodi }}
    </h1>
    <p>
        <i class="fas fa-quote-left me-2"></i>
        {{ $program->tagline }}
    </p>
</div>

<div class="row">
    <!-- KOLOM KIRI -->
    <div class="col-lg-8">
        <!-- DESKRIPSI -->
        <div class="card-modern p-4 fade-up">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Tentang Program Studi
            </h2>
            <p style="font-size: 1.05rem; line-height: 1.7; color: #374151;">
                {{ $program->deskripsi }}
            </p>
        </div>

        <!-- PROFIL LULUSAN -->
        <div class="card-modern p-4 fade-up">
            <h2 class="section-title">
                <i class="fas fa-users"></i>
                Profil Lulusan
                <span class="stats-badge">
                    <i class="fas fa-chart-line"></i>
                    {{ $program->profilLulusans->count() }} Kompetensi
                </span>
            </h2>
            <div class="row">
                @foreach($program->profilLulusans as $index => $profil)
                <div class="col-md-6 mb-4 fade-up" style="transition-delay: {{ $index * 0.1 }}s">
                    <div class="fasilitas-card" onclick="showGreenMessage('📌 {{ $profil->judul }}')">
                        <div class="fasilitas-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h5 class="fw-bold mb-3" style="color: #065f46;">
                            {{ $profil->judul }}
                        </h5>
                        <p style="color: #6b7280; font-size: 0.9rem;">
                            {{ $profil->deskripsi }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- FASILITAS -->
        <div class="card-modern p-4 fade-up">
            <h2 class="section-title">
                <i class="fas fa-building"></i>
                Fasilitas Prodi
                <span class="stats-badge">
                    <i class="fas fa-cube"></i>
                    {{ $program->fasilitas->count() }} Fasilitas
                </span>
            </h2>
            <div class="row">
                @foreach($program->fasilitas as $index => $f)
                <div class="col-md-4 mb-4 fade-up" style="transition-delay: {{ $index * 0.1 }}s">
                    <div class="fasilitas-card" onclick="showGreenMessage('🏫 {{ $f->nama }} - {{ $f->deskripsi }}')">
                        <div class="fasilitas-icon">
                            <i class="{{ $f->icon }}"></i>
                        </div>
                        <h5 style="color: #065f46; font-weight: 700; margin-top: 10px;">
                            {{ $f->nama }}
                        </h5>
                        <p style="color: #6b7280; font-size: 0.85rem; margin-top: 10px;">
                            {{ $f->deskripsi }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN -->
    <div class="col-lg-4">
        <!-- INFORMASI AKADEMIK -->
        <div class="card-modern p-4 fade-up">
            <h2 class="section-title">
                <i class="fas fa-calendar-alt"></i>
                Informasi Akademik
            </h2>
            <div class="d-grid gap-3">
                @if($program->kalender_akademik)
                <a href="{{ asset('uploads/'.$program->kalender_akademik) }}"
                   class="download-btn"
                   target="_blank"
                   onclick="showGreenMessage('📅 Mengunduh Kalender Akademik...')">
                    <i class="fas fa-calendar-check"></i>
                    Kalender Akademik
                    <i class="fas fa-download ms-auto"></i>
                </a>
                @endif

                @if($program->jadwal_semester)
                <a href="{{ asset('uploads/'.$program->jadwal_semester) }}"
                   class="download-btn"
                   target="_blank"
                   onclick="showGreenMessage('📖 Mengunduh Jadwal Semester...')">
                    <i class="fas fa-clock"></i>
                    Jadwal Semester
                    <i class="fas fa-download ms-auto"></i>
                </a>
                @endif
            </div>
        </div>

        <!-- FAQ -->
        <div class="card-modern p-4 fade-up">
            <h2 class="section-title">
                <i class="fas fa-question-circle"></i>
                FAQ
                <span class="stats-badge">
                    <i class="fas fa-comments"></i>
                    {{ $program->faqs->count() }} Pertanyaan
                </span>
            </h2>
            @foreach($program->faqs as $index => $faq)
            <div class="faq-item" onclick="this.classList.toggle('active')">
                <h6>
                    <i class="fas fa-question-circle me-2" style="color: #059669;"></i>
                    {{ $faq->pertanyaan }}
                </h6>
                <p>
                    <i class="fas fa-reply-all me-2" style="color: #10b981;"></i>
                    {{ $faq->jawaban }}
                </p>
            </div>
            @endforeach
        </div>

        <!-- MOTIVASI CARD -->
        <div class="card-modern p-4 fade-up" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
            <div style="text-align: center;">
                <i class="fas fa-gem" style="font-size: 2.5rem; color: #059669; margin-bottom: 15px;"></i>
                <h5 style="color: #065f46; font-weight: 800;">Siap Meraih Masa Depan?</h5>
                <p style="color: #047857; font-size: 0.9rem;">Bergabunglah dengan program studi unggulan kami</p>
                <div style="width: 60px; height: 3px; background: #059669; margin: 15px auto;"></div>
                <small style="color: #047857;">
                    <i class="fas fa-check-circle"></i> Akreditasi Unggul
                </small>
            </div>
        </div>
    </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="greenToast" class="green-toast">
    <i class="fas fa-leaf"></i>
    <span id="toastMessage"></span>
</div>

<script>
// ===== INTERAKTIVITAS =====

// Toast notification
function showGreenMessage(message) {
    const toast = document.getElementById('greenToast');
    const toastMsg = document.getElementById('toastMessage');
    
    toastMsg.textContent = message;
    toast.classList.add('show');
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2000);
}

// Scroll reveal animation
const fadeElements = document.querySelectorAll('.fade-up');

const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            fadeObserver.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -30px 0px'
});

fadeElements.forEach(element => {
    fadeObserver.observe(element);
});

// Hover sound effect (opsional - pake feedback visual)
document.querySelectorAll('.fasilitas-card, .download-btn').forEach(el => {
    el.addEventListener('click', function(e) {
        // Ripple effect
        let ripple = document.createElement('span');
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.backgroundColor = 'rgba(5, 150, 105, 0.3)';
        ripple.style.width = '0px';
        ripple.style.height = '0px';
        ripple.style.transform = 'translate(-50%, -50%)';
        ripple.style.pointerEvents = 'none';
        ripple.style.transition = 'width 0.5s, height 0.5s, opacity 0.5s';
        
        let rect = this.getBoundingClientRect();
        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;
        
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.style.position = 'absolute';
        
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.style.width = '200px';
            ripple.style.height = '200px';
            ripple.style.opacity = '0';
        }, 10);
        
        setTimeout(() => {
            ripple.remove();
        }, 500);
    });
});

// Hero parallax
window.addEventListener('scroll', () => {
    const hero = document.querySelector('.hero-prodi');
    const scrolled = window.pageYOffset;
    if (hero && scrolled < 600) {
        hero.style.transform = `translateY(${scrolled * 0.2}px)`;
    }
});

// Animasi angka statistik (jika ada)
function animateStats() {
    const stats = document.querySelectorAll('.stats-badge');
    stats.forEach(stat => {
        stat.style.transform = 'scale(1.05)';
        setTimeout(() => {
            stat.style.transform = 'scale(1)';
        }, 300);
    });
}

// Trigger saat load
window.addEventListener('load', () => {
    showGreenMessage('✨ Selamat datang di {{ $program->nama_prodi }} ✨');
    setTimeout(animateStats, 500);
});

// Double click copy untuk deskripsi
const descParagraph = document.querySelector('.card-modern p');
if (descParagraph) {
    descParagraph.addEventListener('dblclick', function() {
        const text = this.innerText;
        navigator.clipboard.writeText(text).then(() => {
            showGreenMessage('📋 Teks deskripsi berhasil disalin!');
        });
    });
}

// FAQ auto close others (opsional)
document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', function(e) {
        if(!this.classList.contains('active')) {
            document.querySelectorAll('.faq-item').forEach(faq => {
                if(faq !== this && faq.classList.contains('active')) {
                    faq.classList.remove('active');
                }
            });
        }
    });
});
</script>

@endsection