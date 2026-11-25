<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const sedangDiproses = ref(false);

const pesanSukses = computed(() => page.props.flash?.success);

const mulaiJual = () => {
    router.post(route('seller.activate'), {}, {
        onStart: () => {
            sedangDiproses.value = true;
        },
        onFinish: () => {
            sedangDiproses.value = false;
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard SEKENOVA
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                    <div class="p-6 text-gray-900">
                        <h3 class="mb-3 text-xl font-semibold">
                            Selamat Datang di SEKENOVA!
                        </h3>

                        <p class="mb-5 text-gray-600">
                            Temukan barang bekas berkualitas atau mulai
                            menjual barang yang sudah tidak kamu gunakan.
                        </p>

                        <div
                            v-if="pesanSukses"
                            class="mb-5 rounded-lg bg-green-100 p-4 text-green-800"
                        >
                            {{ pesanSukses }}
                        </div>

                        <button
                            type="button"
                            :disabled="sedangDiproses"
                            @click="mulaiJual"
                            class="rounded-lg bg-amber-800 px-5 py-3 font-semibold text-white hover:bg-amber-900 disabled:opacity-50"
                        >
                            {{ sedangDiproses ? 'Memproses...' : 'Mulai Jual Barang' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>