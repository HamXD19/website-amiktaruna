<script setup>
import { ref, computed, onMounted } from 'vue';
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import CtaSection from '../components/home/CtaSection.vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  berita: {
    type: Object,
    required: true,
    default: () => ({})
  },
  latest_beritas: {
    type: Array,
    default: () => []
  }
});

// Indonesian Date Formatter
const formatDateIndo = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  if (isNaN(date.getTime())) return dateStr;
  return new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }).format(date);
};

// Category Mapping
const categoryLabel = (cat) => {
  if (!cat) return 'Warta Kampus';
  const map = {
    'kegiatan_kampus': 'Kegiatan Kampus',
    'pengumuman': 'Pengumuman Resmi',
    'pengabdian': 'Pengabdian Masyarakat',
    'penelitian': 'Penelitian & Inovasi',
    'akademik': 'Kabar Akademik'
  };
  return map[cat] || cat.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};

// Estimate Reading Time
const readingTime = computed(() => {
  const text = props.berita?.isi || '';
  const words = text.trim().split(/\s+/).filter(Boolean).length;
  const minutes = Math.max(1, Math.ceil(words / 175));
  return `${minutes} menit baca`;
});

// Reader font size adjustor (A- / A+)
const fontSizes = [
  { label: 'Standar', class: 'text-[16px] leading-[1.8]' },
  { label: 'Sedang', class: 'text-[18px] leading-[1.9]' },
  { label: 'Besar', class: 'text-[20px] leading-[2.0]' }
];
const currentFontIndex = ref(1); // default 'Sedang'
const activeFontClass = computed(() => fontSizes[currentFontIndex.value].class);

const increaseFontSize = () => {
  if (currentFontIndex.value < fontSizes.length - 1) {
    currentFontIndex.value++;
  }
};

const decreaseFontSize = () => {
  if (currentFontIndex.value > 0) {
    currentFontIndex.value--;
  }
};

// Paragraph breakdown
const paragraphs = computed(() => {
  const text = props.berita?.isi || '';
  return text.split(/\r?\n\r?\n/).map(p => p.trim()).filter(Boolean);
});

// Video Embed Helper (YouTube, TikTok, or Legacy MP4)
const videoType = computed(() => {
  const v = (props.berita?.video || '').trim();
  if (!v) return null;
  if (v.includes('youtube.com') || v.includes('youtu.be')) return 'youtube';
  if (v.includes('tiktok.com')) return 'tiktok';
  if (v.endsWith('.mp4') || v.endsWith('.webm') || !v.startsWith('http')) return 'mp4';
  return 'external';
});

const youtubeEmbedUrl = computed(() => {
  const v = (props.berita?.video || '').trim();
  if (!v) return '';
  const match = v.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
  if (match && match[1]) {
    return `https://www.youtube-nocookie.com/embed/${match[1]}`;
  }
  return '';
});

const tiktokVideoId = computed(() => {
  const v = (props.berita?.video || '').trim();
  if (!v) return '';
  const match = v.match(/\/video\/(\d+)/);
  return match && match[1] ? match[1] : '';
});

const showTikTokEmbed = ref(false);

// Image error handling
const imageLoadError = ref(false);
const onImageError = () => {
  imageLoadError.value = true;
};

// Share & Copy Link handling
const currentUrl = ref('');
const copyToast = ref(false);

onMounted(() => {
  currentUrl.value = window.location.href;
});

const shareToWhatsApp = () => {
  const text = `${props.berita?.judul || 'Berita AMIK Taruna'} - ${currentUrl.value}`;
  window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`, '_blank');
};

const shareToTwitter = () => {
  const text = `${props.berita?.judul || 'Berita AMIK Taruna'}`;
  window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(currentUrl.value)}`, '_blank');
};

const shareToFacebook = () => {
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl.value)}`, '_blank');
};

const copyArticleLink = async () => {
  try {
    await navigator.clipboard.writeText(currentUrl.value);
    copyToast.value = true;
    setTimeout(() => {
      copyToast.value = false;
    }, 2200);
  } catch (err) {
    console.error('Gagal menyalin tautan:', err);
  }
};

// Monogram helper for related news or missing image
const getNewsMonogram = (title) => {
  if (!title) return 'AMIK';
  return title.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-transparent text-slate-800 antialiased selection:bg-[#dcfce7] selection:text-[#14532d]">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation) -->
    <AppNavbar :setting="setting" current-path="/berita" />

    <main class="flex-1">
      
      <!-- 2. Journalistic Header Section -->
      <header class="pt-28 sm:pt-32 lg:pt-36 pb-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          
          <!-- Elevated Header Card (Journalistic Sheet) -->
          <div class="journal-reading-sheet bg-white rounded-3xl p-8 sm:p-12 shadow-2xl border border-slate-200/80 relative z-10">
            
            <!-- Breadcrumb Navigation -->
            <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500">
              <a href="/" class="hover:text-[#166534] transition-colors flex items-center gap-1.5">
                <i class="fas fa-home text-[10px]"></i>
                <span>Beranda</span>
              </a>
              <span class="text-slate-300">/</span>
              <a href="/berita" class="hover:text-[#166534] transition-colors">
                Warta & Berita
              </a>
              <span class="text-slate-300">/</span>
              <span class="text-[#166534] font-semibold">
                {{ categoryLabel(berita.kategori) }}
              </span>
            </nav>

            <!-- Category Kicker & Reading Time -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#dcfce7] text-[#166534] border border-[#bbf7d0]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#166534]"></span>
                {{ categoryLabel(berita.kategori) }}
              </span>

              <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                <i class="far fa-clock text-slate-400"></i>
                <span>{{ readingTime }}</span>
              </span>
            </div>

            <!-- Main Journalistic Headline -->
            <h1 class="text-2xl sm:text-3xl lg:text-[42px] font-extrabold text-[#0f172a] tracking-tight leading-[1.2] [text-wrap:balance]">
              {{ berita.judul }}
            </h1>

            <!-- Byline & Journalistic Metadata Bar -->
            <div class="mt-6 pt-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <!-- Author & Editorial Team -->
              <div class="flex items-center gap-3.5">
                <!-- Author Avatar Icon -->
                <div class="w-11 h-11 rounded-full bg-[#052e16] text-[#dcfce7] flex items-center justify-center font-bold text-sm shrink-0 shadow-xs border border-[#166534]/50">
                  <i class="fas fa-feather-alt text-xs"></i>
                </div>
                <div class="text-xs sm:text-sm">
                  <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-900">
                      {{ berita.penulis || 'Humas AMIK Taruna' }}
                    </span>
                    <span v-if="berita.editor" class="text-slate-400 text-xs">• Editor: {{ berita.editor }}</span>
                  </div>
                  <div class="text-slate-500 text-xs mt-0.5 flex items-center gap-2">
                    <time :datetime="berita.publish_at">
                      {{ formatDateIndo(berita.publish_at || berita.created_at) }}
                    </time>
                    <span>•</span>
                    <span>Probolinggo, Jawa Timur</span>
                  </div>
                </div>
              </div>

              <!-- Typography Font Adjuster Controls -->
              <div class="flex items-center gap-2 self-start sm:self-auto">
                <div class="inline-flex items-center bg-slate-100 p-1 rounded-lg border border-slate-200 text-xs">
                  <button
                    type="button"
                    @click="decreaseFontSize"
                    class="px-2 py-1 rounded text-slate-600 hover:text-slate-900 font-bold transition-colors disabled:opacity-30"
                    :disabled="currentFontIndex === 0"
                    title="Perkecil Ukuran Teks"
                  >
                    A-
                  </button>
                  <span class="w-px h-3 bg-slate-300 mx-0.5"></span>
                  <button
                    type="button"
                    @click="increaseFontSize"
                    class="px-2 py-1 rounded text-slate-600 hover:text-slate-900 font-bold transition-colors disabled:opacity-30"
                    :disabled="currentFontIndex === fontSizes.length - 1"
                    title="Perbesar Ukuran Teks"
                  >
                    A+
                  </button>
                </div>

                <!-- Quick Share Buttons -->
                <button
                  type="button"
                  @click="shareToWhatsApp"
                  class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-colors border border-emerald-200/80"
                  title="Bagikan ke WhatsApp"
                >
                  <i class="fab fa-whatsapp text-sm"></i>
                </button>
                <button
                  type="button"
                  @click="copyArticleLink"
                  class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-800 hover:text-white flex items-center justify-center transition-colors border border-slate-200"
                  title="Salin Tautan Artikel"
                >
                  <i class="fas fa-link text-xs"></i>
                </button>
              </div>

            </div>

          </div>

        </div>
      </header>

      <!-- 3. Featured Hero Visual (Image or Monogram) -->
      <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8">
        <div class="rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm bg-slate-900 relative">
          <!-- Featured Image if available and not errored -->
          <div v-if="berita.gambar && !imageLoadError" class="relative aspect-video sm:aspect-[16/9] w-full bg-slate-950">
            <img
              :src="`/uploads/berita/gambar/${berita.gambar}`"
              :alt="berita.judul"
              class="w-full h-full object-cover object-center"
              loading="lazy"
              @error="onImageError"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
          </div>

          <!-- Elegant Journalistic Monogram Fallback if image missing or broken -->
          <div
            v-else
            class="aspect-video sm:aspect-[21/9] w-full p-8 sm:p-12 flex flex-col justify-between bg-gradient-to-br from-[#052e16] via-[#0f3d23] to-[#14532d] text-white relative overflow-hidden"
          >
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:2.5rem_2.5rem] opacity-5 pointer-events-none"></div>

            <div class="flex items-center justify-between relative z-10">
              <span class="text-xs font-mono tracking-widest uppercase text-emerald-300 font-bold flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                AMIK Taruna Newsroom
              </span>
              <span class="text-xs font-semibold px-3 py-1 rounded-full bg-white/10 text-emerald-100 border border-white/20">
                Dokumentasi Resmi
              </span>
            </div>

            <div class="my-auto py-6 relative z-10 max-w-2xl">
              <span class="text-xs uppercase tracking-widest font-mono text-emerald-400/90 block mb-2">
                Warta & Liputan Khusus
              </span>
              <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white tracking-tight leading-snug">
                {{ berita.judul }}
              </p>
            </div>

            <div class="flex items-center justify-between text-xs text-emerald-200/80 border-t border-white/10 pt-4 relative z-10">
              <span>Probolinggo, Jawa Timur</span>
              <span>Dokumentasi Publikasi Digital</span>
            </div>
          </div>

          <!-- Journalistic Photo Caption -->
          <div class="bg-slate-50 px-5 py-3 border-t border-slate-200 text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <span class="italic">
              <i class="fas fa-camera text-slate-400 mr-1.5"></i>
              Dokumentasi publikasi resmi sivitas akademika AMIK Taruna Probolinggo.
            </span>
            <span class="font-mono text-[11px] text-slate-400">
              {{ categoryLabel(berita.kategori) }}
            </span>
          </div>
        </div>
      </section>

      <!-- 4. Journalistic Body Layout (8 Cols Article Copy + 4 Cols Sticky Editorial Sidebar) -->
      <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
          
          <!-- LEFT COLUMN: Article Reading Canvas (8 cols - Solid Pure White Journal Sheet) -->
          <article class="journal-reading-sheet lg:col-span-8 bg-white rounded-2xl p-6 sm:p-10 border border-slate-200 shadow-xl relative z-10">
            
            <!-- Article Body Text -->
            <div class="text-slate-800 transition-all duration-200" :class="activeFontClass">
              
              <!-- Lead Paragraph (First Paragraph with Drop-Cap Styling) -->
              <div v-if="paragraphs.length > 0" class="mb-6 font-medium text-slate-900 [text-wrap:pretty]">
                <p class="first-letter:float-left first-letter:text-5xl sm:first-letter:text-6xl first-letter:font-extrabold first-letter:text-[#166534] first-letter:mr-3 first-letter:leading-none">
                  {{ paragraphs[0] }}
                </p>
              </div>

              <!-- Remaining Paragraphs -->
              <div v-if="paragraphs.length > 1" class="space-y-5 [text-wrap:pretty]">
                <p
                  v-for="(para, idx) in paragraphs.slice(1)"
                  :key="idx"
                  class="text-slate-700"
                >
                  {{ para }}
                </p>
              </div>

              <!-- Fallback if no paragraphs -->
              <p v-if="paragraphs.length === 0" class="italic text-slate-400">
                Konten warta belum tersedia atau sedang dalam proses penyusunan redaksi.
              </p>

            </div>

            <!-- Video Documentation Player (Supporting YouTube, TikTok, or Legacy MP4) -->
            <div v-if="berita.video" class="mt-10 pt-8 border-t border-slate-100">
              <div class="flex items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-2.5">
                  <span
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold"
                    :class="{
                      'bg-red-100 text-red-600': videoType === 'youtube',
                      'bg-slate-900 text-white': videoType === 'tiktok',
                      'bg-emerald-100 text-[#166534]': videoType === 'mp4' || videoType === 'external'
                    }"
                  >
                    <i v-if="videoType === 'youtube'" class="fab fa-youtube text-sm"></i>
                    <i v-else-if="videoType === 'tiktok'" class="fab fa-tiktok text-xs"></i>
                    <i v-else class="fas fa-play text-xs"></i>
                  </span>
                  <div>
                    <h3 class="text-base font-bold text-slate-900">
                      {{ videoType === 'youtube' ? 'Tayangan YouTube Resmi' : (videoType === 'tiktok' ? 'Video Dokumentasi TikTok' : 'Video Dokumentasi Kegiatan') }}
                    </h3>
                    <span class="text-xs text-slate-500">Liputan resmi kegiatan sivitas akademika</span>
                  </div>
                </div>

                <a
                  v-if="berita.video.startsWith('http')"
                  :href="berita.video"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="text-xs font-semibold text-slate-500 hover:text-[#166534] flex items-center gap-1.5 transition-colors"
                >
                  <span>Buka di {{ videoType === 'youtube' ? 'YouTube' : (videoType === 'tiktok' ? 'TikTok' : 'Aplikasi') }}</span>
                  <i class="fas fa-external-link-alt text-[10px]"></i>
                </a>
              </div>

              <!-- YouTube Embed -->
              <div v-if="videoType === 'youtube' && youtubeEmbedUrl" class="rounded-2xl overflow-hidden bg-black shadow-md border border-slate-200 aspect-video">
                <iframe
                  :src="youtubeEmbedUrl"
                  title="YouTube video player"
                  class="w-full h-full border-0"
                  loading="lazy"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowfullscreen
                ></iframe>
              </div>

              <!-- TikTok Embed / Player Card -->
              <div v-else-if="videoType === 'tiktok'" class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-950 text-white p-6 sm:p-8 flex flex-col items-center justify-center text-center shadow-md">
                <div v-if="tiktokVideoId && showTikTokEmbed" class="w-full max-w-sm aspect-[9/16] max-h-[580px] rounded-xl overflow-hidden mb-4">
                  <iframe
                    :src="`https://www.tiktok.com/embed/v2/${tiktokVideoId}`"
                    class="w-full h-full border-0 rounded-xl"
                    loading="lazy"
                    allowfullscreen
                  ></iframe>
                </div>
                <div v-else class="py-4">
                  <span class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center text-2xl mx-auto mb-3 border border-white/15">
                    <i class="fab fa-tiktok"></i>
                  </span>
                  <h4 class="text-base font-bold mb-1">Tonton Dokumentasi di TikTok</h4>
                  <p class="text-xs text-slate-300 max-w-sm mx-auto mb-5">
                    Video liputan kegiatan ini diunggah di kanal resmi TikTok AMIK Taruna Probolinggo.
                  </p>
                  <div class="flex flex-wrap items-center justify-center gap-3">
                    <button
                      v-if="tiktokVideoId"
                      type="button"
                      @click="showTikTokEmbed = true"
                      class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-700 text-white text-xs font-bold hover:bg-emerald-600 transition-colors shadow-xs"
                    >
                      <i class="fas fa-play text-[10px]"></i>
                      <span>Putar Video di Halaman Ini</span>
                    </button>
                    <a
                      :href="berita.video"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-slate-900 text-xs font-bold hover:bg-slate-100 transition-colors shadow-xs"
                    >
                      <i class="fab fa-tiktok"></i>
                      <span>Buka Aplikasi TikTok</span>
                    </a>
                  </div>
                </div>
              </div>

              <!-- Legacy Local File MP4 Player -->
              <div v-else-if="videoType === 'mp4'" class="rounded-2xl overflow-hidden bg-black shadow-md border border-slate-800">
                <video controls class="w-full aspect-video">
                  <source :src="berita.video.startsWith('http') ? berita.video : `/uploads/berita/video/${berita.video}`" type="video/mp4" />
                  Browser Anda tidak mendukung tag video HTML5.
                </video>
              </div>

              <!-- Other External Link Player -->
              <div v-else class="rounded-2xl p-6 border border-slate-200 bg-slate-50 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                  <i class="fas fa-video text-2xl text-[#166534]"></i>
                  <div>
                    <span class="text-xs font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">{{ berita.video }}</span>
                    <span class="text-[11px] text-slate-500">Tautan video liputan kegiatan</span>
                  </div>
                </div>
                <a
                  :href="berita.video"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#166534] text-white text-xs font-bold hover:bg-[#14532d] transition-colors"
                >
                  <i class="fas fa-play text-[10px]"></i>
                  <span>Putar Video</span>
                </a>
              </div>
            </div>

            <!-- Downloadable PDF Attachment (If available) -->
            <div v-if="berita.file_pdf" class="mt-10 pt-8 border-t border-slate-100">
              <div class="flex items-center gap-2.5 mb-4">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 text-[#166534] flex items-center justify-center text-xs font-bold">
                  <i class="fas fa-file-pdf"></i>
                </span>
                <div>
                  <h3 class="text-base font-bold text-slate-900">Lampiran Dokumen Resmi</h3>
                  <span class="text-xs text-slate-500">Berkas surat edaran atau dokumen pendukung publikasi</span>
                </div>
              </div>

              <div class="p-4 sm:p-5 rounded-xl border border-emerald-200/80 bg-gradient-to-r from-emerald-50/50 to-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                  <i class="fas fa-file-alt text-2xl text-[#166534]"></i>
                  <div>
                    <span class="text-xs font-bold text-slate-900 block truncate max-w-xs sm:max-w-md">
                      {{ berita.file_pdf }}
                    </span>
                    <span class="text-[11px] text-slate-500">Dokumen PDF Resmi • Terverifikasi</span>
                  </div>
                </div>

                <a
                  :href="`/uploads/berita/pdf/${berita.file_pdf}`"
                  target="_blank"
                  download
                  class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#166534] text-white text-xs font-bold hover:bg-[#14532d] transition-colors shrink-0 shadow-xs"
                >
                  <i class="fas fa-download text-xs"></i>
                  <span>Unduh Dokumen</span>
                </a>
              </div>
            </div>

            <!-- Article Footer: Topic Tags & Editorial Note -->
            <div class="mt-10 pt-8 border-t border-slate-100">
              <!-- Topic Badges -->
              <div class="flex flex-wrap items-center gap-2 mb-6">
                <span class="text-xs font-bold text-slate-400 mr-1">Topik:</span>
                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium hover:bg-slate-200 transition-colors">
                  #{{ categoryLabel(berita.kategori).replace(/\s+/g, '') }}
                </span>
                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium hover:bg-slate-200 transition-colors">
                  #AMIKTaruna
                </span>
                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-medium hover:bg-slate-200 transition-colors">
                  #KampusVokasiProbolinggo
                </span>
              </div>

              <!-- Editorial Disclaimer Box -->
              <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 leading-relaxed mb-6">
                <p class="font-bold text-slate-800 mb-1">
                  <i class="fas fa-shield-alt text-[#166534] mr-1"></i> Redaksi AMIK Taruna Probolinggo
                </p>
                Artikel ini dipublikasikan oleh Bagian Hubungan Masyarakat dan Publikasi Digital AMIK Taruna Probolinggo untuk kepentingan informasi akademik dan transparansi institusi.
              </div>

              <!-- Share Bar Bottom -->
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-slate-100">
                <span class="text-xs font-bold text-slate-700">
                  Bagikan warta ini kepada rekan & mahasiswa:
                </span>
                <div class="flex items-center gap-2">
                  <button
                    type="button"
                    @click="shareToWhatsApp"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white text-xs font-bold transition-colors border border-emerald-200/80"
                  >
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                  </button>
                  <button
                    type="button"
                    @click="shareToTwitter"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-800 hover:text-white text-xs font-bold transition-colors border border-slate-200"
                  >
                    <i class="fab fa-x-twitter"></i>
                    <span>X</span>
                  </button>
                  <button
                    type="button"
                    @click="shareToFacebook"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white text-xs font-bold transition-colors border border-blue-200"
                  >
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                  </button>
                  <button
                    type="button"
                    @click="copyArticleLink"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-800 hover:text-white text-xs font-bold transition-colors border border-slate-200"
                  >
                    <i class="fas fa-copy"></i>
                    <span>Salin</span>
                  </button>
                </div>
              </div>

            </div>

          </article>

          <!-- RIGHT COLUMN: Sticky Journalistic Sidebar (4 cols) -->
          <aside class="lg:col-span-4 space-y-8 lg:sticky lg:top-28">
            
            <!-- 1. AMIK Taruna Newsroom Profile -->
            <div class="journal-reading-sheet bg-white rounded-2xl p-6 border border-slate-200 shadow-md">
              <div class="flex items-center gap-3 mb-4">
                <span class="w-10 h-10 rounded-xl bg-[#052e16] text-[#dcfce7] flex items-center justify-center text-base font-bold shadow-xs">
                  <i class="fas fa-university"></i>
                </span>
                <div>
                  <span class="text-[11px] font-mono tracking-wider uppercase text-[#166534] font-bold block">Newsroom Kampus</span>
                  <h3 class="text-base font-bold text-slate-900">AMIK Taruna Warta</h3>
                </div>
              </div>
              <p class="text-xs text-slate-600 leading-relaxed">
                Kanal informasi resmi AMIK Taruna Probolinggo yang menyajikan siaran pers, agenda akademik, pencapaian mahasiswa, dan warta kegiatan kampus terpercaya.
              </p>
              <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-[#166534]">
                <a href="/berita" class="hover:underline flex items-center gap-1">
                  <span>Arsip Semua Warta</span>
                  <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
              </div>
            </div>

            <!-- 2. Berita Terkini Lainnya -->
            <div v-if="latest_beritas && latest_beritas.length > 0" class="journal-reading-sheet bg-white rounded-2xl p-6 border border-slate-200 shadow-md">
              <div class="flex items-center justify-between gap-2 mb-5 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                  <span class="w-2 h-2 rounded-full bg-[#166534]"></span>
                  <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900">
                    Warta Terkini
                  </h3>
                </div>
                <a href="/berita" class="text-xs font-semibold text-[#166534] hover:underline">
                  Semua
                </a>
              </div>

              <div class="space-y-4">
                <article
                  v-for="item in latest_beritas"
                  :key="item.id"
                  class="group flex gap-3.5 items-start pb-4 border-b border-slate-100 last:border-0 last:pb-0"
                >
                  <!-- Thumbnail / Monogram -->
                  <div class="w-16 h-16 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-200 relative">
                    <img
                      v-if="item.gambar"
                      :src="`/uploads/berita/gambar/${item.gambar}`"
                      :alt="item.judul"
                      class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                      loading="lazy"
                      @error="(e) => { e.target.style.display = 'none'; }"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#052e16] to-[#14532d] text-emerald-300 font-mono text-xs font-bold">
                      {{ getNewsMonogram(item.judul) }}
                    </div>
                  </div>

                  <!-- Text -->
                  <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#166534] block truncate">
                      {{ categoryLabel(item.kategori) }}
                    </span>
                    <a
                      :href="`/berita/${item.slug}`"
                      class="text-xs font-bold text-slate-900 group-hover:text-[#166534] transition-colors line-clamp-2 leading-snug mt-0.5"
                    >
                      {{ item.judul }}
                    </a>
                    <span class="text-[11px] text-slate-400 mt-1 block">
                      {{ formatDateIndo(item.publish_at || item.created_at) }}
                    </span>
                  </div>
                </article>
              </div>
            </div>

            <!-- 3. Penerimaan Mahasiswa Baru / PMB Widget -->
            <div class="bg-gradient-to-br from-[#052e16] to-[#14532d] text-white rounded-2xl p-6 relative overflow-hidden shadow-xs">
              <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:2rem_2rem] opacity-5 pointer-events-none"></div>

              <div class="relative z-10">
                <span class="text-[10px] font-mono uppercase tracking-widest text-emerald-300 font-bold bg-white/10 px-2.5 py-1 rounded-full inline-block mb-3 border border-white/15">
                  PMB AMIK Taruna
                </span>
                <h4 class="text-base font-bold text-white tracking-tight mb-2">
                  Kuliah Vokasi IT Siap Kerja
                </h4>
                <p class="text-xs text-emerald-100/80 leading-relaxed mb-5">
                  Pendaftaran mahasiswa baru tahun akademik baru telah dibuka. Pilihan program studi D3 Sistem Informasi, Teknologi Informasi, dan Sistem Informasi Akuntansi.
                </p>

                <a
                  href="/pmb"
                  class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white text-[#14532d] text-xs font-bold hover:bg-[#dcfce7] transition-colors shadow-xs"
                >
                  <i class="fas fa-graduation-cap text-xs"></i>
                  <span>Daftar Mahasiswa Baru</span>
                </a>
              </div>
            </div>

            <!-- 4. Kembali ke Indeks Berita -->
            <div class="text-center pt-2">
              <a
                href="/berita"
                class="inline-flex items-center gap-2 text-xs font-bold text-[#166534] hover:text-[#14532d] p-2 hover:bg-emerald-50 rounded-lg transition-colors"
              >
                <i class="fas fa-arrow-left text-[11px]"></i>
                <span>Kembali ke Indeks Warta</span>
              </a>
            </div>

          </aside>

        </div>
      </section>

      <!-- 5. Institutional Call to Action (PMB & WhatsApp Konsultasi) -->
      <CtaSection :setting="setting" />

    </main>

    <!-- 6. Footer (Calm, High Contrast Slate, Verified Links) -->
    <AppFooter :setting="setting" />

    <!-- Copy Toast Notification -->
    <div
      v-if="copyToast"
      class="fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl bg-[#052e16] text-[#dcfce7] border border-[#166534] shadow-lg flex items-center gap-2.5 text-xs font-semibold animate-fade-in"
    >
      <i class="fas fa-check-circle text-emerald-400"></i>
      <span>Tautan berita berhasil disalin ke clipboard!</span>
    </div>

  </div>
</template>
