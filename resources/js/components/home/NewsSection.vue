<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  beritas: {
    type: Array,
    default: () => []
  }
});

// Category Filter state
const selectedCategory = ref('semua');

// Track images that failed to load (404 / broken)
const brokenImageIds = ref(new Set());
const handleImageError = (id) => {
  brokenImageIds.value.add(id);
};

const hasValidImage = (item) => {
  return item && item.gambar && !brokenImageIds.value.has(item.id);
};

// Format date helper
const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  if (isNaN(d.getTime())) return dateStr;
  return d.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  });
};

// Clean HTML excerpt
const getCleanExcerpt = (htmlContent, length = 160) => {
  if (!htmlContent) return '';
  const plain = htmlContent.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim();
  return plain.length > length ? plain.substring(0, length) + '...' : plain;
};

// Category metadata helper (icon, label, color)
const getCategoryMeta = (cat) => {
  const c = (cat || '').toLowerCase();
  if (c.includes('pengumuman')) {
    return { label: 'Pengumuman', icon: '📢', badgeClass: 'bg-emerald-500/20 text-emerald-300 border-emerald-500/35' };
  }
  if (c.includes('kegiatan')) {
    return { label: 'Kegiatan Kampus', icon: '🎓', badgeClass: 'bg-amber-500/20 text-amber-300 border-amber-500/35' };
  }
  if (c.includes('pengabdian')) {
    return { label: 'Pengabdian', icon: '🤝', badgeClass: 'bg-blue-500/20 text-blue-300 border-blue-500/35' };
  }
  if (c.includes('penelitian')) {
    return { label: 'Penelitian', icon: '🔬', badgeClass: 'bg-purple-500/20 text-purple-300 border-purple-500/35' };
  }
  if (c.includes('prestasi')) {
    return { label: 'Prestasi', icon: '🏆', badgeClass: 'bg-yellow-500/20 text-yellow-300 border-yellow-500/35' };
  }
  return { label: cat ? cat.replace(/_/g, ' ') : 'Warta Kampus', icon: '📰', badgeClass: 'bg-emerald-500/20 text-emerald-300 border-emerald-500/35' };
};

// Available unique categories from data
const availableCategories = computed(() => {
  if (!props.beritas || props.beritas.length === 0) return [];
  const set = new Set();
  props.beritas.forEach(b => {
    if (b.kategori) set.add(b.kategori);
  });
  return Array.from(set);
});

// Filtered articles based on selected tab
const filteredList = computed(() => {
  if (!props.beritas) return [];
  if (selectedCategory.value === 'semua') return props.beritas;
  return props.beritas.filter(b => b.kategori === selectedCategory.value);
});

// Featured news (Headline)
const featuredArticle = computed(() => {
  if (!filteredList.value || filteredList.value.length === 0) return null;
  // Prioritize article that has an image, otherwise first item
  const withImage = filteredList.value.find(b => hasValidImage(b));
  return withImage || filteredList.value[0];
});

// Supporting news list (next 4 items)
const supportingArticles = computed(() => {
  if (!filteredList.value || filteredList.value.length === 0) return [];
  const feat = featuredArticle.value;
  return filteredList.value
    .filter(b => !feat || b.id !== feat.id)
    .slice(0, 4);
});
</script>

<template>
  <section class="py-16 lg:py-24 relative z-10 border-b border-emerald-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- 1. Header Section Card with Modern Emerald Glassmorphism -->
      <div class="relative overflow-hidden rounded-3xl p-6 sm:p-10 mb-8 border border-emerald-500/25 bg-[#082618]/90 backdrop-blur-xl shadow-2xl">
        <!-- Glow Effect Backdrop -->
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-emerald-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-emerald-600/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
          <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-3">
              <i class="fas fa-bullhorn text-xs"></i>
              <span>Publikasi &amp; Kabar Kampus</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-[40px] font-black text-white tracking-tight leading-[1.18]">
              Kabar Terkini AMIK Taruna
            </h2>
            <p class="mt-3 text-sm sm:text-base text-slate-300 leading-relaxed">
              Informasi resmi, agenda kegiatan, pengumuman, dan pencapaian akademik civitas kampus AMIK Taruna Probolinggo.
            </p>
          </div>

          <div class="flex items-center gap-3 shrink-0">
            <a
              href="/berita"
              class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold text-emerald-300 bg-emerald-500/15 hover:bg-emerald-500/25 border border-emerald-500/40 shadow-lg hover:shadow-emerald-500/20 transition-all duration-300 group"
            >
              <span>Buka Arsip Warta</span>
              <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
          </div>
        </div>

        <!-- Category Filter Tabs on Home -->
        <div v-if="availableCategories.length > 0" class="relative z-10 mt-6 pt-5 border-t border-emerald-500/15 flex flex-wrap gap-2 items-center">
          <span class="text-xs text-slate-400 font-semibold me-1">Kategori:</span>
          
          <button
            type="button"
            @click="selectedCategory = 'semua'"
            :class="[
              'px-3.5 py-1.5 rounded-full text-xs font-bold transition-all duration-200 border',
              selectedCategory === 'semua'
                ? 'bg-emerald-500 text-white border-emerald-400 shadow-md shadow-emerald-500/30'
                : 'bg-white/5 text-slate-300 border-white/10 hover:bg-white/10 hover:text-white'
            ]"
          >
            Semua Warta ({{ props.beritas.length }})
          </button>

          <button
            v-for="cat in availableCategories"
            :key="cat"
            type="button"
            @click="selectedCategory = cat"
            :class="[
              'px-3.5 py-1.5 rounded-full text-xs font-bold transition-all duration-200 border flex items-center gap-1.5',
              selectedCategory === cat
                ? 'bg-emerald-500 text-white border-emerald-400 shadow-md shadow-emerald-500/30'
                : 'bg-white/5 text-slate-300 border-white/10 hover:bg-white/10 hover:text-white'
            ]"
          >
            <span>{{ getCategoryMeta(cat).icon }}</span>
            <span>{{ getCategoryMeta(cat).label }}</span>
          </button>
        </div>
      </div>

      <!-- 2. News Layout: Featured Large (Left) + Curated List (Right) -->
      <div v-if="featuredArticle" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Large Featured Article (7 Cols) -->
        <article class="lg:col-span-7 flex flex-col rounded-3xl overflow-hidden border border-emerald-500/25 bg-[#082618]/85 backdrop-blur-xl shadow-xl transition-all duration-500 hover:border-emerald-500/50 hover:shadow-2xl hover:shadow-emerald-900/30 group">
          
          <!-- Image Container with Reliable Fallback Graphic -->
          <div class="relative w-full aspect-[16/10] overflow-hidden bg-[#041a10]">
            <!-- Real Image if available and not broken -->
            <img
              v-if="hasValidImage(featuredArticle)"
              :src="'/uploads/berita/gambar/' + featuredArticle.gambar"
              :alt="featuredArticle.judul"
              class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
              loading="lazy"
              @error="handleImageError(featuredArticle.id)"
            />

            <!-- Fallback High-Tech Editorial Graphic (shown when image is missing or failed to load) -->
            <div
              v-else
              class="w-full h-full flex flex-col items-center justify-center p-8 text-center relative overflow-hidden bg-gradient-to-br from-[#062917] via-[#0b3c23] to-[#041d11]"
            >
              <!-- Decorative Pattern Lines -->
              <div class="absolute inset-0 opacity-15 pointer-events-none" style="background-image: radial-gradient(#4ade80 1px, transparent 1px); background-size: 20px 20px;"></div>
              <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-emerald-400/10 blur-2xl"></div>

              <div class="relative z-10 w-20 h-20 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-4xl mb-3 shadow-inner">
                {{ getCategoryMeta(featuredArticle.kategori).icon }}
              </div>
              <span class="relative z-10 text-xs font-mono font-bold tracking-widest text-emerald-400 uppercase">
                AMIK Taruna Probolinggo
              </span>
              <p class="relative z-10 text-xs text-slate-400 mt-1 max-w-sm">
                Liputan Berita &amp; Dokumentasi Kampus
              </p>
            </div>

            <!-- Gradient Dark Bottom Overlay for Text Legibility -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#082618] via-transparent to-transparent opacity-80"></div>

            <!-- Top Badges -->
            <div class="absolute top-4 inset-x-4 flex items-center justify-between pointer-events-none z-10">
              <span
                v-if="featuredArticle.kategori"
                :class="['text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full border shadow-md flex items-center gap-1.5 backdrop-blur-md', getCategoryMeta(featuredArticle.kategori).badgeClass]"
              >
                <span>{{ getCategoryMeta(featuredArticle.kategori).icon }}</span>
                <span>{{ getCategoryMeta(featuredArticle.kategori).label }}</span>
              </span>

              <span class="text-xs font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-full bg-emerald-500 text-white shadow-lg flex items-center gap-1">
                <i class="fas fa-star text-[10px]"></i>
                <span>Sorotan Utama</span>
              </span>
            </div>

            <!-- Video Overlay Badge if article has video -->
            <div
              v-if="featuredArticle.video"
              class="absolute bottom-4 right-4 z-10 px-3 py-1.5 rounded-full bg-red-600/90 text-white text-xs font-bold flex items-center gap-2 backdrop-blur-sm shadow-md"
            >
              <i class="fas fa-play text-[10px]"></i>
              <span>Liputan Video</span>
            </div>
          </div>

          <!-- Featured Article Details -->
          <div class="p-6 sm:p-8 flex flex-col flex-1 justify-between">
            <div>
              <!-- Meta: Date, Author -->
              <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400 mb-3 font-medium">
                <span class="flex items-center gap-1.5 text-emerald-400">
                  <i class="far fa-calendar-alt text-xs"></i>
                  <span>{{ formatDate(featuredArticle.publish_at || featuredArticle.created_at) }}</span>
                </span>
                <span class="text-slate-600">•</span>
                <span v-if="featuredArticle.penulis" class="flex items-center gap-1.5">
                  <i class="far fa-user text-xs"></i>
                  <span>Oleh {{ featuredArticle.penulis }}</span>
                </span>
              </div>

              <!-- Title -->
              <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-snug group-hover:text-emerald-300 transition-colors line-clamp-2">
                <a :href="'/berita/' + (featuredArticle.slug || featuredArticle.id)">
                  {{ featuredArticle.judul }}
                </a>
              </h3>

              <!-- Excerpt -->
              <p class="mt-3.5 text-sm sm:text-base text-slate-300 leading-relaxed line-clamp-3">
                {{ getCleanExcerpt(featuredArticle.isi, 200) }}
              </p>
            </div>

            <!-- Action Button -->
            <div class="mt-6 pt-5 border-t border-emerald-500/15 flex items-center justify-between">
              <a
                :href="'/berita/' + (featuredArticle.slug || featuredArticle.id)"
                class="inline-flex items-center gap-2 text-sm font-bold text-emerald-400 group-hover:text-emerald-300 group-hover:underline"
              >
                <span>Baca Selengkapnya</span>
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1.5 transition-transform duration-200"></i>
              </a>

              <span v-if="featuredArticle.file_pdf" class="inline-flex items-center gap-1 text-xs text-rose-400 font-semibold px-2.5 py-1 rounded-md bg-rose-500/10 border border-rose-500/20">
                <i class="fas fa-paperclip"></i>
                <span>Lampiran Dokumen</span>
              </span>
            </div>
          </div>

        </article>

        <!-- Supporting Articles List (5 Cols) -->
        <div class="lg:col-span-5 flex flex-col gap-4">
          <div class="flex items-center justify-between pb-2 border-b border-emerald-500/20 mb-1">
            <h4 class="text-sm font-bold uppercase tracking-wider text-emerald-400 flex items-center gap-2">
              <i class="fas fa-newspaper text-xs"></i>
              <span>Warta Terkini Lainnya</span>
            </h4>
            <span class="text-xs text-slate-400 font-medium">{{ supportingArticles.length }} Warta</span>
          </div>

          <!-- Supporting Article Cards -->
          <article
            v-for="item in supportingArticles"
            :key="item.id"
            class="p-4 sm:p-4.5 rounded-2xl border border-emerald-500/20 bg-[#082618]/75 hover:bg-[#0c3522]/95 backdrop-blur-md transition-all duration-300 hover:border-emerald-500/40 hover:-translate-y-0.5 shadow-md group flex items-start gap-4"
          >
            <!-- Thumbnail with Reliable Fallback -->
            <div class="w-24 sm:w-28 h-24 rounded-xl overflow-hidden shrink-0 border border-emerald-500/20 bg-[#041a10] relative">
              <img
                v-if="hasValidImage(item)"
                :src="'/uploads/berita/gambar/' + item.gambar"
                :alt="item.judul"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                loading="lazy"
                @error="handleImageError(item.id)"
              />
              
              <!-- Compact Fallback Graphic -->
              <div
                v-else
                class="w-full h-full flex flex-col items-center justify-center p-2 text-center bg-gradient-to-br from-[#062917] to-[#0b3c23]"
              >
                <span class="text-2xl mb-1">{{ getCategoryMeta(item.kategori).icon }}</span>
                <span class="text-[9px] font-mono text-emerald-400/80 font-bold uppercase tracking-tight">AMIK</span>
              </div>
            </div>

            <!-- Content Details -->
            <div class="flex-1 flex flex-col justify-between min-w-0">
              <div>
                <!-- Category & Date Badges -->
                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                  <span :class="['text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border', getCategoryMeta(item.kategori).badgeClass]">
                    {{ getCategoryMeta(item.kategori).label }}
                  </span>
                  <span class="text-[11px] text-slate-400">
                    {{ formatDate(item.publish_at || item.created_at) }}
                  </span>
                </div>

                <!-- Title (Clamp 2 lines) -->
                <h5 class="text-sm font-bold text-white group-hover:text-emerald-300 transition-colors line-clamp-2 leading-snug">
                  <a :href="'/berita/' + (item.slug || item.id)">
                    {{ item.judul }}
                  </a>
                </h5>
              </div>

              <!-- Read Link -->
              <div class="mt-2.5 flex items-center justify-between">
                <a
                  :href="'/berita/' + (item.slug || item.id)"
                  class="text-xs font-bold text-emerald-400 group-hover:text-emerald-300 inline-flex items-center gap-1.5 transition-colors"
                >
                  <span>Selengkapnya</span>
                  <i class="fas fa-chevron-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                </a>

                <span v-if="item.video" class="text-[10px] text-red-400 font-semibold flex items-center gap-1">
                  <i class="fas fa-play-circle"></i>
                  <span>Video</span>
                </span>
              </div>
            </div>

          </article>
        </div>

      </div>

      <!-- Fallback if empty -->
      <div v-else class="text-center py-16 p-8 rounded-3xl bg-[#082618]/80 border border-emerald-500/20 backdrop-blur-md text-slate-300">
        <div class="w-16 h-16 rounded-full bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center mx-auto mb-3 text-2xl text-emerald-400">
          <i class="far fa-newspaper"></i>
        </div>
        <h4 class="text-lg font-bold text-white mb-1">Belum Ada Warta pada Kategori Ini</h4>
        <p class="text-sm text-slate-400">Silakan pilih kategori lain atau periksa kembali arsip warta kampus.</p>
        <button
          type="button"
          @click="selectedCategory = 'semua'"
          class="mt-4 px-4 py-2 rounded-full text-xs font-bold bg-emerald-500 text-white hover:bg-emerald-600 transition-colors"
        >
          Tampilkan Semua Warta
        </button>
      </div>

    </div>
  </section>
</template>
