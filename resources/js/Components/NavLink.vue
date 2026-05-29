<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: { type: String, required: true },
    active: { type: Boolean },
});

const classes = computed(() =>
    props.active
        ? "flex items-center px-4 py-3 text-sm font-semibold text-emerald-600 bg-emerald-50/60 rounded-xl border-l-4 border-emerald-500 transition-all duration-200"
        : "flex items-center px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-100/80 rounded-xl border-l-4 border-transparent transition-all duration-200",
);
</script>
