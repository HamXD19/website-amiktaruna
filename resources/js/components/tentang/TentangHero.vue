<script setup>
defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});
</script>

<template>
  <section class="relative pt-28 pb-14 sm:pt-32 sm:pb-18 lg:pt-36 lg:pb-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Elevated Solid White Hero Card -->
      <div class="card rounded-3xl p-8 sm:p-12 lg:p-14 relative z-10">
        
        <!-- Breadcrumb Navigation -->
        <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-xs font-medium text-slate-300">
          <a href="/" class="hover:text-emerald-300 transition-colors flex items-center gap-1.5">
            <i class="fas fa-home text-[10px]"></i>
            <span>Beranda</span>
          </a>
          <span class="text-slate-500">/</span>
          <span class="text-emerald-400 font-semibold" aria-current="page">Tentang Kampus</span>
        </nav>

        <div class="max-w-3xl">
          <!-- Eyebrow Pill -->
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-4 shadow-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            Profil &amp; Identitas Institusi
          </div>

          <!-- Main Heading -->
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
            Tentang AMIK Taruna
          </h1>

          <!-- Subtitle -->
          <p class="mt-4 sm:mt-5 text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl font-normal">
            Mengenal institusi, perjalanan pendidikan vokasi teknologi terapan, dan komitmen mutu civitas akademika AMIK Taruna Probolinggo.
          </p>

          <!-- Quick Institutional Anchors -->
          <div class="mt-8 flex flex-wrap items-center gap-3 text-xs">
            <a
              href="#profil"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 hover:text-white border border-emerald-500/30 transition-all font-semibold shadow-xs"
            >
              <span>Profil Kampus</span>
              <span class="text-emerald-400">↓</span>
            </a>
            <a
              href="#visi-misi"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 hover:text-white border border-emerald-500/30 transition-all font-semibold shadow-xs"
            >
              <span>Visi &amp; Misi</span>
              <span class="text-emerald-400">↓</span>
            </a>
            <a
              href="#akreditasi"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 hover:text-white border border-emerald-500/30 transition-all font-semibold shadow-xs"
            >
              <span>Akreditasi Mutu</span>
              <span class="text-emerald-400">↓</span>
            </a>
            <a
              href="#struktur"
              class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-950/60 hover:bg-emerald-900/80 text-emerald-300 hover:text-white border border-emerald-500/30 transition-all font-semibold shadow-xs"
            >
              <span>Struktur Organisasi</span>
              <span class="text-emerald-400">↓</span>
            </a>
          </div>

        </div>

      </div>

    </div>
  </section>
</template>
