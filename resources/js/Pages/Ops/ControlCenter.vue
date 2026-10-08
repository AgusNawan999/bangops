<template>
  <AuthenticatedLayout pageTitle="Operations Control Center">
    <div class="p-6 bg-slate-800/50 border border-slate-800 rounded-2xl space-y-4">
      <div class="flex items-center justify-between border-b border-slate-700/50 pb-3">
        <h3 class="font-bold text-slate-200 text-lg">🎛️ Command & Control Panel</h3>
        <span class="text-xs bg-emerald-950 text-emerald-400 border border-emerald-800 px-2.5 py-0.5 rounded-full font-mono">ACTIVE OPS</span>
      </div>
      <p class="text-slate-400 text-sm">Pusat kendali eksekusi skrip, monitoring status infrastruktur, dan isolasi jaringan terpusat.</p>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>