<script setup>
defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});
</script>

<template>
  <footer class="bg-brand-950 text-slate-300 pt-16 pb-12 border-t border-brand-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-white/10">
        
        <!-- Brand & Description -->
        <div class="lg:col-span-4">
          <div class="flex items-center gap-3 mb-4">
            <img
              v-if="setting?.logo"
              :src="'/uploads/' + setting.logo"
              alt="Logo"
              class="w-10 h-10 object-contain rounded-lg bg-white/10 p-1"
            />
            <div>
              <h3 class="text-base font-extrabold text-white tracking-tight">
                {{ setting?.nama_website || 'AMIK Taruna' }}
              </h3>
              <p class="text-xs text-brand-300 font-medium">Akademi Manajemen Informatika dan Komputer</p>
            </div>
          </div>
          
          <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
            {{ setting?.footer_deskripsi || 'Perguruan tinggi vokasi teknologi informasi yang berdedikasi melahirkan praktisi dan profesional digital siap kerja.' }}
          </p>

          <!-- Social Links -->
          <div class="flex items-center gap-2.5">
            <a
              v-if="setting?.instagram"
              :href="setting.instagram"
              target="_blank"
              rel="noopener"
              class="w-9 h-9 rounded-lg bg-white/5 hover:bg-brand-700 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200"
              aria-label="Instagram"
            >
              <i class="fab fa-instagram text-sm"></i>
            </a>
            <a
              v-if="setting?.facebook"
              :href="setting.facebook"
              target="_blank"
              rel="noopener"
              class="w-9 h-9 rounded-lg bg-white/5 hover:bg-brand-700 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200"
              aria-label="Facebook"
            >
              <i class="fab fa-facebook-f text-sm"></i>
            </a>
            <a
              v-if="setting?.youtube"
              :href="setting.youtube"
              target="_blank"
              rel="noopener"
              class="w-9 h-9 rounded-lg bg-white/5 hover:bg-brand-700 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200"
              aria-label="YouTube"
            >
              <i class="fab fa-youtube text-sm"></i>
            </a>
            <a
              v-if="setting?.tiktok"
              :href="setting.tiktok"
              target="_blank"
              rel="noopener"
              class="w-9 h-9 rounded-lg bg-white/5 hover:bg-brand-700 text-slate-300 hover:text-white flex items-center justify-center transition-all duration-200"
              aria-label="TikTok"
            >
              <i class="fab fa-tiktok text-sm"></i>
            </a>
          </div>
        </div>

        <!-- Navigation Links: Akademik -->
        <div class="lg:col-span-2 sm:col-span-1">
          <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">
            Akademik
          </h4>
          <ul class="space-y-2 text-xs sm:text-sm">
            <li><a href="/akademik" class="text-slate-400 hover:text-white transition-colors">Program Studi</a></li>
            <li><a href="/pmb" class="text-slate-400 hover:text-white transition-colors">Pendaftaran PMB</a></li>
            <li><a href="/mahasiswa" class="text-slate-400 hover:text-white transition-colors">Layanan Mahasiswa</a></li>
            <li><a href="/alumni" class="text-slate-400 hover:text-white transition-colors">Tracer Study Alumni</a></li>
          </ul>
        </div>

        <!-- Navigation Links: Lembaga -->
        <div class="lg:col-span-2 sm:col-span-1">
          <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">
            Kelembagaan
          </h4>
          <ul class="space-y-2 text-xs sm:text-sm">
            <li><a href="/tentang" class="text-slate-400 hover:text-white transition-colors">Tentang AMIK</a></li>
            <li><a href="/tentang#visi-misi" class="text-slate-400 hover:text-white transition-colors">Visi & Misi</a></li>
            <li><a href="/lppm" class="text-slate-400 hover:text-white transition-colors">LPPM</a></li>
            <li><a href="/ppm" class="text-slate-400 hover:text-white transition-colors">Penjaminan Mutu</a></li>
            <li><a href="/kritik-saran" class="text-slate-400 hover:text-white transition-colors">Kritik & Saran</a></li>
          </ul>
        </div>

        <!-- Contact & Location Information -->
        <div class="lg:col-span-4">
          <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">
            Kontak Kampus
          </h4>
          <ul class="space-y-3 text-xs sm:text-sm text-slate-400">
            <li v-if="setting?.alamat" class="flex items-start gap-3">
              <i class="fas fa-map-marker-alt text-brand-400 mt-1 shrink-0"></i>
              <a
                :href="'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(setting.alamat)"
                target="_blank"
                rel="noopener"
                class="hover:text-white transition-colors leading-relaxed"
              >
                {{ setting.alamat }}
              </a>
            </li>
            <li v-if="setting?.telepon" class="flex items-center gap-3">
              <i class="fas fa-phone-alt text-brand-400 shrink-0"></i>
              <a :href="'tel:' + setting.telepon" class="hover:text-white transition-colors">
                {{ setting.telepon }}
              </a>
            </li>
            <li v-if="setting?.email" class="flex items-center gap-3">
              <i class="fas fa-envelope text-brand-400 shrink-0"></i>
              <a :href="'mailto:' + setting.email" class="hover:text-white transition-colors">
                {{ setting.email }}
              </a>
            </li>
          </ul>

          <!-- PMB Help Callout -->
          <div class="mt-5 p-3.5 rounded-xl bg-white/5 border border-white/10 text-xs">
            <p class="text-white font-semibold mb-1">Informasi Pendaftaran</p>
            <p class="text-slate-400 mb-2">Konsultasi jadwal dan persyaratan pendaftaran mahasiswa baru.</p>
            <a
              href="/pmb"
              class="inline-flex items-center gap-1.5 text-accent-gold hover:text-amber-300 font-bold"
            >
              Kunjungi Portal PMB →
            </a>
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
        <p>&copy; {{ new Date().getFullYear() }} {{ setting?.nama_website || 'AMIK Taruna' }}. Hak cipta dilindungi undang-undang.</p>
        <div class="flex items-center gap-4">
          <a href="/kritik-saran" class="hover:text-slate-300 transition-colors">Kritik & Saran</a>
          <span>•</span>
          <a href="/login" class="hover:text-slate-300 transition-colors">Login Admin</a>
        </div>
      </div>
    </div>
  </footer>
</template>
