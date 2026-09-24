<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  currentPath: {
    type: String,
    default: '/'
  }
});

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activeDropdown = ref(null);
const mobileActiveGroup = ref(null);

watch(mobileMenuOpen, (isOpen) => {
  if (typeof document !== 'undefined') {
    document.body.style.overflow = isOpen ? 'hidden' : '';
  }
});

const handleScroll = () => {
  isScrolled.value = window.scrollY > 24;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true });
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

const toggleDropdown = (name) => {
  activeDropdown.value = activeDropdown.value === name ? null : name;
};

const closeDropdowns = () => {
  activeDropdown.value = null;
};

const toggleMobileGroup = (group) => {
  mobileActiveGroup.value = mobileActiveGroup.value === group ? null : group;
};

const isGroupActive = (group) => {
  if (!group || !group.items) return false;
  return group.items.some(item => {
    const cleanItemHref = item.href.split('#')[0];
    const cleanCurrent = props.currentPath.split('#')[0];
    return cleanCurrent === cleanItemHref || (cleanItemHref !== '/' && cleanCurrent.startsWith(cleanItemHref));
  });
};

const navGroups = [
  {
    label: 'Profil',
    id: 'profil',
    icon: 'fas fa-university',
    items: [
      { label: 'Tentang AMIK Taruna', href: '/tentang', desc: 'Sejarah, legalitas, dan komitmen mutu', icon: 'fas fa-info-circle' },
      { label: 'Visi & Misi', href: '/tentang#visi-misi', desc: 'Arah haluan dan target capaian kampus', icon: 'fas fa-bullseye' },
      { label: 'Pimpinan & Dosen', href: '/tentang#struktur', desc: 'Tenaga pendidik profesional dan pimpinan', icon: 'fas fa-chalkboard-teacher' },
      { label: 'Akreditasi Kampus', href: '/tentang#akreditasi', desc: 'Status akreditasi resmi institusi', icon: 'fas fa-award' },
    ]
  },
  {
    label: 'Akademik',
    id: 'akademik',
    icon: 'fas fa-graduation-cap',
    items: [
      { label: 'Program Studi', href: '/akademik', desc: 'Pilihan prodi vokasi teknologi informasi', icon: 'fas fa-laptop-code' },
      { label: 'Layanan Mahasiswa', href: '/mahasiswa', desc: 'Fasilitas dan administrasi sivitas', icon: 'fas fa-user-graduate' },
      { label: 'Tracer Study Alumni', href: '/alumni', desc: 'Jaringan dan rekam jejak lulusan', icon: 'fas fa-user-check' },
    ]
  },
  {
    label: 'Riset & Lembaga',
    id: 'riset',
    icon: 'fas fa-flask',
    items: [
      { label: 'LPPM', href: '/lppm', desc: 'Lembaga Penelitian & Pengabdian Masyarakat', icon: 'fas fa-microscope' },
      { label: 'PPM', href: '/ppm', desc: 'Pusat Penjaminan Mutu Internal', icon: 'fas fa-shield-alt' },
    ]
  },
  {
    label: 'Informasi',
    id: 'informasi',
    icon: 'fas fa-newspaper',
    items: [
      { label: 'Penerimaan Mahasiswa Baru (PMB)', href: '/pmb', desc: 'Informasi jalur seleksi & pendaftaran mahasiswa baru', icon: 'fas fa-user-plus' },
      { label: 'Berita & Agenda', href: '/berita', desc: 'Kabar kegiatan dan pengumuman resmi', icon: 'far fa-newspaper' },
      { label: 'Layanan PPKS (Kekerasan Seksual)', href: '/ppks', desc: 'Form pelaporan rahasia & warta edukasi PPKS', icon: 'fas fa-shield-alt' },
      { label: 'Kritik & Saran', href: '/kritik-saran', desc: 'Kanal aspirasi perbaikan layanan', icon: 'fas fa-comment-dots' },
    ]
  }
];
</script>

<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="[
      isScrolled
        ? 'bg-[#031d11]/90 backdrop-blur-md shadow-lg border-b border-emerald-500/20 py-3'
        : 'bg-[#031d11]/70 backdrop-blur-sm border-b border-emerald-500/10 py-3.5'
    ]"
    style="position: fixed !important; z-index: 9999 !important;"
    @mouseleave="closeDropdowns"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between">
        
        <!-- Brand / Logo -->
        <a href="/" class="flex items-center gap-3 group">
          <img
            v-if="setting?.logo"
            :src="'/uploads/' + setting.logo"
            :alt="setting?.nama_website || 'AMIK Taruna'"
            class="w-10 h-10 sm:w-11 sm:h-11 object-contain rounded-lg border border-emerald-500/30 p-1 bg-[#062a19]/80 shadow-sm"
            @error="(e) => e.target.style.display = 'none'"
          />
          <div class="flex flex-col">
            <span class="text-base sm:text-lg font-extrabold text-white tracking-tight group-hover:text-emerald-400 transition-colors">
              {{ setting?.nama_website || 'AMIK Taruna' }}
            </span>
            <span class="text-[11px] font-semibold text-emerald-400 uppercase tracking-wider hidden sm:block">
              Kampus Teknologi Digital
            </span>
          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-1.5" aria-label="Main Navigation">
          <a
            href="/"
            class="px-3.5 py-2 text-sm font-semibold rounded-lg transition-colors"
            :class="currentPath === '/' ? 'text-emerald-300 bg-emerald-950/70 border border-emerald-500/30' : 'text-slate-300 hover:text-emerald-300 hover:bg-emerald-950/40'"
          >
            Beranda
          </a>

          <!-- Dropdown Menus -->
          <div
            v-for="group in navGroups"
            :key="group.id"
            class="relative"
            @mouseenter="activeDropdown = group.id"
          >
            <button
              type="button"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-semibold rounded-lg transition-colors focus:outline-none"
              :class="[
                isGroupActive(group)
                  ? 'text-emerald-300 bg-emerald-950/70 border border-emerald-500/30 font-bold'
                  : 'text-slate-300 hover:text-emerald-300 hover:bg-emerald-950/40',
                { 'text-emerald-300 bg-emerald-950/40': activeDropdown === group.id && !isGroupActive(group) }
              ]"
              @click="toggleDropdown(group.id)"
            >
              <span>{{ group.label }}</span>
              <svg
                class="w-4 h-4 transition-transform duration-200"
                :class="{ 'rotate-180 text-emerald-400': activeDropdown === group.id }"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Popover Panel -->
            <transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 translate-y-1.5"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 translate-y-1.5"
            >
              <div
                v-if="activeDropdown === group.id"
                class="absolute left-0 mt-2 w-72 bg-[#062919]/95 backdrop-blur-xl rounded-xl shadow-2xl border border-emerald-500/25 p-2 z-50"
                style="position: absolute !important; z-index: 10000 !important;"
                @mouseleave="closeDropdowns"
              >
                <a
                  v-for="item in group.items"
                  :key="item.href"
                  :href="item.href"
                  class="block px-3.5 py-2.5 rounded-lg transition-colors group"
                  :class="currentPath === item.href || (item.href !== '/' && currentPath.startsWith(item.href.split('#')[0])) ? 'bg-emerald-900/60 text-emerald-300 font-bold border border-emerald-500/30' : 'hover:bg-emerald-950/60'"
                >
                  <p class="text-sm font-semibold transition-colors" :class="currentPath === item.href || (item.href !== '/' && currentPath.startsWith(item.href.split('#')[0])) ? 'text-emerald-300' : 'text-slate-200 group-hover:text-emerald-300'">
                    {{ item.label }}
                  </p>
                  <p class="text-xs text-slate-400 mt-0.5 leading-snug">
                    {{ item.desc }}
                  </p>
                </a>
              </div>
            </transition>
          </div>
        </nav>

        <!-- Right Action: Portal Sivitas / Login -->
        <div class="hidden lg:flex items-center gap-3">
          <a
            href="/login"
            class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-300 hover:text-white bg-emerald-950/60 hover:bg-emerald-900/80 rounded-lg transition-colors border border-emerald-500/30 shadow-xs"
            title="Portal Sivitas / Login Admin"
            aria-label="Portal Sivitas / Login Admin"
          >
            <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Portal Sivitas</span>
          </a>
        </div>

        <!-- Mobile Action & Hamburger Button -->
        <div class="flex items-center gap-2 lg:hidden">
          <a
            href="/login"
            class="p-2 text-slate-300 hover:text-white bg-emerald-950/60 rounded-lg border border-emerald-500/25"
            title="Portal Sivitas"
            aria-label="Portal Sivitas"
          >
            <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </a>
          <button
            type="button"
            class="p-2 rounded-lg text-slate-200 hover:bg-emerald-950/60 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-400 border border-emerald-500/20"
            :aria-expanded="mobileMenuOpen"
            aria-label="Toggle Menu"
            @click="mobileMenuOpen = !mobileMenuOpen"
          >
            <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

      </div>
    </div>
  </header>

  <!-- Teleport mobile drawer & bottom dock directly to document.body -->
  <Teleport to="body">
    <!-- Mobile Slide Drawer Backdrop -->
    <div
      v-if="mobileMenuOpen"
      class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9998] lg:hidden transition-opacity"
      @click="mobileMenuOpen = false"
    ></div>

    <!-- Mobile Slide-Over Drawer -->
    <transition
      enter-active-class="transition ease-out duration-300 transform"
      enter-from-class="-translate-x-full opacity-0"
      enter-to-class="translate-x-0 opacity-100"
      leave-active-class="transition ease-in duration-200 transform"
      leave-from-class="translate-x-0 opacity-100"
      leave-to-class="-translate-x-full opacity-0"
    >
      <aside
        v-if="mobileMenuOpen"
        class="fixed inset-y-0 left-0 w-80 max-w-[85vw] bg-[#041a10] shadow-2xl z-[10000] flex flex-col h-full lg:hidden border-r border-emerald-500/30 text-white"
      >
        <!-- Drawer Header -->
        <div class="h-16 px-4 border-b border-emerald-500/20 flex items-center justify-between bg-[#031d11] shrink-0">
          <div class="flex items-center gap-2.5">
            <img
              v-if="setting?.logo"
              :src="'/uploads/' + setting.logo"
              alt="Logo"
              class="w-8 h-8 object-contain rounded-md p-1 bg-emerald-950 border border-emerald-500/40 shadow-sm"
            />
            <div class="leading-tight">
              <span class="font-extrabold text-white text-sm block">
                {{ setting?.nama_website || 'AMIK Taruna' }}
              </span>
              <span class="text-[10px] text-emerald-400 font-semibold tracking-wider uppercase block">
                Kampus Digital
              </span>
            </div>
          </div>
          <button
            type="button"
            class="p-2 text-slate-400 hover:text-white rounded-lg hover:bg-emerald-950/60 transition active:scale-95"
            @click="mobileMenuOpen = false"
            aria-label="Tutup Menu"
          >
            <i class="fas fa-times text-base"></i>
          </button>
        </div>

        <!-- Drawer Body (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
          <!-- Quick Access Cards (Grid 2x2) -->
          <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 block px-1">
              Akses Cepat
            </span>
            <div class="grid grid-cols-2 gap-2">
              <a
                href="/pmb"
                class="flex items-center gap-2.5 p-2.5 rounded-xl bg-gradient-to-r from-emerald-950/80 to-emerald-900/60 border border-emerald-500/30 text-emerald-300 hover:text-white transition active:scale-98 group"
                @click="mobileMenuOpen = false"
              >
                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition shrink-0">
                  <i class="fas fa-user-plus text-xs"></i>
                </div>
                <div class="leading-tight overflow-hidden">
                  <span class="text-xs font-bold block text-white truncate">PMB Online</span>
                  <span class="text-[9px] text-emerald-400 block truncate">Pendaftaran</span>
                </div>
              </a>

              <a
                href="/akademik"
                class="flex items-center gap-2.5 p-2.5 rounded-xl bg-emerald-950/40 border border-emerald-500/20 text-slate-300 hover:text-white transition active:scale-98 group"
                @click="mobileMenuOpen = false"
              >
                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition shrink-0">
                  <i class="fas fa-graduation-cap text-xs"></i>
                </div>
                <div class="leading-tight overflow-hidden">
                  <span class="text-xs font-bold block text-white truncate">Prodi D3</span>
                  <span class="text-[9px] text-slate-400 block truncate">Akademik</span>
                </div>
              </a>

              <a
                href="/mahasiswa"
                class="flex items-center gap-2.5 p-2.5 rounded-xl bg-emerald-950/40 border border-emerald-500/20 text-slate-300 hover:text-white transition active:scale-98 group"
                @click="mobileMenuOpen = false"
              >
                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition shrink-0">
                  <i class="fas fa-user-graduate text-xs"></i>
                </div>
                <div class="leading-tight overflow-hidden">
                  <span class="text-xs font-bold block text-white truncate">Layanan</span>
                  <span class="text-[9px] text-slate-400 block truncate">Mahasiswa</span>
                </div>
              </a>

              <a
                href="/alumni"
                class="flex items-center gap-2.5 p-2.5 rounded-xl bg-emerald-950/40 border border-emerald-500/20 text-slate-300 hover:text-white transition active:scale-98 group"
                @click="mobileMenuOpen = false"
              >
                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition shrink-0">
                  <i class="fas fa-user-check text-xs"></i>
                </div>
                <div class="leading-tight overflow-hidden">
                  <span class="text-xs font-bold block text-white truncate">Alumni</span>
                  <span class="text-[9px] text-slate-400 block truncate">Tracer Study</span>
                </div>
              </a>
            </div>
          </div>

          <!-- Menu Navigation List -->
          <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2 block px-1">
              Menu Navigasi
            </span>

            <div class="space-y-1.5">
              <a
                href="/"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition font-semibold text-sm"
                :class="currentPath === '/' ? 'bg-emerald-900/60 text-emerald-300 border border-emerald-500/40 font-bold' : 'text-slate-200 hover:bg-emerald-950/60'"
                @click="mobileMenuOpen = false"
              >
                <i class="fas fa-home text-emerald-400 w-4 text-center"></i>
                <span>Beranda</span>
              </a>

              <div
                v-for="group in navGroups"
                :key="'mob-' + group.id"
                class="rounded-xl border border-emerald-500/15 overflow-hidden bg-black/20"
              >
                <button
                  type="button"
                  class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm font-semibold text-slate-200 hover:bg-emerald-950/60 transition"
                  @click="toggleMobileGroup(group.id)"
                >
                  <div class="flex items-center gap-2.5">
                    <i :class="group.icon" class="text-emerald-400 w-4 text-center text-xs"></i>
                    <span>{{ group.label }}</span>
                  </div>
                  <i
                    class="fas fa-chevron-down text-xs text-emerald-400/80 transition-transform duration-200"
                    :class="{ 'rotate-180 text-emerald-300': mobileActiveGroup === group.id }"
                  ></i>
                </button>

                <div
                  v-if="mobileActiveGroup === group.id"
                  class="px-2 py-1.5 bg-[#031d11]/60 space-y-1 border-t border-emerald-500/10"
                >
                  <a
                    v-for="item in group.items"
                    :key="'mob-item-' + item.href"
                    :href="item.href"
                    class="flex items-start gap-2.5 px-3 py-2 rounded-lg text-xs transition"
                    :class="currentPath === item.href || (item.href !== '/' && currentPath.startsWith(item.href.split('#')[0])) ? 'bg-emerald-900/50 text-emerald-300 font-bold border border-emerald-500/30' : 'text-slate-300 hover:text-emerald-300 hover:bg-emerald-950/50'"
                    @click="mobileMenuOpen = false"
                  >
                    <i :class="item.icon" class="text-emerald-400 mt-0.5 text-xs w-3.5 text-center shrink-0"></i>
                    <div>
                      <span class="block font-medium">{{ item.label }}</span>
                      <span class="block text-[10px] text-slate-400 leading-snug">{{ item.desc }}</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Drawer Footer: Portal Sivitas Login -->
        <div class="p-3.5 border-t border-emerald-500/20 bg-[#031d11] shrink-0">
          <a
            href="/login"
            class="w-full flex items-center justify-between p-3 rounded-xl bg-emerald-950/70 hover:bg-emerald-900/80 border border-emerald-500/30 text-white transition active:scale-98"
            @click="mobileMenuOpen = false"
          >
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 flex items-center justify-center text-xs shrink-0">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="leading-tight text-left">
                <span class="text-xs font-bold block text-white">Portal Sivitas</span>
                <span class="text-[10px] text-emerald-400 flex items-center gap-1.5">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                  Login Admin & Dosen
                </span>
              </div>
            </div>
            <i class="fas fa-arrow-right text-xs text-emerald-400"></i>
          </a>
        </div>
      </aside>
    </transition>

    <!-- MOBILE BOTTOM NAVIGATION DOCK (App-like, exactly like PLN Sengkang) -->
    <nav
      class="lg:hidden fixed bottom-0 left-0 right-0 z-[9990] bg-[#031d11]/95 backdrop-blur-xl border-t border-emerald-500/20 shadow-[0_-10px_30px_rgba(0,0,0,0.6)] px-2 py-1 flex items-center justify-around text-[10px]"
    >
      <!-- 1. Beranda -->
      <a
        href="/"
        class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-150 active:scale-95"
        :class="currentPath === '/' ? 'text-emerald-300 font-bold' : 'text-slate-400 hover:text-emerald-300'"
      >
        <i class="fas fa-home text-base mb-0.5"></i>
        <span>Beranda</span>
      </a>

      <!-- 2. Akademik -->
      <a
        href="/akademik"
        class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-150 active:scale-95"
        :class="currentPath.startsWith('/akademik') ? 'text-emerald-300 font-bold' : 'text-slate-400 hover:text-emerald-300'"
      >
        <i class="fas fa-graduation-cap text-base mb-0.5"></i>
        <span>Akademik</span>
      </a>

      <!-- 3. PMB (Elevated Floating Center Button) -->
      <a
        href="/pmb"
        class="flex flex-col items-center py-0.5 px-3 transition-all duration-150 active:scale-90 relative -top-3"
      >
        <div
          class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-transform"
          :class="currentPath.startsWith('/pmb')
            ? 'bg-emerald-400 text-[#031d11] ring-4 ring-emerald-500/30 shadow-emerald-500/40'
            : 'bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white shadow-emerald-500/30 border-2 border-[#031d11]'"
        >
          <i class="fas fa-user-graduate text-base"></i>
        </div>
        <span class="text-[10px] font-extrabold text-emerald-300 mt-0.5">PMB</span>
      </a>

      <!-- 4. Berita -->
      <a
        href="/berita"
        class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-150 active:scale-95"
        :class="currentPath.startsWith('/berita') ? 'text-emerald-300 font-bold' : 'text-slate-400 hover:text-emerald-300'"
      >
        <i class="far fa-newspaper text-base mb-0.5"></i>
        <span>Berita</span>
      </a>

      <!-- 5. Menu Drawer -->
      <button
        type="button"
        class="flex flex-col items-center py-1 px-2.5 rounded-xl transition-all duration-150 active:scale-95"
        :class="mobileMenuOpen ? 'text-emerald-300 font-bold' : 'text-slate-400 hover:text-emerald-300'"
        @click="mobileMenuOpen = !mobileMenuOpen"
        aria-label="Buka Menu"
      >
        <i class="fas fa-th-large text-base mb-0.5"></i>
        <span>Menu</span>
      </button>
    </nav>
  </Teleport>
</template>
