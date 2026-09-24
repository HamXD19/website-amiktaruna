<script setup>
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import TentangHero from '../components/tentang/TentangHero.vue';
import TentangProfile from '../components/tentang/TentangProfile.vue';
import TentangVisiMisi from '../components/tentang/TentangVisiMisi.vue';
import TentangAkreditasi from '../components/tentang/TentangAkreditasi.vue';
import TentangStruktur from '../components/tentang/TentangStruktur.vue';
import CtaSection from '../components/home/CtaSection.vue';

defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  visimisi: {
    type: Object,
    default: () => ({})
  },
  dosen: {
    type: Array,
    default: () => []
  },
  akreditasi: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-[#fbfcfb] text-slate-800 antialiased selection:bg-brand-100 selection:text-brand-900">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation, Elevated PMB CTA) -->
    <AppNavbar :setting="setting" current-path="/tentang" />

    <main class="flex-1">
      <!-- 2. Page Header (Editorial Lead & Breadcrumb) -->
      <TentangHero :setting="setting" />

      <!-- 3. Campus Profile (Real Description & Authentic Building Photography) -->
      <TentangProfile :visimisi="visimisi" :setting="setting" />

      <!-- 4. Vision & Mission (01 / VISI Focal Point & 02 / MISI Numbered List) -->
      <TentangVisiMisi :visimisi="visimisi" />

      <!-- 5. Quality & Accreditation (Primary Certified Status & Document Preview) -->
      <TentangAkreditasi :akreditasi="akreditasi" />

      <!-- 6. People & Leadership (Hierarchy-Preserved Portrait Editorial Cards) -->
      <TentangStruktur :dosen="dosen" />

      <!-- 7. Institutional Call to Action (Next Steps & Contact) -->
      <CtaSection :setting="setting" />
    </main>

    <!-- 8. Footer (Calm, Informative, Verified Links) -->
    <AppFooter :setting="setting" />

  </div>
</template>
