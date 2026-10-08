<template>
  <AuthenticatedLayout pageTitle="Roles & Permissions">
    
    <div class="space-y-6">
      <!-- Section Header -->
      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-xl font-bold text-white">🔐 Roles & Permissions Management</h3>
        <p class="text-xs text-slate-400">Atur hak akses peran (Role) dan alokasi master permission Spatie</p>
      </div>

      <!-- Main Layout Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Form Create/Edit Role -->
        <div class="lg:col-span-4 bg-slate-800/50 border border-slate-800 p-6 rounded-2xl h-fit space-y-4">
          <h4 class="text-sm font-bold text-slate-200">
            {{ isEditing ? '✏️ Edit Role' : '➕ Buat Role Baru' }}
          </h4>

          <form @submit.prevent="submit" class="space-y-4 text-xs">
            <div>
              <label class="block text-slate-400 mb-1">Nama Role</label>
              <input v-model="form.name" type="text" required placeholder="misal: operator" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-slate-100 outline-none focus:border-emerald-500 font-mono transition" />
            </div>

            <div>
              <label class="block text-slate-400 mb-2">Granted Permissions</label>
              <div class="space-y-2 max-h-52 overflow-y-auto p-3 bg-slate-950 border border-slate-800 rounded-xl font-mono">
                <label v-for="perm in permissions" :key="perm.id" class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-white">
                  <input type="checkbox" :value="perm.name" v-model="form.permissions" class="rounded bg-slate-900 border-slate-700 text-emerald-600 focus:ring-0" />
                  <span>{{ perm.name }}</span>
                </label>
              </div>
            </div>

            <div class="flex space-x-2 pt-2">
              <button type="submit" :disabled="form.processing" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-bold font-mono py-2 rounded-xl transition disabled:opacity-50">
                {{ isEditing ? 'Update Role' : 'Simpan Role' }}
              </button>
              <button v-if="isEditing" type="button" @click="resetForm" class="bg-slate-700 hover:bg-slate-600 text-slate-300 px-3 py-2 rounded-xl font-mono">
                Batal
              </button>
            </div>
          </form>
        </div>

        <!-- Table Master Roles -->
        <div class="lg:col-span-8 bg-slate-800/50 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
          <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-950 text-slate-400 uppercase text-[10px] font-mono tracking-wider border-b border-slate-800">
              <tr>
                <th class="px-5 py-3.5">Nama Role</th>
                <th class="px-5 py-3.5">Permissions Terhubung</th>
                <th class="px-5 py-3.5 text-right font-mono">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
              <tr v-for="role in roles" :key="role.id" class="hover:bg-slate-800/30 transition">
                <td class="px-5 py-3.5 font-bold text-slate-100 font-mono">{{ role.name }}</td>
                <td class="px-5 py-3.5">
                  <div class="flex flex-wrap gap-1.5">
                    <span v-for="p in role.permissions" :key="p.id" class="px-2 py-0.5 bg-slate-950 text-slate-300 text-[10px] rounded border border-slate-800 font-mono">
                      ✓ {{ p.name }}
                    </span>
                  </div>
                </td>
                <td class="px-5 py-3.5 text-right space-x-3 font-mono">
                  <button @click="editRole(role)" class="text-indigo-400 hover:underline">Edit</button>
                  <button @click="deleteRole(role.id)" class="text-red-400 hover:underline">Hapus</button>
                </td>
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
  roles: Array,
  permissions: Array,
});

const isEditing = ref(false);
const editingRoleId = ref(null);

const form = reactive({
  name: '',
  permissions: [],
  processing: false,
});

const editRole = (role) => {
  isEditing.value = true;
  editingRoleId.value = role.id;
  form.name = role.name;
  form.permissions = role.permissions.map(p => p.name);
};

const resetForm = () => {
  isEditing.value = false;
  editingRoleId.value = null;
  form.name = '';
  form.permissions = [];
};

const submit = () => {
  form.processing = true;
  if (isEditing.value) {
    router.put(`/admin/roles/${editingRoleId.value}`, form, {
      onSuccess: () => resetForm(),
      onFinish: () => { form.processing = false; },
    });
  } else {
    router.post('/admin/roles', form, {
      onSuccess: () => resetForm(),
      onFinish: () => { form.processing = false; },
    });
  }
};

const deleteRole = (id) => {
  if (confirm('Yakin ingin menghapus role ini?')) {
    router.delete(`/admin/roles/${id}`);
  }
};
</script>