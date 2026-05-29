<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Masuk Akun" />

    <div class="flex min-h-screen bg-slate-50 text-slate-800 font-sans">
        <!-- ================= KOLOM KIRI: FORM LOGIN GLASSMORPHISM ================= -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 md:p-20 bg-slate-50"
        >
            <div
                class="w-full max-w-md bg-white/70 backdrop-blur-md border border-slate-200/60 p-8 sm:p-10 rounded-2xl shadow-xl"
            >
                <div class="mb-8">
                    <h2
                        class="text-2xl font-bold text-slate-800 tracking-tight"
                    >
                        Selamat Datang Kembali!
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Silakan masuk untuk mengelola undangan digitalmu.
                    </p>
                </div>

                <div
                    v-if="status"
                    class="mb-4 font-medium text-sm text-emerald-600 bg-emerald-50 p-3 rounded-xl border border-emerald-100"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Input Email -->
                    <div>
                        <InputLabel for="email" value="Alamat Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@email.com"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Input Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <InputLabel
                                for="password"
                                value="Password"
                                class="!mb-0"
                            />
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-xs font-semibold text-emerald-600 hover:text-emerald-500 transition-colors"
                            >
                                Lupa Password?
                            </Link>
                        </div>
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center cursor-pointer group">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.remember"
                            />
                            <span
                                class="ms-2 text-sm text-slate-500 group-hover:text-slate-700 transition-colors selection:bg-transparent"
                            >
                                Ingat akun saya
                            </span>
                        </label>
                    </div>

                    <!-- Button Submit -->
                    <div class="pt-2">
                        <PrimaryButton
                            class="w-full py-3.5 shadow-lg shadow-emerald-500/20"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Masuk ke Dashboard
                        </PrimaryButton>
                    </div>

                    <!-- Link Register -->
                    <p
                        class="text-center text-sm text-slate-500 mt-6 pt-4 border-t border-slate-100"
                    >
                        Belum punya akun?
                        <Link
                            :href="route('register')"
                            class="font-bold text-emerald-600 hover:text-emerald-500 transition-colors ml-1"
                        >
                            Daftar Sekarang
                        </Link>
                    </p>
                </form>
            </div>
        </div>

        <!-- ================= KOLOM KANAN: BRANDING VISUAL CONTRAST ================= -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center p-12"
        >
            <div
                class="absolute top-[-20%] right-[-20%] w-[70%] h-[70%] bg-emerald-500/20 rounded-full blur-[120px]"
            ></div>
            <div
                class="absolute bottom-[-20%] left-[-20%] w-[70%] h-[70%] bg-cyan-500/20 rounded-full blur-[120px]"
            ></div>

            <div class="relative z-10 max-w-md text-center lg:text-left">
                <span
                    class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-widest rounded-full border border-emerald-500/20"
                >
                    SaaS Digital Invitation
                </span>
                <h1
                    class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight mt-6 leading-tight"
                >
                    Bikin Undangan Digital
                    <span
                        class="bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent"
                        >Makin Berkelas.</span
                    >
                </h1>
                <p class="text-slate-400 mt-4 text-base leading-relaxed">
                    Kelola data mempelai, atur jadwal acara, dan pilih tema
                    estetik sesukamu dalam hitungan menit bersama Loventa.
                </p>
            </div>
        </div>
    </div>
</template>
