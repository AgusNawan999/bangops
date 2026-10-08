<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between font-sans selection:bg-emerald-500 selection:text-slate-950">
    <!-- Tactical Top Bar / Header -->
    <header class="border-b border-slate-800 bg-slate-950/90 backdrop-blur sticky top-0 z-50 px-6 py-3.5 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="h-9 w-9 bg-emerald-600 rounded flex items-center justify-center font-mono font-bold text-slate-950 shadow-lg shadow-emerald-600/20 border border-emerald-400/40">
          C
        </div>
        <div>
          <div class="flex items-center space-x-2">
            <span class="text-base font-black tracking-widest text-white uppercase font-mono">CRIST</span>
            <span class="text-[10px] text-emerald-400 font-mono px-2 py-0.5 bg-emerald-950/80 rounded border border-emerald-800/60 font-semibold tracking-wider">SEC-LEVEL 4</span>
          </div>
          <p class="text-[10px] text-slate-500 font-mono">SATSIBER INTEGRATED OPERATIONS</p>
        </div>
      </div>
      
      <div class="flex items-center space-x-3 text-xs font-mono">
        <span class="hidden sm:inline-flex items-center space-x-1.5 text-slate-400">
          <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
          <span>SYSTEM ONLINE</span>
        </span>
        <a href="#login-section" class="px-3.5 py-1.5 bg-slate-900 border border-slate-700 hover:border-emerald-500 text-slate-200 hover:text-emerald-400 rounded transition font-medium">
          [ AUTHENTICATE ]
        </a>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
      
      <!-- Sisi Kiri: Strategic & Technical Specs -->
      <div class="lg:col-span-7 space-y-6">
        <div class="inline-flex items-center space-x-2 bg-emerald-950/60 border border-emerald-800/50 text-emerald-400 text-xs px-3 py-1 rounded font-mono">
          <span>🛡️ METS-COMPLIANT TACTICAL ENGINE</span>
        </div>
        
        <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight uppercase font-sans tracking-tight">
          Centralized Real-time Integrated Systems & Tracking (<span class="text-emerald-400">CRIST</span>)
        </h1>
        
        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
          Platform Pusat Kendali Operasi Siber & Infrastruktur Pertahanan Terpadu. Dirancang khusus untuk monitoring aset strategis, automasi skrip penanggulangan insiden, pengawasan jalur komunikasi, serta manajemen otorisasi ketat berbasis RBAC.
        </p>

        <!-- Feature Grid (Tactical Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 font-mono">
          <div class="p-3.5 bg-slate-900/60 border border-slate-800 rounded space-y-1">
            <div class="text-emerald-400 font-semibold text-xs flex items-center space-x-2">
              <span>🔒 ENCRYPTED AUTH & SSO</span>
            </div>
            <div class="text-slate-400 text-[11px]">Otorisasi SSO Google Workspace Terproteksi & Kredensial Terenkripsi.</div>
          </div>
          
          <div class="p-3.5 bg-slate-900/60 border border-slate-800 rounded space-y-1">
            <div class="text-emerald-400 font-semibold text-xs flex items-center space-x-2">
              <span>⚡ EXECUTION ENGINE</span>
            </div>
            <div class="text-slate-400 text-[11px]">Integrasi API Sanctum untuk otomatisasi skrip Python & respons insiden cepat.</div>
          </div>
        </div>
      </div>

      <!-- Sisi Kanan: Tactical Auth Panel -->
      <div id="login-section" class="lg:col-span-5 bg-slate-900/80 border border-slate-800 p-8 rounded-xl shadow-2xl backdrop-blur-sm relative">
        <div class="absolute -top-3 left-6 bg-emerald-950 text-emerald-400 border border-emerald-800 text-[10px] font-mono font-bold px-2.5 py-0.5 rounded tracking-widest uppercase">
          RESTRICTED ACCESS
        </div>

        <div class="mb-6 text-center space-y-1">
          <h2 class="text-xl font-bold text-white font-mono uppercase tracking-wider">Otorisasi Personel</h2>
          <p class="text-slate-400 text-xs">Otentikasi identitas untuk mengakses Command Center</p>
        </div>

        <!-- Google SSO Button -->
        <a 
          href="/auth/google/redirect" 
          class="w-full flex items-center justify-center space-x-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-100 font-mono text-xs font-semibold py-2.5 px-4 rounded transition duration-200 shadow-md mb-5"
        >
          <svg class="h-4 w-4" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
          </svg>
          <span>MASUK VIA GOOGLE WORKSPACE</span>
        </a>

        <!-- Divider -->
        <div class="relative my-5 flex items-center justify-center">
          <div class="border-t border-slate-800 w-full"></div>
          <span class="bg-slate-900 px-3 text-[10px] text-slate-500 font-mono uppercase tracking-widest absolute">atau Kredensial</span>
        </div>

        <!-- Form Login Manual -->
        <form @submit.prevent="submit" class="space-y-4 font-sans">
          <div>
            <label class="block text-xs font-mono text-slate-300 mb-1">NRP / Alamat Email</label>
            <input 
              v-model="form.email" 
              type="email" 
              required 
              placeholder="operator@ops.local"
              class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded px-3.5 py-2 text-xs text-slate-100 placeholder-slate-600 outline-none transition font-mono"
            />
          </div>

          <div>
            <label class="block text-xs font-mono text-slate-300 mb-1">Kata Sandi / Kunci Akses</label>
            <input 
              v-model="form.password" 
              type="password" 
              required 
              placeholder="••••••••"
              class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded px-3.5 py-2 text-xs text-slate-100 placeholder-slate-600 outline-none transition font-mono"
            />
          </div>

          <div class="flex items-center justify-between text-xs text-slate-400 font-mono">
            <label class="flex items-center space-x-2 cursor-pointer">
              <input type="checkbox" v-model="form.remember" class="rounded bg-slate-950 border-slate-800 text-emerald-600 focus:ring-0">
              <span class="text-[11px]">Ingat Sesi Ini</span>
            </label>
          </div>

          <button 
            type="submit" 
            :disabled="form.processing"
            class="w-full bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-mono font-bold text-xs py-2.5 px-4 rounded transition duration-200 shadow-lg shadow-emerald-600/20 disabled:opacity-50 tracking-wider uppercase"
          >
            OTORISASI MASUK →
          </button>
        </form>
      </div>

    </main>

    <!-- Footer Status -->
    <footer class="border-t border-slate-900 py-3 px-6 text-center text-[11px] font-mono text-slate-600 flex flex-col sm:flex-row justify-between items-center gap-2">
      <div>CRIST COMMAND PLATFORM &copy; 2026 SATSIBER OPERATIONAL DIVISION</div>
      <div class="text-emerald-500/70">STATUS: ENCRYPTED / ALL SYSTEMS NOMINAL</div>
    </footer>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const form = reactive({
  email: '',
  password: '',
  remember: false,
  processing: false,
});

const submit = () => {
  form.processing = true;
  router.post('/login', form, {
    onFinish: () => {
      form.processing = false;
    },
  });
};
</script>