<script setup>
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import AlumniHero from '../components/alumni/AlumniHero.vue';
import AlumniIntro from '../components/alumni/AlumniIntro.vue';
import AlumniContentSection from '../components/alumni/AlumniContentSection.vue';
import CtaSection from '../components/home/CtaSection.vue';

defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  alumni_sections: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-[#fbfcfb] text-slate-800 antialiased selection:bg-brand-100 selection:text-brand-900">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation, Elevated PMB CTA) -->
    <AppNavbar :setting="setting" current-path="/alumni" />

    <main class="flex-1">
      <!-- 2. Page Header (Editorial Lead & Breadcrumb) -->
      <AlumniHero :setting="setting" />

      <!-- 3. Introduction & Academic Value Pillars -->
      <AlumniIntro />

      <!-- 4. Alumni Content Sections (Authentic Tracer Study & Dana Abadi) -->
      <AlumniContentSection :alumni-sections="alumni_sections" />

      <!-- 5. Institutional Call to Action -->
      <CtaSection :setting="setting" />
    </main>

    <!-- 6. Footer (Calm, High Contrast Slate, Verified Links) -->
    <AppFooter :setting="setting" />

  </div>
</template>
