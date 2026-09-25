<script setup>
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import UnifiedHero from '../components/home/UnifiedHero.vue';
import TrustMetrics from '../components/home/TrustMetrics.vue';
import AcademicSection from '../components/home/AcademicSection.vue';
import NewsSection from '../components/home/NewsSection.vue';
import AlumniSection from '../components/home/AlumniSection.vue';
import PeopleSection from '../components/home/PeopleSection.vue';
import CtaSection from '../components/home/CtaSection.vue';
import LocationSection from '../components/home/LocationSection.vue';
import MobileHomeView from '../components/home/MobileHomeView.vue';

defineProps({
  setting: { type: Object, default: () => ({}) },
  beritas: { type: Array, default: () => [] },
  pengumuman: { type: Array, default: () => [] },
  pengabdian: { type: Array, default: () => [] },
  penelitian: { type: Array, default: () => [] },
  kegiatan: { type: Array, default: () => [] },
  visimisi: { type: Object, default: () => ({}) },
  dosen: { type: Array, default: () => [] },
  program_studis: { type: Array, default: () => [] },
  alumni_sections: { type: Array, default: () => [] },
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-[#fbfcfb] text-slate-800 antialiased selection:bg-brand-100 selection:text-brand-900">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation, Elevated PMB CTA) -->
    <AppNavbar :setting="setting" current-path="/" />

    <!-- MOBILE NATIVE APP VIEW (Screen < lg, phone app dashboard) -->
    <div class="lg:hidden flex-1 bg-[#031d11]">
      <MobileHomeView
        :setting="setting"
        :beritas="beritas"
        :program-studis="program_studis"
        :pengumuman="pengumuman"
      />
    </div>

    <!-- DESKTOP EDITORIAL VIEW (Screen >= lg) -->
    <main class="hidden lg:block flex-1">
      
      <!-- 2. Hero Section (Unified Editorial Baseline, Phase 1.1) -->
      <UnifiedHero :setting="setting" />

      <!-- 3. Identity / Introduction Pillars (4 Academic Strengths) -->
      <TrustMetrics :prodis="program_studis" />

      <!-- 4. Academic Programs (Numbered Editorial List 01, 02, 03) -->
      <AcademicSection :program-studis="program_studis" />

      <!-- 5. News & Publications (Featured Article + Supporting News List) -->
      <NewsSection :beritas="beritas" />

      <!-- 6. Alumni (Tracer Study & Authentic Alumni Synergy) -->
      <AlumniSection :alumni-sections="alumni_sections" />

      <!-- 7. People / Leadership (Portrait Editorial Faculty Highlights) -->
      <PeopleSection :dosen="dosen" />

      <!-- 8. Institutional Call to Action (Strong Closing Conversion Statement) -->
      <CtaSection :setting="setting" />

      <!-- 9. Location & Campus Visit (Grounded Address + Touch-Safe Framed Map) -->
      <LocationSection :setting="setting" />

    </main>

    <!-- 10. Footer -->
    <AppFooter :setting="setting" />

  </div>
</template>
