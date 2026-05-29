<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

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
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
            >
                <div>
                    <h2 class="font-bold text-xl text-slate-800 leading-tight">
                        👋 Selamat Datang, {{ $page.props.auth.user.name }}!
                    </h2>

                    <div
                        class="flex flex-wrap items-center gap-2 text-xs text-slate-400"
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
                <Link
                    :href="route('invitation.index')"
                    class="w-fit inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md shadow-emerald-500/10 hover:opacity-90 transition-all duration-300"
                >
                    ➕ Buat Undangan Baru
                </Link>
            </div>
        </template>

        <div class="py-12">
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
                                    class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md border border-emerald-200/50"
                                >
                                    🎨
                                    {{
                                        invite.theme
                                            ? invite.theme.nama_tema
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
                            class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-2"
                        >
                            <div class="flex items-center space-x-1.5">
                                <a
                                    :href="`/undangan/${invite.slug}`"
                                    target="_blank"
                                    class="p-2 bg-slate-50 text-slate-500 hover:text-emerald-500 hover:bg-emerald-50 rounded-xl transition-colors border border-slate-200/40"
                                    title="Lihat Website"
                                >
                                    👁️
                                </a>
                                <Link
                                    :href="route('invitation.index')"
                                    class="px-3 py-2 bg-slate-50 text-slate-600 hover:text-slate-900 font-bold text-xs rounded-xl transition-colors border border-slate-200/40"
                                >
                                    📝 Edit
                                </Link>
                            </div>

                            <button
                                type="button"
                                @click="
                                    copyDashboardLink(invite.id, invite.slug)
                                "
                                class="px-3 py-2 text-xs font-bold rounded-xl transition-all duration-300 flex items-center space-x-1"
                                :class="
                                    isCopied === invite.id
                                        ? 'bg-emerald-500/10 text-emerald-600'
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
