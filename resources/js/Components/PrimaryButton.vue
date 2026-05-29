<template>
    <button
        class="relative inline-flex items-center justify-center px-6 py-3 font-semibold text-sm text-white tracking-wide rounded-xl overflow-hidden group transition-all duration-300 active:scale-95 disabled:opacity-50 disabled:pointer-events-none"
    >
        <span
            class="absolute inset-0 w-full h-full bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 transition-all duration-500 group-hover:bg-gradient-to-l"
        ></span>

        <span
            class="absolute top-0 right-0 w-12 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-20 rotate-12 group-hover:-translate-x-40 ease"
        ></span>

        <span
            class="absolute inset-0 w-full h-full rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-500 blur-md opacity-0 group-hover:opacity-60 group-hover:blur-lg transition-all duration-300 -z-10"
        ></span>

        <span class="relative flex items-center space-x-2 z-10">
            <slot />
        </span>
    </button>
</template>
