<script setup>
import { computed } from 'vue';

const props = defineProps({
  setting: {
    type: Object,
    default: () => ({})
  }
});

const defaultValues = [
  {
    icon: 'fas fa-laptop-code',
    title: '60% Kurikulum Praktik',
    desc: 'Fokus pada penguasaan studi kasus nyata, perancangan aplikasi, dan pemecahan masalah komputasi industri.'
  },
  {
    icon: 'fas fa-chalkboard-teacher',
    title: 'Dosen Praktisi Industri',
    desc: 'Pengajar berpengalaman mendampingi mahasiswa dari pemahaman konseptual hingga penerapan praktis.'
  },
  {
    icon: 'fas fa-share-alt',
    title: 'Transfer SKS Lanjutan',
    desc: 'Lulusan dapat dengan mudah melanjutkan studi ke jenjang sarjana di PTN maupun Swasta dengan penyesuaian SKS.'
  }
];

const values = computed(() => {
  if (props.setting?.akademik_values && Array.isArray(props.setting.akademik_values) && props.setting.akademik_values.length > 0) {
    return props.setting.akademik_values;
  }
  return defaultValues;
});
</script>

<template>
  <section class="py-14 sm:py-16 bg-transparent border-b border-emerald-500/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        
        <div
          v-for="(val, idx) in values"
          :key="idx"
          class="card p-6 rounded-2xl flex items-start gap-4"
        >
          <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
            <i :class="[val.icon || 'fas fa-check-circle', 'text-lg']"></i>
          </div>
          <div>
            <h3 class="text-base font-bold text-white">{{ val.title }}</h3>
            <p class="text-xs sm:text-sm text-slate-300 mt-1.5 leading-relaxed">
              {{ val.desc }}
            </p>
          </div>
        </div>

      </div>

    </div>
  </section>
</template>
