<script setup>
import { ref } from "vue"; // 🟢 KUNCI UTAMA: Pastikan 'ref' ini ter-import resmi dari vue!
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

// 🟢 Nyalakan status kontrol buka-tutup sidebar
const isSidebarOpen = ref(false);

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div
        class="min-h-screen bg-slate-50 transition-all duration-300 text-slate-800 relative"
    >
        <div class="fixed top-3.5 left-4 z-50 md:hidden">
            <button
                type="button"
                @click="isSidebarOpen = !isSidebarOpen"
                class="p-2 rounded-xl bg-white/90 backdrop-blur-md text-slate-600 shadow-sm border border-slate-200/80 focus:outline-none active:scale-95 transition-all"
            >
                <svg
                    v-if="!isSidebarOpen"
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
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    />
                </svg>
                <svg
                    v-else
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
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>

        <aside
            class="w-64 bg-white/90 backdrop-blur-md border-r border-slate-200/60 fixed h-full z-40 flex flex-col justify-between transition-transform duration-300 -translate-x-full md:translate-x-0"
            :class="
                isSidebarOpen
                    ? 'translate-x-0 shadow-2xl shadow-slate-900/10'
                    : '-translate-x-full'
            "
        >
            <div>
                <div
                    class="h-16 flex items-center px-6 border-b border-slate-100"
                >
                    <Link
                        :href="route('dashboard')"
                        class="flex items-center space-x-3 group"
                    >
                        <ApplicationLogo
                            class="block h-9 w-auto fill-current text-emerald-500 transition-transform duration-300 group-hover:rotate-12"
                        />
                        <span
                            class="text-lg font-bold tracking-wider bg-gradient-to-r from-emerald-500 to-cyan-500 bg-clip-text text-transparent uppercase"
                            >Loventa</span
                        >
                    </Link>
                </div>

                <nav
                    class="mt-6 px-4 space-y-2 flex-1"
                    @click="isSidebarOpen = false"
                >
                    <div
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 mb-2"
                    >
                        Menu Utama
                    </div>

                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="w-full"
                    >
                        <span class="mr-3 text-base">📊</span> Dashboard
                    </NavLink>

                    <NavLink
                        :href="route('invitation.index')"
                        :active="route().current('invitation.index')"
                        class="w-full"
                    >
                        <span class="mr-3 text-base">✉️</span> Invitations Form
                    </NavLink>
                </nav>
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <div class="relative">
                    <Dropdown align="top" width="48">
                        <template #trigger>
                            <button
                                type="button"
                                class="inline-flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 rounded-xl transition-colors duration-200 outline-none"
                            >
                                <div
                                    class="flex items-center space-x-3 text-left"
                                >
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-400 to-cyan-500 text-white flex items-center justify-center font-bold text-xs shadow-sm uppercase"
                                    >
                                        {{
                                            $page.props.auth.user.name.substring(
                                                0,
                                                2,
                                            )
                                        }}
                                    </div>
                                    <div class="leading-none">
                                        <p
                                            class="font-semibold truncate max-w-[110px]"
                                        >
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <span
                                            class="text-[10px] text-slate-400"
                                        >
                                            {{ $page.props.auth.user.role }}
                                            {{
                                                $page.props.auth.user.paket
                                                    ? $page.props.auth.user
                                                          .paket.nama_paket
                                                    : "Tanpa Paket"
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400">▲</span>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profil Saya
                            </DropdownLink>
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="w-full text-left text-rose-500 hover:text-rose-600 hover:bg-rose-50"
                            >
                                Logout
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </aside>

        <div
            v-if="isSidebarOpen"
            @click="isSidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/20 backdrop-blur-sm md:hidden transition-opacity"
        ></div>

        <div
            class="flex-1 ml-0 md:ml-64 min-h-screen flex flex-col transition-all duration-300"
        >
            <header
                v-if="$slots.header"
                class="bg-white/60 backdrop-blur-md border-b border-slate-200/40 min-h-16 flex items-center py-6 pt-20 px-4 md:py-0 md:pt-0 md:h-16 md:px-8 sticky top-0 z-20 transition-all duration-300 w-full"
            >
                <div class="w-full">
                    <slot name="header" />
                </div>
            </header>

            <main class="w-full overflow-hidden">
                <slot />
            </main>
        </div>
    </div>
</template>
