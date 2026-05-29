<template>
    <label
        class="block font-semibold text-xs uppercase tracking-wider text-slate-500 mb-1.5 transition-colors duration-300 group-focus-within:text-emerald-500"
    >
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>
