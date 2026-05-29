<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
// 🔴 1. PENTING: Import 'watch' dari vue agar kita bisa pakai fungsi pengawas
import { ref, watch } from "vue";

const activeTab = ref(1);

const isPremium = ref(false);

const filterManualSlug = (event) => {
    // Jika bukan premium, biarkan watcher otomatis yang bekerja
    if (!isPremium.value) return;

    const rawValue = event.target.value;

    // Filter langsung: Ubah ke huruf kecil, ganti spasi jadi strip, dan hapus karakter aneh
    form.slug = rawValue
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, "") // hapus selain huruf, angka, spasi, minus
        .replace(/\s+/g, "-") // semua spasi jadi 1 minus
        .replace(/-+/g, "-"); // minus dobel jadi 1 minus
};

defineProps({
    daftar_tema: Array,
});

// Objek form lengkap sesuai request-mu
const form = useForm({
    // data tab 1 (tema)
    tema_id: "",

    // data tab 2 (mempelai & slug)
    slug: "",
    fullname_pria: "",
    nickname_pria: "",
    fullname_wanita: "",
    nickname_wanita: "",
    ayah_pria: "",
    ibu_pria: "",
    ayah_wanita: "",
    ibu_wanita: "",

    // data tab 3 (waktu)

    waktu_akad: "",
    waktu_resepsi: "",
    lokasi_akad: "",
    lokasi_resepsi: "",
    link_map_akad: "",
    link_map_resepsi: "",
});

watch(
    () => [form.nickname_pria, form.nickname_wanita],
    ([newPria, newWanita]) => {
        if (isPremium.value) return;
        const pria = newPria ? newPria.trim() : "";
        const wanita = newWanita ? newWanita.trim() : "";
        const combined = `${pria} ${wanita}`.trim();

        if (combined) {
            let baseSlug = combined
                .toLowerCase()
                .replace(/[^a-z0-9 ]/g, "")
                .replace(/\s+/g, "-");

            // 🟢 Otomatis tambahkan 3 angka acak di belakang agar meminimalisir duplikat
            // Misal hasil akhirnya: irfan-reza-482
            const randomNumber = Math.floor(100 + Math.random() * 900);

            form.slug = `${baseSlug}-${randomNumber}`;
        } else {
            form.slug = "";
        }
    },
);
const showNotification = ref(false);

const submit = () => {
    form.post(route("invitation.store"), {
        onSuccess: () => {
            showNotification.value = true;
            setTimeout(() => {
                showNotification.value = false;
            }, 4000);
        },
    });
};
</script>
<template>
    <Head title="Buat Undangan Baru" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                ✉️ Buat Undangan Baru
            </h2>
            <p class="text-xs text-slate-400 mt-1">
                Kelola dan isi detail undangan digital Anda langkah demi
                langkah.
            </p>
        </template>

        <div class="py-2">
            <div
                class="flex space-x-2 mb-6 bg-slate-200/60 p-1.5 rounded-2xl w-fit backdrop-blur-sm border border-slate-200/20"
            >
                <button
                    type="button"
                    @click="activeTab = 1"
                    :class="
                        activeTab === 1
                            ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/10'
                            : 'text-slate-600 hover:bg-white/50'
                    "
                    class="px-5 py-2.5 font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-300"
                >
                    🎨 Tema
                </button>
                <button
                    type="button"
                    @click="activeTab = 2"
                    :class="
                        activeTab === 2
                            ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/10'
                            : 'text-slate-600 hover:bg-white/50'
                    "
                    class="px-5 py-2.5 font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-300"
                >
                    💍 Mempelai
                </button>
                <button
                    type="button"
                    @click="activeTab = 3"
                    :class="
                        activeTab === 3
                            ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/10'
                            : 'text-slate-600 hover:bg-white/50'
                    "
                    class="px-5 py-2.5 font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-300"
                >
                    🗓️ Waktu & Lokasi
                </button>
            </div>
            <div
                class="bg-slate-50/80 p-5 rounded-xl border border-slate-200/60 mb-6"
            >
                <div class="flex items-center justify-between mb-2">
                    <InputLabel
                        for="slug"
                        value="Link URL Undangan"
                        class="!mb-0"
                        :class="[
                            { '!pr-12': isPasswordType },
                            $attrs.disabled
                                ? 'cursor-not-allowed'
                                : 'cursor-text',
                        ]"
                    />

                    <!-- Badge Indikator Paket -->
                    <span
                        v-if="!isPremium"
                        class="px-2.5 py-0.5 bg-amber-500/10 text-amber-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-amber-500/20"
                    >
                        🔒 Fitur Premium (Locked)
                    </span>
                    <span
                        v-else
                        class="px-2.5 py-0.5 bg-emerald-500/10 text-emerald-600 text-[10px] font-bold uppercase tracking-wider rounded-full border border-emerald-500/20 animate-pulse"
                    >
                        ✨ Premium Active (Unlocked)
                    </span>
                </div>

                <div class="relative flex items-center group">
                    <!-- Teks Domain loventa.id/ di dalam inputan -->
                    <span
                        class="absolute left-4 text-sm font-semibold text-slate-400 select-none"
                    >
                        loventa.id/
                    </span>

                    <!-- Input Slug yang di-Disabled -->
                    <!-- Kita tambahkan kelas bg-slate-100/70 dan cursor-not-allowed agar terlihat terkunci -->
                    <TextInput
                        id="slug"
                        type="text"
                        class="mt-1 block w-full !pl-24 bg-slate-100/70 cursor-not-allowed text-slate-400 select-none font-medium"
                        :class="
                            !isPremium
                                ? 'bg-slate-100/70 cursor-not-allowed text-slate-400 select-none font-medium'
                                : 'bg-white text-slate-800'
                        "
                        v-model="form.slug"
                        :disabled="!isPremium"
                        placeholder="otomatis-terisi-dari-nama"
                        @input="filterManualSlug"
                    />
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">
                    *URL di atas dibuat otomatis berdasarkan nama panggilan.
                    Upgrade ke <b>Paket Premium</b> untuk mengubah link sesuai
                    keinginan Anda.
                </p>
                <div
                    class="mt-3 pt-3 border-t border-dashed border-slate-200 flex items-center justify-between"
                >
                    <p class="text-[11px] text-slate-400">
                        <span v-if="!isPremium"
                            >*Gunakan tombol di kanan untuk menguji coba hak
                            akses kustomisasi URL.</span
                        >
                        <span v-else class="text-emerald-600 font-semibold"
                            >✓ Anda bebas mengubah kombinasi teks slug URL di
                            atas secara mandiri!</span
                        >
                    </p>

                    <button
                        type="button"
                        @click="isPremium = !isPremium"
                        class="px-3 py-1 text-[10px] font-bold rounded-lg border transition-all duration-300"
                        :class="
                            isPremium
                                ? 'bg-amber-500 text-white border-amber-600'
                                : 'bg-slate-800 text-white border-slate-900'
                        "
                    >
                        {{
                            isPremium
                                ? "⬇️ Downgrade ke Gratis"
                                : "⚡ Simulasikan Premium"
                        }}
                    </button>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div
                    v-show="activeTab === 1"
                    class="bg-white/70 backdrop-blur-md border border-slate-200/60 p-6 sm:p-8 rounded-2xl shadow-sm space-y-6 animate-fade-in"
                >
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-800">
                            Desain & Tema Undangan
                        </h3>
                    </div>

                    <div class="max-w-md">
                        <InputLabel value="Pilih Tema Undangan" />
                        <select
                            v-model="form.tema_id"
                            class="w-full mt-1 px-4 py-3 bg-white text-slate-800 rounded-xl border border-slate-200 shadow-sm outline-none transition-all duration-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30"
                        >
                            <option value="">-- Pilih Tema Undangan --</option>

                            <option
                                v-for="temas in daftar_tema"
                                :key="temas.id"
                                :value="temas.id"
                            >
                                {{ temas.nama_tema }}
                                {{ temas.is_premium ? "(Premium)" : "(Free)" }}
                            </option>
                        </select>
                    </div>
                    <div
                        class="flex justify-end pt-4 border-t border-slate-100"
                    >
                        <SecondaryButton type="button" @click="activeTab = 2"
                            >Lanjutkan ➔</SecondaryButton
                        >
                    </div>

                    <div
                        class="flex justify-between pt-6 border-t border-slate-100"
                    ></div>
                </div>
                <div
                    v-show="activeTab === 2"
                    class="bg-white/70 backdrop-blur-md border border-slate-200/60 p-6 sm:p-8 rounded-2xl shadow-sm space-y-6 animate-fade-in"
                >
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-800">
                            Identitas Calon Mempelai
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div
                            class="space-y-4 bg-slate-50/50 p-5 rounded-xl border border-slate-100"
                        >
                            <h4
                                class="font-bold text-xs text-emerald-600 uppercase tracking-wider"
                            >
                                🤵‍♂️ Mempelai Pria
                            </h4>
                            <div>
                                <InputLabel
                                    for="pria_name"
                                    value="Nama Lengkap Pria"
                                />
                                <TextInput
                                    id="pria_name"
                                    v-model="form.fullname_pria"
                                    required
                                    placeholder="Nama lengkap + gelar..."
                                />
                            </div>
                            <div>
                                <InputLabel
                                    for="pria_nickname"
                                    value="Nama Panggilan"
                                />
                                <TextInput
                                    id="pria_nickname"
                                    v-model="form.nickname_pria"
                                    required
                                    placeholder="Nama panggilan..."
                                />
                            </div>
                            <div>
                                <InputLabel for="pria_ayah" value="Nama Ayah" />
                                <TextInput
                                    id="pria_ayah"
                                    v-model="form.ayah_pria"
                                    required
                                    placeholder="Nama ayah..."
                                />
                            </div>
                            <div>
                                <InputLabel for="pria_ibu" value="Nama Ibu" />
                                <TextInput
                                    id="pria_ibu"
                                    v-model="form.ibu_pria"
                                    required
                                    placeholder="Nama ibu..."
                                />
                            </div>
                        </div>

                        <div
                            class="space-y-4 bg-slate-50/50 p-5 rounded-xl border border-slate-100"
                        >
                            <h4
                                class="font-bold text-xs text-emerald-600 uppercase tracking-wider"
                            >
                                👰‍♀️ Mempelai Wanita
                            </h4>
                            <div>
                                <InputLabel
                                    for="wanita_name"
                                    value="Nama Lengkap Wanita"
                                />
                                <TextInput
                                    id="wanita_name"
                                    v-model="form.fullname_wanita"
                                    required
                                    placeholder="Nama lengkap + gelar..."
                                />
                            </div>
                            <div>
                                <InputLabel
                                    for="wanita_nickname"
                                    value="Nama Panggilan"
                                />
                                <TextInput
                                    id="wanita_nickname"
                                    v-model="form.nickname_wanita"
                                    required
                                    placeholder="Nama panggilan..."
                                />
                            </div>
                            <div>
                                <InputLabel
                                    for="wanita_ayah"
                                    value="Nama Ayah"
                                />
                                <TextInput
                                    id="wanita_ayah"
                                    v-model="form.ayah_wanita"
                                    required
                                    placeholder="Nama ayah..."
                                />
                            </div>
                            <div>
                                <InputLabel for="wanita_ibu" value="Nama Ibu" />
                                <TextInput
                                    id="wanita_ibu"
                                    v-model="form.ibu_wanita"
                                    required
                                    placeholder="Nama ibu..."
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex justify-between pt-4 border-t border-slate-100"
                    >
                        <SecondaryButton type="button" @click="activeTab = 1"
                            >⬅ Kembali</SecondaryButton
                        >
                        <SecondaryButton type="button" @click="activeTab = 3"
                            >Lanjutkan ➔</SecondaryButton
                        >
                    </div>
                </div>

                <div
                    v-show="activeTab === 3"
                    class="bg-white/70 backdrop-blur-md border border-slate-200/60 p-6 sm:p-8 rounded-2xl shadow-sm space-y-6 animate-fade-in"
                >
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-800">
                            Detail Jadwal & Tempat Acara
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div
                            class="space-y-4 bg-slate-50/50 p-5 rounded-xl border border-slate-100"
                        >
                            <h4
                                class="font-bold text-xs text-teal-600 uppercase tracking-wider"
                            >
                                🕋 Akad Nikah
                            </h4>
                            <div>
                                <div>
                                    <InputLabel value="Tanggal & Jam akad" />
                                    <TextInput
                                        type="datetime-local"
                                        v-model="form.akad_date"
                                        required
                                    />
                                </div>
                            </div>
                            <div>
                                <InputLabel value="Tempat / Alamat Lokasi" />
                                <TextInput
                                    v-model="form.lokasi_akad"
                                    required
                                    placeholder="Misal: Masjid Agung, atau Rumah Mempelai..."
                                />
                            </div>
                            <div>
                                <InputLabel
                                    value="Link Google Maps Tempat Akad"
                                />
                                <TextInput
                                    v-model="form.link_map_akad"
                                    placeholder="https://maps.google.com/..."
                                />
                            </div>
                        </div>

                        <div
                            class="space-y-4 bg-slate-50/50 p-5 rounded-xl border border-slate-100"
                        >
                            <h4
                                class="font-bold text-xs text-teal-600 uppercase tracking-wider"
                            >
                                🎉 Resepsi Pernikahan
                            </h4>
                            <div>
                                <div>
                                    <InputLabel value="Tanggal & Jam Resepsi" />
                                    <TextInput
                                        type="datetime-local"
                                        v-model="form.waktu_resepsi"
                                        required
                                    />
                                </div>
                            </div>
                            <div>
                                <InputLabel value="Tempat / Alamat Lokasi" />
                                <TextInput
                                    v-model="form.lokasi_resepsi"
                                    required
                                    placeholder="Misal: Gedung Serbaguna..."
                                />
                            </div>
                            <div>
                                <InputLabel
                                    value="Link Google Maps Tempat Resepsi"
                                />
                                <TextInput
                                    v-model="form.link_map_resepsi"
                                    placeholder="https://maps.google.com/..."
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex justify-between pt-4 border-t border-slate-100"
                    >
                        <SecondaryButton type="button" @click="activeTab = 2"
                            >⬅ Kembali</SecondaryButton
                        >
                        <PrimaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            class="px-8 shadow-lg shadow-emerald-500/20"
                        >
                            🚀 Simpan & Terbitkan Undangan
                        </PrimaryButton>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Animasi Fade In Lembut Saat Pindah Tab */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in {
    animation: fadeIn 0.4s ease-out forwards;
}
</style>
