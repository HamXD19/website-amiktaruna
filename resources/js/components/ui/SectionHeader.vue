<script setup>
defineProps({
  eyebrow: {
    type: String,
    default: null
  },
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    default: null
  },
  align: {
    type: String,
    default: 'center',
    validator: (v) => ['left', 'center'].includes(v)
  }
});
</script>

<template>
  <div
    class="mb-10 lg:mb-12 card rounded-2xl p-6 sm:p-8 relative z-10"
    :class="align === 'center' ? 'text-center max-w-3xl mx-auto' : 'text-left max-w-2xl'"
  >
    <div v-if="eyebrow" class="mb-3">
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
        <slot name="eyebrow-icon"></slot>
        {{ eyebrow }}
      </span>
    </div>
    
    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
      <slot name="title">{{ title }}</slot>
    </h2>

    <p v-if="subtitle" class="mt-3.5 text-base sm:text-lg text-slate-300 leading-relaxed">
      {{ subtitle }}
    </p>
  </div>
</template>
