<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    whatsapp: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Daftar Akun Baru" />

    <div class="flex min-h-screen bg-slate-50 text-slate-800 font-sans">
        <!-- ================= KOLOM KIRI: BRANDING VISUAL CONTRAST ================= -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center p-12"
        >
            <div
                class="absolute top-[-20%] left-[-20%] w-[70%] h-[70%] bg-cyan-500/20 rounded-full blur-[120px]"
            ></div>
            <div
                class="absolute bottom-[-20%] right-[-20%] w-[70%] h-[70%] bg-emerald-500/20 rounded-full blur-[120px]"
            ></div>

            <div class="relative z-10 max-w-md text-center lg:text-left">
                <span
                    class="px-3 py-1 bg-cyan-500/10 text-cyan-400 text-xs font-bold uppercase tracking-widest rounded-full border border-cyan-500/20"
                >
                    Join Loventa Platform
                </span>
                <h1
                    class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight mt-6 leading-tight"
                >
                    Mulai Langkah
                    <span
                        class="bg-gradient-to-r from-cyan-400 to-emerald-400 bg-clip-text text-transparent"
                        >SaaS Bisnismu.</span
                    >
                </h1>
                <p class="text-slate-400 mt-4 text-base leading-relaxed">
                    Daftar sekarang dan nikmati kemudahan membuat undangan
                    digital premium dengan performa server secepat kilat.
                </p>
            </div>
        </div>

        <!-- ================= KOLOM KANAN: FORM REGISTER GLASSMORPHISM ================= -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-slate-50 overflow-y-auto"
        >
            <div
                class="w-full max-w-md bg-white/70 backdrop-blur-md border border-slate-200/60 p-8 sm:p-10 rounded-2xl shadow-xl my-8"
            >
                <div class="mb-6">
                    <h2
                        class="text-2xl font-bold text-slate-800 tracking-tight"
                    >
                        Buat Akun Loventa
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Isi data di bawah dengan benar untuk memulai
                        perjalananmu.
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Input Nama Lengkap -->
                    <div>
                        <InputLabel for="name" value="Nama Lengkap" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda..."
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Input Email -->
                    <div>
                        <InputLabel for="email" value="Alamat Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="nama@email.com"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Input WhatsApp -->
                    <div>
                        <InputLabel
                            for="whatsapp"
                            value="Nomor WhatsApp (Aktif)"
                        />
                        <div class="relative group">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400 select-none group-focus-within:text-emerald-500 transition-colors"
                            >
                                +62
                            </span>
                            <TextInput
                                id="whatsapp"
                                type="number"
                                class="mt-1 block w-full !pl-12"
                                v-model="form.whatsapp"
                                required
                                placeholder="8xxxxxxxxxx"
                            />
                        </div>
                        <InputError
                            class="mt-2"
                            :message="form.errors.whatsapp"
                        />
                    </div>

                    <!-- Input Password -->
                    <div>
                        <InputLabel for="password" value="Password Baru" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <!-- Input Konfirmasi Password -->
                    <div>
                        <InputLabel
                            for="password_confirmation"
                            value="Konfirmasi Password"
                        />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi password baru..."
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <!-- Button Submit -->
                    <div class="pt-3">
                        <PrimaryButton
                            class="w-full py-3.5 shadow-lg shadow-emerald-500/20"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Daftar Akun Baru
                        </PrimaryButton>
                    </div>

                    <!-- Link Login -->
                    <p
                        class="text-center text-sm text-slate-500 mt-6 pt-4 border-t border-slate-100"
                    >
                        Sudah punya akun sebelumnya?
                        <Link
                            :href="route('login')"
                            class="font-bold text-emerald-600 hover:text-emerald-500 transition-colors ml-1"
                        >
                            Masuk di Sini
                        </Link>
                    </p>
                </form>
            </div>
        </div>
    </div>
</template>
