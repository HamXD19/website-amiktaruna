<script setup>
defineProps({
  href: {
    type: String,
    default: null
  },
  variant: {
    type: String,
    default: 'primary',
    validator: (v) => ['primary', 'accent', 'secondary', 'outline', 'ghost'].includes(v)
  },
  size: {
    type: String,
    default: 'md',
    validator: (v) => ['sm', 'md', 'lg'].includes(v)
  },
  external: {
    type: Boolean,
    default: false
  },
  type: {
    type: String,
    default: 'button'
  }
});
</script>

<template>
  <component
    :is="href ? 'a' : 'button'"
    :href="href"
    :type="href ? undefined : type"
    :target="external ? '_blank' : undefined"
    :rel="external ? 'noopener noreferrer' : undefined"
    class="inline-flex items-center justify-center gap-2.5 font-semibold text-center select-none transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none active:scale-[0.98]"
    :class="[
      size === 'sm' ? 'text-xs px-3.5 py-1.5 rounded-lg' : '',
      size === 'md' ? 'text-sm px-5 py-2.5 rounded-xl shadow-sm' : '',
      size === 'lg' ? 'text-base px-6 py-3.5 rounded-xl shadow-md' : '',
      {
        'bg-brand-700 hover:bg-brand-800 text-white focus:ring-brand-700 shadow-brand-900/10 hover:-translate-y-0.5': variant === 'primary',
        'bg-accent-gold hover:bg-accent-amber text-slate-950 font-bold focus:ring-accent-gold shadow-accent-gold/20 hover:-translate-y-0.5': variant === 'accent',
        'bg-[#0a3520] hover:bg-[#0e452a] text-emerald-300 border border-emerald-500/30 hover:border-emerald-500/50 focus:ring-emerald-400': variant === 'secondary',
        'bg-transparent hover:bg-emerald-950/60 text-emerald-400 border-2 border-emerald-500 hover:border-emerald-400 focus:ring-emerald-500': variant === 'outline',
        'bg-transparent hover:bg-emerald-950/40 text-slate-300 focus:ring-emerald-400': variant === 'ghost',
      }
    ]"
  >
    <slot name="prefix"></slot>
    <slot></slot>
    <slot name="suffix"></slot>
  </component>
</template>
