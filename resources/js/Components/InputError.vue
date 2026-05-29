<template>
    <div
        v-show="message"
        class="transition-all duration-300 ease-out animate-fade-in-down"
    >
        <p
            class="text-xs text-rose-500 font-medium italic flex items-center space-x-1 mt-1.5 bg-rose-50 px-2 py-1 rounded-md border border-rose-100 w-fit animate-pulse-subtle"
        >
            <span>⚠️</span>
            <span>{{ message }}</span>
        </p>
    </div>
</template>

<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<style scoped>
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-down {
    animation: fadeInDown 0.3s ease-out forwards;
}
</style>
