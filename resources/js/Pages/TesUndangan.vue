<template>
  <div class="min-h-screen bg-amber-50 flex flex-col items-center justify-center font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-xl text-center border border-amber-200 max-w-sm">
      
      <span class="text-xs font-bold tracking-widest text-amber-600 uppercase">The Wedding of</span>
      
      <h1 class="text-3xl font-serif font-bold text-slate-800 my-4">
        {{ namaPria }} & {{ namaWanita }}
      </h1>
      
      <p class="text-sm text-slate-500 leading-relaxed">
        Selamat datang! Halaman undangan digital ini sukses berjalan menggunakan sistem SPA (Single Page Application).
      </p>
      
    </div>
  </div>
</template>

<script setup>
// 1. Vue membentangkan kain layar untuk menangkap data dari Laravel
defineProps({
  namaPria: String,
  namaWanita: String
})

// 2. Variabel di atas sekarang otomatis "hidup" dan bisa dibaca di template HTML atas
</script>