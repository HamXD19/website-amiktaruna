<script setup>
import AppNavbar from '../components/layout/AppNavbar.vue';
import AppFooter from '../components/layout/AppFooter.vue';
import AlumniHero from '../components/alumni/AlumniHero.vue';
import AlumniIntro from '../components/alumni/AlumniIntro.vue';
import AlumniContentSection from '../components/alumni/AlumniContentSection.vue';
import AlumniTestimonialSection from '../components/alumni/AlumniTestimonialSection.vue';
import CtaSection from '../components/home/CtaSection.vue';

defineProps({
  setting: {
    type: Object,
    default: () => ({})
  },
  alumni_sections: {
    type: Array,
    default: () => []
  },
  alumni_testimonis: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <div class="min-h-screen flex flex-col bg-transparent text-slate-100 antialiased selection:bg-brand-500 selection:text-white">
    
    <!-- 1. Header / Navbar (Sticky, Grouped Navigation, Elevated PMB CTA) -->
    <AppNavbar :setting="setting" current-path="/alumni" />

    <main class="flex-1">
      <!-- 2. Page Header (Editorial Lead & Breadcrumb) -->
      <AlumniHero :setting="setting" />

      <!-- 3. Introduction & Academic Value Pillars -->
      <AlumniIntro :setting="setting" />

      <!-- 4. Alumni Content Sections (Authentic Tracer Study & Dana Abadi) -->
      <AlumniContentSection :alumni-sections="alumni_sections" />

      <!-- 5. Alumni Testimonials (Stories & Career Insights) -->
      <AlumniTestimonialSection :testimonis="alumni_testimonis" />

      <!-- 6. Institutional Call to Action -->
      <CtaSection :setting="setting" />
    </main>

    <!-- 6. Footer (Calm, High Contrast Slate, Verified Links) -->
    <AppFooter :setting="setting" />

  </div>
</template>
