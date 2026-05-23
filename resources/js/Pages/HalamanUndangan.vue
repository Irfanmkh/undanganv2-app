<template>
  <div class="min-h-screen bg-slate-50 py-12 px-4 font-sans">
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden">
      
      <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-center text-white">
        <span class="text-xs uppercase tracking-widest opacity-80">Wedding Invitation</span>
        <h1 class="text-2xl font-serif font-bold mt-1">{{ namaPengantinPria }} & {{ namaPengantinWanita }}</h1>
      </div>

      <form @submit.prevent="kirimRsvp" class="p-6 space-y-4">
        <h3 class="text-lg font-semibold text-slate-800 border-b pb-2">Konfirmasi Kehadiran</h3>

        <div>
          <label class="block text-xs font-medium text-slate-600 uppercase mb-1">Nama Tamu</label>
          <input type="text" v-model="form.nama_tamu" required
                 class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" 
                 placeholder="Masukkan nama Anda">
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-600 uppercase mb-1">Apakah Akan Hadir?</label>
          <select v-model="form.status_kehadiran" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
            <option value="Hadir">Ya, Saya Hadir</option>
            <option value="Tidak Hadir">Maaf, Tidak Bisa Hadir</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-600 uppercase mb-1">Jumlah Rombongan</label>
          <input type="number" v-model="form.jumlah_rombongan" min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-600 uppercase mb-1">Doa & Ucapan</label>
          <textarea v-model="form.catatan_ucapan" rows="3" required
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500" 
                    placeholder="Tulis ucapan selamat Anda..."></textarea>
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-semibold text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition duration-150 ease-in-out">
              <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
              </svg>
              Kirim Ucapan & RSVP
            </button>
        </div>
        </form>

    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'

// Tangkap Props dari Laravel
defineProps({
  slug: String,
  namaPengantinPria: String,
  namaPengantinWanita: String
})

// Variabel Form Reactive (Two-Way Binding v-model)
const form = reactive({
  nama_tamu: '',
  status_kehadiran: 'Hadir',
  jumlah_rombongan: 1,
  catatan_ucapan: ''
})

// Fungsi Kirim Form
const kirimRsvp = () => {
  // Alert sementara untuk ngetes data v-model
  alert(`✅ MENGIRIM DATA!\n---------------------\nNama: ${form.nama_tamu}\nStatus: ${form.status_kehadiran}\nUcapan: ${form.catatan_ucapan}`);
}
</script>