@extends('layouts.main')

@section('content')

<style>
/* ===== VARIABLES & GLOBAL ===== */
:root {
    --green-primary: #059669;
    --green-dark: #047857;
    --green-light: #10b981;
    --green-soft: #d1fae5;
    --green-bg: #ecfdf5;
    --gray-dark: #1f2937;
    --gray-light: #6b7280;
}

/* ===== HERO SECTION INTERAKTIF ===== */
.hero {
    text-align: center;
    padding: 60px 20px 40px;
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);
    border-radius: 0 0 60px 60px;
    margin-bottom: 50px;
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: '🎓';
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 80px;
    opacity: 0.15;
    animation: floatLeft 4s ease-in-out infinite;
}

.hero::after {
    content: '📚';
    position: absolute;
    bottom: 20px;
    right: 20px;
    font-size: 80px;
    opacity: 0.15;
    animation: floatRight 4s ease-in-out infinite;
}

@keyframes floatLeft {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-10px, -10px) rotate(-5deg); }
}

@keyframes floatRight {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(10px, -10px) rotate(5deg); }
}

.hero h1 {
    font-weight: 800;
    font-size: 3rem;
    background: linear-gradient(135deg, #065f46, #059669, #10b981);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 15px;
    animation: titleGlow 2s ease-in-out infinite;
}

@keyframes titleGlow {
    0%, 100% { text-shadow: 0 0 0px rgba(5, 150, 105, 0); }
    50% { text-shadow: 0 0 20px rgba(5, 150, 105, 0.3); }
}

.hero p {
    font-size: 1.2rem;
    color: #047857;
    font-weight: 500;
    animation: slideUp 0.6s ease;
}

/* ===== STATS COUNTER ===== */
.stats-container {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
    background: white;
    padding: 15px 25px;
    border-radius: 60px;
    box-shadow: 0 5px 20px rgba(5, 150, 105, 0.15);
    transition: all 0.3s ease;
    cursor: pointer;
}

.stat-item:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 30px rgba(5, 150, 105, 0.25);
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #059669;
    display: block;
}

.stat-label {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 600;
}

/* ===== PRODI CARD MODERN ===== */
.prodi-card {
    background: white;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    height: 100%;
    position: relative;
    cursor: pointer;
}

.prodi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
    transition: left 0.5s ease;
    z-index: 1;
}

.prodi-card:hover::before {
    left: 100%;
}

.prodi-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 25px 45px rgba(5, 150, 105, 0.2);
}

.prodi-img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.prodi-card:hover .prodi-img {
    transform: scale(1.05);
}

/* Badge akreditasi dengan animasi */
.badge {
    padding: 8px 18px;
    border-radius: 40px;
    font-weight: 700;
    transition: all 0.3s ease;
}

.badge.bg-success {
    background: linear-gradient(135deg, #059669, #10b981) !important;
    animation: badgePulse 2s ease infinite;
}

@keyframes badgePulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(5, 150, 105, 0); }
}

/* Tombol detail */
.btn-success {
    background: linear-gradient(135deg, #059669, #047857);
    border: none;
    padding: 12px 28px;
    border-radius: 60px;
    font-weight: 700;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-success::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-success:hover::before {
    width: 300px;
    height: 300px;
}

.btn-success:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.4);
    background: linear-gradient(135deg, #047857, #065f46);
}

.btn-success:active {
    transform: translateY(0);
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

/* Stagger delay untuk cards */
.prodi-card {
    transition-delay: calc(var(--index, 0) * 0.1s);
}

/* ===== SEARCH & FILTER ===== */
.search-box {
    max-width: 400px;
    margin: 0 auto 40px;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 14px 20px 14px 50px;
    border-radius: 60px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.search-box input:focus {
    border-color: #059669;
    box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    outline: none;
}

.search-box i {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1.2rem;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h4 {
    color: #4b5563;
    margin-bottom: 10px;
}

/* ===== TOAST NOTIFICATION ===== */
.green-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: linear-gradient(135deg, #059669, #047857);
    color: white;
    padding: 14px 24px;
    border-radius: 60px;
    z-index: 9999;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
    pointer-events: none;
}

.green-toast.show {
    opacity: 1;
    transform: translateY(0);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .hero h1 {
        font-size: 2rem;
    }
    .hero p {
        font-size: 1rem;
    }
    .stats-container {
        gap: 15px;
    }
    .stat-item {
        padding: 10px 18px;
    }
    .stat-number {
        font-size: 1.3rem;
    }
    .green-toast {
        bottom: 20px;
        right: 20px;
        left: 20px;
        justify-content: center;
    }
}
</style>

<!-- HERO SECTION INTERAKTIF -->
<div class="hero fade-up">
    <h1>
        <i class="fas fa-graduation-cap me-2"></i>
        Program Studi AMIK Taruna
    </h1>
    <p>
        <i class="fas fa-star me-1" style="color: #fbbf24;"></i>
        Pilih program studi favoritmu
        <i class="fas fa-star ms-1" style="color: #fbbf24;"></i>
    </p>
    

<!-- SEARCH BOX -->
<div class="search-box fade-up">
    <i class="fas fa-search"></i>
    <input type="text" id="searchInput" placeholder="Cari program studi..." autocomplete="off">
</div>

<!-- PROGRAM STUDI GRID -->
<div class="row g-4" id="programsContainer">
    @foreach($programs as $index => $program)
    <div class="col-lg-4 col-md-6 fade-up program-item" data-name="{{ strtolower($program->nama_prodi) }}" data-tagline="{{ strtolower($program->tagline ?? '') }}" style="transition-delay: {{ $index * 0.05 }}s">
        <div class="prodi-card" onclick="goToDetail('{{ $program->slug }}')">
            @if($program->thumbnail)
            <img src="{{ asset('uploads/program_studi/'.$program->thumbnail) }}" class="prodi-img" alt="{{ $program->nama_prodi }}">
            @else
            <div class="prodi-img d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                <i class="fas fa-graduation-cap" style="font-size: 4rem; color: #059669; opacity: 0.5;"></i>
            </div>
            @endif
            <div class="p-4">
                <h3 class="fw-bold" style="color: #065f46;">
                    {{ $program->nama_prodi }}
                </h3>
                <p class="text-muted" style="min-height: 50px;">
                    <i class="fas fa-quote-left me-1" style="font-size: 0.7rem;"></i>
                    {{ $program->tagline ?? 'Program studi unggulan dengan kualitas terbaik' }}
                </p>
                <div class="mb-3">
                    <span class="badge bg-success">
                        <i class="fas fa-medal me-1"></i>
                        {{ $program->akreditasi ?? 'Akreditasi B' }}
                    </span>
                </div>
                <p style="color: #6b7280; min-height: 80px;">
                    {{ Str::limit($program->deskripsi, 120) }}
                </p>
                <a href="{{ route('akademik.show', $program->slug) }}" class="btn btn-success rounded-pill w-100">
                    <i class="fas fa-arrow-right me-2"></i>
                    Lihat Detail
                    <i class="fas fa-external-link-alt ms-2" style="font-size: 0.8rem;"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- EMPTY STATE (hidden by default) -->
<div id="emptyState" class="empty-state fade-up" style="display: none;">
    <i class="fas fa-search"></i>
    <h4>Tidak ada program studi ditemukan</h4>
    <p class="text-muted">Coba gunakan kata kunci lain</p>
    <button class="btn btn-success rounded-pill" onclick="resetSearch()">
        <i class="fas fa-refresh me-2"></i>
        Reset Pencarian
    </button>
</div>

<!-- TOAST NOTIFICATION -->
<div id="greenToast" class="green-toast">
    <i class="fas fa-leaf"></i>
    <span id="toastMessage">Selamat datang!</span>
</div>

<script>
// ===== INTERAKTIVITAS LENGKAP =====

// 1. Toast Notification System
function showGreenMessage(message, duration = 2000) {
    const toast = document.getElementById('greenToast');
    const toastMsg = document.getElementById('toastMessage');
    
    toastMsg.innerHTML = message;
    toast.classList.add('show');
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, duration);
}

// 2. Counter Animation
function animateCounter(elementId, target, suffix = '') {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    let current = 0;
    const increment = target / 50;
    const updateCounter = () => {
        current += increment;
        if (current < target) {
            element.textContent = Math.floor(current) + suffix;
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target + suffix;
        }
    };
    updateCounter();
}

// 3. Scroll Reveal Animation
const fadeElements = document.querySelectorAll('.fade-up');
const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            fadeObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

fadeElements.forEach(el => fadeObserver.observe(el));

// 4. Search / Filter Function
const searchInput = document.getElementById('searchInput');
const programItems = document.querySelectorAll('.program-item');
const programsContainer = document.getElementById('programsContainer');
const emptyState = document.getElementById('emptyState');

function filterPrograms() {
    const keyword = searchInput.value.toLowerCase().trim();
    let visibleCount = 0;
    
    programItems.forEach(item => {
        const name = item.getAttribute('data-name') || '';
        const tagline = item.getAttribute('data-tagline') || '';
        
        if (keyword === '' || name.includes(keyword) || tagline.includes(keyword)) {
            item.style.display = 'block';
            visibleCount++;
            // Add animation
            item.style.animation = 'none';
            setTimeout(() => {
                item.style.animation = '';
            }, 10);
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide empty state
    if (visibleCount === 0 && keyword !== '') {
        emptyState.style.display = 'block';
        programsContainer.style.display = 'none';
    } else {
        emptyState.style.display = 'none';
        programsContainer.style.display = 'flex';
    }
    
    // Show feedback
    if (keyword !== '') {
        showGreenMessage(`🔍 Menemukan ${visibleCount} program studi untuk "${keyword}"`);
    }
}

function resetSearch() {
    searchInput.value = '';
    filterPrograms();
    showGreenMessage('✨ Pencarian direset, semua program studi ditampilkan');
}

searchInput.addEventListener('input', filterPrograms);

// 5. Card Click Handler
function goToDetail(slug) {
    showGreenMessage('📖 Mengarahkan ke halaman detail...');
    setTimeout(() => {
        window.location.href = "{{ url('akademik') }}/" + slug;
    }, 200);
}

// 6. Ripple Effect on Cards
document.querySelectorAll('.prodi-card').forEach(card => {
    card.addEventListener('click', function(e) {
        // Prevent if clicking on the button
        if (e.target.closest('.btn')) return;
        
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const ripple = document.createElement('span');
        ripple.style.position = 'absolute';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.style.width = '0';
        ripple.style.height = '0';
        ripple.style.borderRadius = '50%';
        ripple.style.backgroundColor = 'rgba(5, 150, 105, 0.3)';
        ripple.style.transform = 'translate(-50%, -50%)';
        ripple.style.transition = 'width 0.5s, height 0.5s, opacity 0.5s';
        ripple.style.pointerEvents = 'none';
        ripple.style.zIndex = '10';
        
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.style.width = '300px';
            ripple.style.height = '300px';
            ripple.style.opacity = '0';
        }, 10);
        
        setTimeout(() => {
            ripple.remove();
        }, 500);
    });
});

// 7. Parallax effect on hero
window.addEventListener('scroll', () => {
    const hero = document.querySelector('.hero');
    const scrolled = window.pageYOffset;
    if (hero && scrolled < 500) {
        hero.style.transform = `translateY(${scrolled * 0.15}px)`;
    }
});

// 8. Tooltip on stat items
document.querySelectorAll('.stat-item').forEach(item => {
    item.setAttribute('data-tooltip', 'Klik untuk info lebih lanjut');
});

// 9. Initialize animations on load
window.addEventListener('load', () => {
    // Counter animations
    const totalPrograms = {{ $programs->count() }};
    animateCounter('totalPrograms', totalPrograms);
    animateCounter('totalAkreditasi', totalPrograms);
    animateCounter('totalAlumni', 2500, '+');
    
    // Welcome toast
    setTimeout(() => {
        showGreenMessage('🎓 Selamat datang di AMIK Taruna! Temukan program studi terbaikmu');
    }, 500);
    
    // Add index delay for cards
    document.querySelectorAll('.program-item').forEach((item, idx) => {
        item.style.setProperty('--index', idx);
    });
});

// 10. Hover sound effect simulation (visual only)
document.querySelectorAll('.prodi-card .btn').forEach(btn => {
    btn.addEventListener('mouseenter', () => {
        btn.style.transform = 'scale(1.02)';
    });
    btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'scale(1)';
    });
});

// 11. Keyboard shortcut: ESC to reset search
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        resetSearch();
        searchInput.blur();
    }
});

// 12. Copy program name on double click card title
document.querySelectorAll('.prodi-card h3').forEach(title => {
    title.addEventListener('dblclick', (e) => {
        e.stopPropagation();
        const programName = title.innerText;
        navigator.clipboard.writeText(programName).then(() => {
            showGreenMessage(`📋 "${programName}" berhasil disalin!`);
        });
    });
});
</script>

<style>
/* Additional styles for better interaction */
.prodi-card {
    cursor: pointer;
}

.prodi-card .btn {
    cursor: pointer;
    position: relative;
    z-index: 2;
}

.stat-item {
    cursor: pointer;
    transition: all 0.3s ease;
}

.stat-item:active {
    transform: scale(0.95);
}

.search-box input {
    transition: all 0.3s ease;
}

#searchInput:focus {
    border-color: #059669;
    box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
}

/* Smooth transitions */
.program-item {
    transition: all 0.3s ease;
}

/* Tooltip style */
[data-tooltip] {
    position: relative;
}

[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #1f2937;
    color: white;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 0.75rem;
    white-space: nowrap;
    z-index: 100;
    margin-bottom: 8px;
}
</style>

@endsection