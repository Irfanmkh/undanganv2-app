<template>
    <button
        class="relative inline-flex items-center justify-center px-5 py-2.5 font-semibold text-xs text-white uppercase tracking-widest rounded-xl overflow-hidden group transition-all duration-300 active:scale-95 disabled:opacity-50 disabled:pointer-events-none"
    >
        <span
            class="absolute inset-0 w-full h-full bg-gradient-to-r from-rose-500 to-red-600 transition-all duration-500 group-hover:bg-gradient-to-l"
        ></span>

        <span
            class="absolute inset-0 w-full h-full rounded-xl bg-gradient-to-r from-rose-500 to-red-600 blur-md opacity-0 group-hover:opacity-50 group-hover:blur-lg transition-all duration-300 -z-10"
        ></span>

        <span class="relative z-10 flex items-center space-x-1">
            <slot />
        </span>
    </button>
</template>
