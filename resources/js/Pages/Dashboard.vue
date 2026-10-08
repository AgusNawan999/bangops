<template>
  <AuthenticatedLayout pageTitle="Beranda Operasional">
    
    <!-- Welcome Banner -->
    <div class="p-6 bg-gradient-to-r from-indigo-900/40 to-slate-800/40 border border-indigo-500/20 rounded-2xl">
      <h3 class="text-2xl font-extrabold text-white">Halo, {{ user()?.name }}! 👋</h3>
      <p class="text-slate-400 text-sm mt-1">Selamat datang di platform PERWIRA SECURYTY. Hak akses akun dan menu navigasi Anda terintegrasi secara real-time.</p>
    </div>

    <!-- Profile Detail Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="p-6 bg-slate-800/50 border border-slate-800 rounded-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-700/50 pb-3">
          <h4 class="font-bold text-slate-200 text-sm">Informasi Pengguna</h4>
          <span class="text-xs bg-slate-700 text-slate-300 px-2.5 py-0.5 rounded-full font-mono">ID #{{ user()?.id }}</span>
        </div>
        <div class="space-y-3 text-sm">
          <div>
            <span class="text-xs text-slate-500 block">Nama Lengkap</span>
            <span class="font-medium text-slate-200">{{ user()?.name }}</span>
          </div>
          <div>
            <span class="text-xs text-slate-500 block">Alamat Email</span>
            <span class="font-medium text-slate-200">{{ user()?.email }}</span>
          </div>
        </div>
      </div>

      <div class="p-6 bg-slate-800/50 border border-slate-800 rounded-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-700/50 pb-3">
          <h4 class="font-bold text-slate-200 text-sm">Otorisasi Active Menu</h4>
          <span class="text-xs bg-indigo-950 text-indigo-400 border border-indigo-800 px-2.5 py-0.5 rounded-full font-mono">RBAC Active</span>
        </div>
        <div class="space-y-2">
          <span class="text-xs text-slate-500 block">Assigned Roles</span>
          <div class="flex flex-wrap gap-2">
            <span v-for="role in user()?.roles" :key="role" class="px-2.5 py-1 bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 text-xs font-semibold rounded-lg">
              🛡️ {{ role }}
            </span>
          </div>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useAuth } from '@/Composables/useAuth';

const { user } = useAuth();
</script>