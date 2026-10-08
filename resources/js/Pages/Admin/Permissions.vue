<template>
  <AuthenticatedLayout pageTitle="Permission Management">
    
    <div class="space-y-6">
      <!-- Section Header -->
      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-xl font-bold text-white">🔑 Permission Master</h3>
        <p class="text-xs text-slate-400">Kelola master nama fitur akses / permission Spatie untuk sistem CRIST</p>
      </div>

      <!-- Main Layout Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Form Create/Edit Permission -->
        <div class="lg:col-span-4 bg-slate-800/50 border border-slate-800 p-6 rounded-2xl h-fit space-y-4">
          <h4 class="text-sm font-bold text-slate-200">
            {{ isEditing ? '✏️ Edit Fitur Akses' : '➕ Buat Fitur Akses Baru' }}
          </h4>

          <form @submit.prevent="submit" class="space-y-4 text-xs">
            <div>
              <label class="block text-slate-400 mb-1">Nama Permission</label>
              <input 
                v-model="form.name" 
                type="text" 
                required 
                placeholder="contoh: execute operations" 
                class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-slate-100 outline-none focus:border-emerald-500 font-mono transition"
              />
              <span class="text-[10px] text-slate-500 mt-1 block">Gunakan huruf kecil (misal: manage system)</span>
            </div>

            <div class="flex space-x-2 pt-2">
              <button 
                type="submit" 
                :disabled="form.processing" 
                class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-bold font-mono py-2 rounded-xl transition disabled:opacity-50"
              >
                {{ isEditing ? 'Update Permission' : 'Simpan Permission' }}
              </button>
              <button 
                v-if="isEditing" 
                type="button" 
                @click="resetForm" 
                class="bg-slate-700 hover:bg-slate-600 text-slate-300 px-3 py-2 rounded-xl font-mono"
              >
                Batal
              </button>
            </div>
          </form>
        </div>

        <!-- Table Master Permissions -->
        <div class="lg:col-span-8 bg-slate-800/50 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
          <table class="w-full text-left text-xs text-slate-300 font-mono">
            <thead class="bg-slate-950 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
              <tr>
                <th class="px-5 py-3.5">ID</th>
                <th class="px-5 py-3.5">Nama Fitur Akses (Permission)</th>
                <th class="px-5 py-3.5 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
              <tr v-for="permission in permissions" :key="permission.id" class="hover:bg-slate-800/30 transition">
                <td class="px-5 py-3.5 text-slate-500">#{{ permission.id }}</td>
                <td class="px-5 py-3.5">
                  <span class="px-2.5 py-1 bg-slate-950 border border-slate-800 text-slate-200 rounded-lg text-[11px]">
                    ✓ {{ permission.name }}
                  </span>
                </td>
                <td class="px-5 py-3.5 text-right space-x-3">
                  <button @click="editPermission(permission)" class="text-indigo-400 hover:underline">Edit</button>
                  <button @click="deletePermission(permission.id)" class="text-red-400 hover:underline">Hapus</button>
                </td>
              </tr>
              <tr v-if="permissions.length === 0">
                <td colspan="3" class="px-5 py-6 text-center text-slate-500">Belum ada permission terdaftar.</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </AuthenticatedLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  permissions: Array,
});

const isEditing = ref(false);
const editingPermissionId = ref(null);

const form = reactive({
  name: '',
  processing: false,
});

const editPermission = (perm) => {
  isEditing.value = true;
  editingPermissionId.value = perm.id;
  form.name = perm.name;
};

const resetForm = () => {
  isEditing.value = false;
  editingPermissionId.value = null;
  form.name = '';
};

const submit = () => {
  form.processing = true;
  if (isEditing.value) {
    router.put(`/admin/permissions/${editingPermissionId.value}`, form, {
      onSuccess: () => resetForm(),
      onFinish: () => { form.processing = false; },
    });
  } else {
    router.post('/admin/permissions', form, {
      onSuccess: () => resetForm(),
      onFinish: () => { form.processing = false; },
    });
  }
};

const deletePermission = (id) => {
  if (confirm('Yakin ingin menghapus permission ini?')) {
    router.delete(`/admin/permissions/${id}`);
  }
};
</script>