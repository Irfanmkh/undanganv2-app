<template>
    <Link
        class="block w-full px-4 py-3 text-left text-sm font-medium text-slate-600 relative overflow-hidden group/link transition-all duration-300 hover:bg-slate-50/60 hover:text-emerald-600 hover:pl-6 focus:outline-none focus:bg-slate-50/60 focus:text-emerald-600 focus:pl-6 cursor-pointer"
    >
        <span
            class="absolute left-0 top-0 w-[4px] h-0 bg-gradient-to-b from-emerald-500 to-teal-500 transition-all duration-300 group-hover/link:h-full group-focus/link:h-full rounded-r-md"
        ></span>

        <span
            class="absolute inset-0 bg-emerald-500/0 transition-all duration-300 group-hover/link:bg-emerald-500/[0.02] pointer-events-none"
        ></span>

        <div class="relative z-10 flex items-center gap-2">
            <slot />
        </div>
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
