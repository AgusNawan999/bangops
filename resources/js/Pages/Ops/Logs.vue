<template>
  <AuthenticatedLayout pageTitle="System Audit Logs">
    
    <!-- Search & Quick Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
      <div class="md:col-span-8 relative">
        <input 
          v-model="searchQuery" 
          type="text" 
          placeholder="Cari berdasarkan User, IP Address, atau Kota..." 
          class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 rounded-xl px-4 py-2.5 pl-10 text-xs text-slate-200 outline-none font-mono placeholder-slate-600"
        />
        <span class="absolute left-3.5 top-3 text-slate-500 text-xs">🔍</span>
      </div>
      <div class="md:col-span-4 flex justify-end items-center space-x-2 text-xs font-mono text-slate-400 bg-slate-800/40 border border-slate-800 px-4 py-2.5 rounded-xl">
        <span>Total Catatan:</span>
        <span class="text-emerald-400 font-bold">{{ logs?.total || logs?.data?.length || 0 }} Event</span>
      </div>
    </div>

    <!-- Audit Table Card -->
    <div class="bg-slate-800/50 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300 font-mono">
          <thead class="bg-slate-950 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
            <tr>
              <th class="px-5 py-3.5">Waktu Akses</th>
              <th class="px-5 py-3.5">Personel / Account</th>
              <th class="px-5 py-3.5">Metode Otentikasi</th>
              <th class="px-5 py-3.5">IP Address</th>
              <th class="px-5 py-3.5">Lokasi Terdeteksi</th>
              <th class="px-5 py-3.5">User Agent / Device</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60">
            <tr v-for="log in filteredLogs" :key="log.id" class="hover:bg-slate-800/40 transition">
              <td class="px-5 py-3.5 text-slate-400">{{ formatDate(log.login_at) }}</td>
              <td class="px-5 py-3.5">
                <div class="font-bold text-slate-100 font-sans">{{ log.user?.name || 'N/A' }}</div>
                <div class="text-[10px] text-slate-500">{{ log.user?.email || 'System' }}</div>
              </td>
              <td class="px-5 py-3.5">
                <span :class="['px-2 py-0.5 rounded text-[10px] font-bold uppercase border', log.login_method === 'google_sso' ? 'bg-blue-950/60 text-blue-400 border-blue-800/60' : 'bg-emerald-950/60 text-emerald-400 border-emerald-800/60']">
                  {{ log.login_method === 'google_sso' ? '🌐 Google SSO' : '🔑 Kredensial' }}
                </span>
              </td>
              <td class="px-5 py-3.5 text-slate-200">
                <span class="bg-slate-950 px-2 py-1 rounded border border-slate-800">{{ log.ip_address || '127.0.0.1' }}</span>
              </td>
              <td class="px-5 py-3.5">
                <div class="flex items-center space-x-1.5">
                  <span>📍</span>
                  <span class="text-slate-200 font-sans font-medium">{{ log.city || 'Unknown' }}, {{ log.country || 'Unknown' }}</span>
                </div>
              </td>
              <td class="px-5 py-3.5 text-slate-400 max-w-xs truncate">{{ parseUserAgent(log.user_agent) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  logs: Object,
});

const searchQuery = ref('');

const filteredLogs = computed(() => {
  const list = props.logs?.data || props.logs || [];
  if (!searchQuery.value) return list;
  const q = searchQuery.value.toLowerCase();
  return list.filter(item => 
    item.user?.name?.toLowerCase().includes(q) ||
    item.user?.email?.toLowerCase().includes(q) ||
    item.ip_address?.toLowerCase().includes(q)
  );
});

const formatDate = (d) => d ? new Date(d).toLocaleString('id-ID') : '-';
const parseUserAgent = (ua) => ua ? ua.substring(0, 30) + '...' : 'Unknown';
</script>