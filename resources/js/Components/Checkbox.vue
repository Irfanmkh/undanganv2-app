<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="w-5 h-5 rounded-md border-slate-300 text-emerald-500 shadow-sm focus:ring-emerald-500/30 focus:ring-offset-0 transition-all duration-200 cursor-pointer text-gradient-to-r checked:bg-emerald-500 checked:border-transparent"
    />
</template>

<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },
    set(val) {
        emit("update:checked", val);
    },
});
</script>
