<script setup>
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import AkademikHero from '../components/akademik/AkademikHero.vue';
import AkademikValue from '../components/akademik/AkademikValue.vue';
import AkademikList from '../components/akademik/AkademikList.vue';
import CtaSection from '../components/home/CtaSection.vue';

defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  program_studis: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-[#fbfcfb] text-slate-800 antialiased selection:bg-brand-100 selection:text-brand-900">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation, Elevated PMB CTA) -->
    <AppNavbar :setting="setting" current-path="/akademik" />

    <main class="flex-1">
      <!-- 2. Page Header (Editorial Lead & Breadcrumbs) -->
      <AkademikHero :setting="setting" :total-prodi="program_studis.length" />

      <!-- 3. Academic Value Pillars (60% Praktik, Praktisi Industri, Transfer SKS) -->
      <AkademikValue />

      <!-- 4. Program Studi Editorial Showcase (Alternating Layout & Detail Links) -->
      <AkademikList :programs="program_studis" />

      <!-- 5. Institutional Call to Action (PMB & WhatsApp Konsultasi) -->
      <CtaSection :setting="setting" />
    </main>

    <!-- 6. Footer (Calm, High Contrast Slate, Verified Links) -->
    <AppFooter :setting="setting" />

  </div>
</template>
