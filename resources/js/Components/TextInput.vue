<template>
    <!-- Ditambahkan 'relative' dan 'flex items-center' agar ikon mata mengunci pas di kanan dalam -->
    <div class="relative w-full flex items-center group">
        <input
            :type="
                isPasswordType && showPassword ? 'text' : $attrs.type || 'text'
            "
            class="w-full px-4 py-3 bg-white text-slate-800 rounded-xl border border-slate-200/80 shadow-sm outline-none transition-all duration-300 placeholder:text-slate-400/80 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30"
            :class="[
                { '!pr-12': isPasswordType },
                $attrs.disabled
                    ? '!cursor-not-allowed bg-slate-100/70'
                    : '!cursor-text bg-white',
            ]"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            v-bind="filteredAttrs"
        />
        <!-- Tombol Mata Intip -->
        <button
            v-if="isPasswordType"
            type="button"
            @click="togglePassword"
            class="absolute right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors z-10 p-1"
            title="Lihat/Sembunyikan Password"
        >
            <!-- Ikon Mata Terbuka (Show) -->
            <svg
                v-if="showPassword"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="w-5 h-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
            </svg>
            <!-- Ikon Mata Coret (Hide) -->
            <svg
                v-else
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="w-5 h-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-3.228-3.228l-3.65-3.65M12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5z"
                />
            </svg>
        </button>
    </div>
</template>

<script setup>
import { onMounted, ref, computed, useAttrs } from "vue";

defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
});

defineEmits(["update:modelValue"]);

const input = ref(null);
const showPassword = ref(false); // 🟢 NYAWA 1: State untuk buka tutup mata
const attrs = useAttrs();

// 🟢 NYAWA 2: Otomatis cek apakah inputan bertipe password dari luar
const isPasswordType = computed(() => attrs.type === "password");

// 🟢 NYAWA 3: Filter agar 'type' luar tidak tabrakan dengan tipe dinamis Vue kita
const filteredAttrs = computed(() => {
    const { type, ...rest } = attrs;
    return rest;
});

// 🟢 NYAWA 4: Fungsi saklar penukar tipe input
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>
