<template>
  <AuthenticatedLayout pageTitle="User Management">
    
    <div class="space-y-6">
      <!-- Section Header -->
      <div class="border-b border-slate-800 pb-4">
        <h3 class="text-xl font-bold text-white">👥 User Management</h3>
        <p class="text-xs text-slate-400">Kelola akun pengguna sistem dan penugasan Role Spatie</p>
      </div>

      <!-- Main Layout Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Form Create/Edit User -->
        <div class="lg:col-span-4 bg-slate-800/50 border border-slate-800 p-6 rounded-2xl h-fit space-y-4">
          <h4 class="text-sm font-bold text-slate-200">
            {{ isEditing ? '✏️ Edit User' : '➕ Tambah User Baru' }}
          </h4>

          <form @submit.prevent="submit" class="space-y-4 text-xs">
            <div>
              <label class="block text-slate-400 mb-1">Nama Lengkap</label>
              <input v-model="form.name" type="text" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-slate-100 outline-none focus:border-emerald-500 transition" />
            </div>

            <div>
              <label class="block text-slate-400 mb-1">Email / NRP</label>
              <input v-model="form.email" type="email" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-slate-100 outline-none focus:border-emerald-500 transition" />
            </div>

            <div>
              <label class="block text-slate-400 mb-1">
                Password {{ isEditing ? '(Kosongkan jika tidak diganti)' : '' }}
              </label>
              <input v-model="form.password" type="password" :required="!isEditing" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-slate-100 outline-none focus:border-emerald-500 transition" />
            </div>

            <div>
              <label class="block text-slate-400 mb-1">Assign Role Spatie</label>
              <select v-model="form.role" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3.5 py-2 text-slate-100 outline-none focus:border-emerald-500 transition">
                <option value="" disabled>Pilih Role...</option>
                <option v-for="role in roles" :key="role.id" :value="role.name">
                  {{ role.name }}
                </option>
              </select>
            </div>

            <div class="flex space-x-2 pt-2">
              <button type="submit" :disabled="form.processing" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-bold font-mono py-2 rounded-xl transition disabled:opacity-50">
                {{ isEditing ? 'Update User' : 'Simpan User' }}
              </button>
              <button v-if="isEditing" type="button" @click="resetForm" class="bg-slate-700 hover:bg-slate-600 text-slate-300 px-3 py-2 rounded-xl font-mono">
                Batal
              </button>
            </div>
          </form>
        </div>

        <!-- Data Table Users -->
        <div class="lg:col-span-8 bg-slate-800/50 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
          <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-950 text-slate-400 uppercase text-[10px] font-mono tracking-wider border-b border-slate-800">
              <tr>
                <th class="px-5 py-3.5">Nama / Email</th>
                <th class="px-5 py-3.5">Assigned Role</th>
                <th class="px-5 py-3.5 text-right font-mono">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
              <tr v-for="user in users" :key="user.id" class="hover:bg-slate-800/30 transition">
                <td class="px-5 py-3.5">
                  <div class="font-bold text-slate-100">{{ user.name }}</div>
                  <div class="text-[10px] text-slate-500 font-mono">{{ user.email }}</div>
                </td>
                <td class="px-5 py-3.5">
                  <span v-for="role in user.roles" :key="role.id" class="px-2.5 py-1 bg-indigo-950/80 border border-indigo-800/60 text-indigo-400 rounded-lg text-[11px] font-mono font-semibold">
                    🛡️ {{ role.name }}
                  </span>
                </td>
                <td class="px-5 py-3.5 text-right space-x-3 font-mono">
                  <button @click="editUser(user)" class="text-indigo-400 hover:underline">Edit</button>
                  <button @click="deleteUser(user.id)" class="text-red-400 hover:underline">Hapus</button>
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
  users: Array,
  roles: Array,
});

const isEditing = ref(false);
const editingUserId = ref(null);

const form = reactive({
  name: '',
  email: '',
  password: '',
  role: '',
  processing: false,
});

const editUser = (user) => {
  isEditing.value = true;
  editingUserId.value = user.id;
  form.name = user.name;
  form.email = user.email;
  form.password = '';
  form.role = user.roles[0]?.name || '';
};

const resetForm = () => {
  isEditing.value = false;
  editingUserId.value = null;
  form.name = '';
  form.email = '';
  form.password = '';
  form.role = '';
};

const submit = () => {
  form.processing = true;
  if (isEditing.value) {
    router.put(`/admin/users/${editingUserId.value}`, form, {
      onSuccess: () => resetForm(),
      onFinish: () => { form.processing = false; },
    });
  } else {
    router.post('/admin/users', form, {
      onSuccess: () => resetForm(),
      onFinish: () => { form.processing = false; },
    });
  }
};

const deleteUser = (id) => {
  if (confirm('Yakin ingin menghapus user ini?')) {
    router.delete(`/admin/users/${id}`);
  }
};
</script>