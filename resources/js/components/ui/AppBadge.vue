<script setup>
defineProps({
  variant: {
    type: String,
    default: 'academic',
    validator: (v) => ['academic', 'accent', 'neutral', 'outline'].includes(v)
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md'].includes(v)
  }
});
</script>

<template>
  <span
    class="inline-flex items-center gap-1.5 font-semibold tracking-wide uppercase transition-colors"
    :class="[
      size === 'sm' ? 'text-[11px] px-2.5 py-0.5 rounded-md' : 'text-xs px-3.5 py-1 rounded-full',
      {
        'bg-emerald-950/70 text-emerald-300 border border-emerald-500/30': variant === 'academic',
        'bg-amber-950/70 text-amber-300 border border-amber-500/30': variant === 'accent',
        'bg-slate-900/70 text-slate-300 border border-slate-700/50': variant === 'neutral',
        'bg-emerald-950/40 text-emerald-300 border border-emerald-500/40 shadow-sm': variant === 'outline'
      }
    ]"
  >
    <slot name="icon"></slot>
    <slot></slot>
  </span>
</template>
