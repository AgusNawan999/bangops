<template>
  <div class="min-h-screen bg-slate-900 text-slate-100 flex font-sans">
    
    <!-- Sidebar Component -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between p-4 shrink-0">
      <div class="space-y-6">
        
        <!-- App Brand -->
        <div class="flex items-center space-x-3 px-2 py-1">
          <div class="h-9 w-9 bg-emerald-600 rounded-lg flex items-center justify-center font-bold text-slate-950 shadow-lg shadow-emerald-500/20 border border-emerald-400/30">
            C
          </div>
          <div>
            <h1 class="text-base font-bold tracking-wider text-white leading-none">CRIST OPS</h1>
            <span class="text-[10px] text-slate-500 font-mono font-bold tracking-wider">OPERATIONS PLATFORM</span>
          </div>
        </div>

        <!-- Dynamic Menu Loop -->
        <nav class="space-y-4">
          <div v-for="(group, gIdx) in filteredNavigation" :key="gIdx" class="space-y-1">
            <div v-if="group.title" class="px-3 text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">
              {{ group.title }}
            </div>

            <Link 
              v-for="item in group.items" 
              :key="item.href" 
              :href="item.href"
              :class="[
                'flex items-center space-x-3 px-3 py-2 rounded-xl text-sm transition',
                isUrl(item.href) 
                  ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 font-medium' 
                  : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900'
              ]"
            >
              <span>{{ item.icon }}</span>
              <span>{{ item.label }}</span>
            </Link>
          </div>
        </nav>

      </div>

      <!-- User Footer Card -->
      <div class="border-t border-slate-800 pt-3">
        <div class="flex items-center justify-between px-2 py-1">
          <div class="truncate">
            <p class="text-xs font-semibold text-slate-200 truncate">{{ user()?.name || 'Operator' }}</p>
            <p class="text-[10px] text-slate-500 truncate">{{ user()?.email }}</p>
          </div>
          <button 
            @click="handleLogout" 
            type="button" 
            class="text-slate-400 hover:text-red-400 p-1.5 rounded-lg hover:bg-slate-900 transition" 
            title="Logout"
          >
            🚪
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
      
      <!-- Top Header -->
      <header class="h-16 border-b border-slate-800 bg-slate-900/50 backdrop-blur px-8 flex items-center justify-between sticky top-0 z-10">
        <h2 class="text-lg font-bold text-white font-mono uppercase tracking-wider">
          {{ pageTitle }}
        </h2>
        <div class="flex items-center space-x-2 font-mono text-xs">
          <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
          <span class="text-slate-400">SYSTEM ONLINE</span>
        </div>
      </header>

      <!-- Slot for Page Content -->
      <main class="p-8 space-y-6 max-w-7xl">
        <slot />
      </main>

    </div>

  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { useAuth } from '@/Composables/useAuth';

defineProps({
  pageTitle: {
    type: String,
    default: 'Beranda Operasional'
  }
});

const { user, hasRole, hasPermission } = useAuth();
const page = usePage();

const isUrl = (url) => page.url === url;

const handleLogout = () => router.post('/logout');

// Master Array Navigasi Sidebar (Cukup Ubah/Tambah Di Sini)
const navigationConfig = [
  {
    title: 'Main Menu',
    items: [
      { label: 'Beranda Profile', href: '/dashboard', icon: '📊' },
    ]
  },
  {
    title: 'Administrator',
    role: 'admin',
    items: [
      { label: 'User Management', href: '/admin/users', icon: '👥' },
      { label: 'Roles & Permissions', href: '/admin/roles', icon: '🔐' },
      { label: 'Permission Master', href: '/admin/permissions', icon: '🔑' },
      { label: 'System Settings', href: '/admin/settings', icon: '⚙️', permission: 'manage system' },
    ]
  },
  {
    title: 'Ops Control',
    permission: ['execute operations', 'operations control center', 'read operations'],
    items: [
      { label: 'Execution Engine', href: '/ops/execution', icon: '🚀', permission: 'execute operations' },
      { label: 'Operations Center', href: '/ops/control-center', icon: '🎛️', permission: 'operations control center' },
      { label: 'System Logs', href: '/ops/logs', icon: '📜', permission: 'read operations' },
    ]
  }
];

// Computed Property untuk memfilter menu berdasarkan RBAC Spatie
const filteredNavigation = computed(() => {
  return navigationConfig
    .filter(group => {
      if (group.role && !hasRole(group.role)) return false;
      if (group.permission && !hasPermission(group.permission)) return false;
      return true;
    })
    .map(group => ({
      ...group,
      items: group.items.filter(item => {
        if (item.role && !hasRole(item.role)) return false;
        if (item.permission && !hasPermission(item.permission)) return false;
        return true;
      })
    }))
    .filter(group => group.items.length > 0);
});
</script>