<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

// Tangkap data undangan dari Controller
defineProps({
    invitations: Array,
});

const page = usePage();
const isCopied = ref(null); // mencatat ID undangan mana yang sedang di-copy

// Fungsi Salin Link Cepat untuk User di Dashboard
const copyDashboardLink = async (id, slug) => {
    const fullLink = `https://loventa.id/${slug}`;
    if (navigator.clipboard) {
        await navigator.clipboard.writeText(fullLink);
        isCopied.value = id;
        setTimeout(() => {
            isCopied.value = null;
        }, 2000);
    }
};

// Logika auto-hide notification flash session yang kita buat kemarin
const startNotificationTimer = () => {
    if (page.props.flash?.sukses_simpan) {
        setTimeout(() => {
            page.props.flash.sukses_simpan = null;
        }, 4000);
    }
};

onMounted(() => {
    startNotificationTimer();
});
watch(
    () => page.props.flash.sukses_simpan,
    () => {
        startNotificationTimer();
    },
);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="$page.props.flash && $page.props.flash.sukses_simpan"
                class="fixed top-5 right-5 z-50 flex items-center w-full max-w-sm p-4 text-slate-800 bg-white/90 backdrop-blur-md rounded-2xl border border-emerald-500/30 shadow-xl shadow-emerald-500/5"
            >
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-xl"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2.5"
                        stroke="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
                <div class="ml-3 text-sm font-medium">
                    <p class="font-bold text-slate-900">Berhasil Disimpan!</p>
                    <p class="text-xs text-slate-500">
                        {{ $page.props.flash.sukses_simpan }}
                    </p>
                </div>
                <button
                    type="button"
                    @click="$page.props.flash.sukses_simpan = null"
                    class="ml-auto -mx-1.5 -my-1.5 bg-transparent text-slate-400 hover:text-slate-900 rounded-lg p-1.5 inline-flex items-center h-8 w-8"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-4 h-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </transition>
        <template #header>
            <!-- 🟢 REVISI HEADER: Menata ulang grid text dan button agar responsive di mobile -->
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-center sm:text-left"
            >
                <!-- Bagian Kiri: Teks Sambutan -->
                <div class="space-y-1">
                    <h2 class="font-bold text-xl text-slate-800 leading-tight">
                        👋 Selamat Datang, {{ $page.props.auth.user.name }}!
                    </h2>

                    <!-- Bagian Badge Paket: Dibuat flex justify-center agar pas di HP tengah, di laptop kiri -->
                    <div
                        class="flex flex-wrap items-center justify-center sm:justify-start gap-2 text-xs text-slate-400"
                    >
                        <span
                            >Pantau dan kelola seluruh undangan digital Anda di
                            sini.</span
                        >

                        <span class="text-slate-300 hidden sm:inline">•</span>

                        <div class="flex items-center space-x-1">
                            <span>Paket Anda:</span>

                            <span
                                v-if="$page.props.auth.user.paket"
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wide uppercase transition-all"
                                :class="
                                    $page.props.auth.user.paket.nama_paket.toLowerCase() ===
                                    'premium'
                                        ? 'bg-emerald-50 text-emerald-600 border border-emerald-200/60 shadow-sm shadow-emerald-500/5'
                                        : 'bg-slate-100 text-slate-600 border border-slate-200'
                                "
                            >
                                <span
                                    v-if="
                                        $page.props.auth.user.paket.nama_paket.toLowerCase() ===
                                        'premium'
                                    "
                                    class="mr-1"
                                    >⚡</span
                                >
                                {{ $page.props.auth.user.paket.nama_paket }}
                            </span>

                            <span
                                v-else
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-wide"
                            >
                                Tanpa Paket
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Kanan: Tombol Buat Undangan Baru -->
                <!-- 🔴 FIX UTAMA: Mengganti tag <button> menjadi <Link> milik Inertia agar :href berfungsi,
             serta menambah w-full sm:w-auto agar di HP otomatis penuh & gampang diklik -->
                <Link
                    :href="route('invitation.index')"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-emerald-500/10 hover:opacity-90 transition-all duration-300 hover:scale-[1.01]"
                >
                    ➕ Buat Undangan Baru
                </Link>
            </div>
        </template>
        <div class="py-7">
            <!-- 🟢 BANNER UPGRADE PREMIUM (Hanya muncul jika v-if="!isPremium" alias akun FREE) -->
            <div class="py-6 px-4 sm:px-6 lg:px-8 overflow-hidden w-full">
                <div
                    v-if="!isPremium"
                    class="mb-6 mx-auto max-w-7xl animate-fade-in w-full"
                >
                    <div
                        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-5 sm:p-6 shadow-xl border border-slate-800 w-full"
                    >
                        <div
                            class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-emerald-500/10 blur-3xl"
                        ></div>
                        <div
                            class="absolute -left-10 -bottom-10 h-32 w-32 rounded-full bg-teal-500/10 blur-3xl"
                        ></div>

                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 relative z-10 text-center sm:text-left w-full"
                        >
                            <div class="space-y-2 w-full">
                                <div
                                    class="flex items-center justify-center sm:justify-start space-x-2"
                                >
                                    <span
                                        class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"
                                    ></span>
                                    <span
                                        class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20"
                                    >
                                        Rekomendasi Upgrade
                                    </span>
                                </div>
                                <h3
                                    class="text-sm sm:text-base font-bold text-white tracking-tight"
                                >
                                    Buka Fitur Sakti Loventa Premium! ⚡
                                </h3>
                                <p
                                    class="text-[11px] sm:text-xs text-slate-400 max-w-xl leading-relaxed mx-auto sm:mx-0"
                                >
                                    Akun Free memiliki batas kuota maksimal 2
                                    undangan dan URL acak. Upgrade sekarang
                                    untuk menikmati
                                    <span class="text-slate-200 font-semibold"
                                        >Bebas Kustomisasi URL Slug</span
                                    >,
                                    <span class="text-slate-200 font-semibold"
                                        >Tanpa Batas Kuota Undangan</span
                                    >, serta ratusan pilihan tema premium
                                    eksklusif!
                                </p>
                            </div>

                            <div
                                class="w-full sm:w-auto shrink-0 flex justify-center"
                            >
                                <Link
                                    href="#"
                                    class="w-full sm:w-auto block text-center px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-300 active:scale-95"
                                >
                                    Upgrade Sekarang 💎
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mx-auto max-w-7xl space-y-6 w-full"></div>
            </div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- 🟢 KONDISI 1: JIKA UNDANGAN MASIH KOSONG (EMPTY STATE) -->
                <div
                    v-if="invitations && invitations.length === 0"
                    class="p-12 text-center bg-white border border-slate-200 rounded-2xl shadow-sm max-w-2xl mx-auto"
                >
                    <div class="text-5xl mb-4">✉️</div>
                    <h3 class="font-bold text-slate-800 text-base">
                        Belum Ada Undangan Aktif
                    </h3>
                    <p
                        class="text-xs text-slate-400 mt-1.5 max-w-md mx-auto mb-6"
                    >
                        Anda belum menerbitkan undangan pernikahan digital
                        apapun saat ini. Yuk, mulai buat undangan pertamamu
                        sekarang!
                    </p>
                    <Link
                        :href="route('invitation.index')"
                        class="inline-flex px-6 py-3 bg-gradient-to-r from-slate-800 to-slate-900 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:opacity-90 transition-opacity shadow-sm"
                    >
                        Mulai Bikin Pertama ➔
                    </Link>
                </div>

                <!-- 🟢 KONDISI 2: JIKA UNDANGAN SUDAH ADA (MANAJEMEN KARTU GRID) -->
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    <div
                        v-for="invite in invitations"
                        :key="invite.id"
                        class="bg-white border border-slate-200/80 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between"
                    >
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md border border-emerald-200/50 uppercase"
                                >
                                    🎨Tema =
                                    {{
                                        invite.tema
                                            ? invite.tema.nama_tema
                                            : "Tema Pilihan"
                                    }}
                                </span>
                                <span
                                    class="text-[10px] text-slate-400 font-medium"
                                >
                                    {{
                                        new Date(
                                            invite.created_at,
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "short",
                                            year: "numeric",
                                        })
                                    }}
                                </span>
                            </div>

                            <h3
                                class="font-bold text-slate-800 text-base line-clamp-1"
                            >
                                {{ invite.nickname_pria }} &
                                {{ invite.nickname_wanita }}
                            </h3>

                            <p
                                class="text-xs font-semibold text-emerald-600 mt-1 select-all"
                            >
                                loventa.id/{{ invite.slug }}
                            </p>
                        </div>

                        <div
                            class="mt-6 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-2"
                        >
                            <!-- Kelompok Tombol Kiri (Mata, Edit, Hapus) -->
                            <div
                                class="flex items-center space-x-1.5 w-full sm:w-auto justify-start"
                            >
                                <a
                                    :href="`/undangan/${invite.slug}`"
                                    target="_blank"
                                    class="p-2 bg-slate-50 text-slate-500 hover:text-emerald-500 hover:bg-emerald-50 rounded-xl transition-colors border border-slate-200/40"
                                    title="Lihat Website"
                                >
                                    👁️
                                </a>

                                <Link
                                    :href="
                                        route('invitation.edit', invite.slug)
                                    "
                                    class="px-3 py-2 bg-slate-50 text-slate-600 hover:text-slate-900 font-bold text-xs rounded-xl transition-colors border border-slate-200/40"
                                >
                                    📝 Edit
                                </Link>

                                <button
                                    type="button"
                                    @click="deleteInvitation(invite)"
                                    class="p-2 bg-red-50 text-red-500 hover:text-red-700 hover:bg-red-100 rounded-xl transition-colors border border-red-200/30"
                                    title="Hapus Undangan"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-4 h-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <!-- Tombol Kanan (Copy) - Di HP otomatis melebar penuh biar gampang dipencet jempol -->
                            <button
                                type="button"
                                @click="
                                    copyDashboardLink(invite.id, invite.slug)
                                "
                                class="px-3 py-2 text-xs font-bold rounded-xl transition-all duration-300 flex items-center justify-center space-x-1 w-full sm:w-auto"
                                :class="
                                    isCopied === invite.id
                                        ? 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20'
                                        : 'bg-slate-800 text-white hover:bg-slate-700'
                                "
                            >
                                <span>{{
                                    isCopied === invite.id
                                        ? "✓ Copied"
                                        : "🔗 Copy"
                                }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
