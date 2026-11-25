<script setup>
import { computed, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const search = ref(props.filters.search ?? '');
const category = ref(props.filters.category ?? '');
const condition = ref(props.filters.condition ?? '');

const categories = [
    'Elektronik',
    'Fashion',
    'Buku',
    'Furnitur',
    'Hobi',
    'Lainnya',
];

const conditions = [
    { value: 'seperti_baru', label: 'Seperti Baru' },
    { value: 'baik', label: 'Baik' },
    { value: 'cukup', label: 'Cukup' },
];

const items = computed(() => props.products.data ?? []);

function applyFilters() {
    router.get(
        '/katalog',
        {
            search: search.value || undefined,
            category: category.value || undefined,
            condition: condition.value || undefined,
        },
        {
            preserveState: true,
            replace: true,
        }
    );
}

function resetFilters() {
    search.value = '';
    category.value = '';
    condition.value = '';
    applyFilters();
}

function rupiah(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(value);
}

function conditionLabel(value) {
    return conditions.find(item => item.value === value)?.label
        ?? value;
}

function productImage(path) {
    if (!path) return null;

    if (/^https?:\/\//i.test(path)) {
        return path;
    }

    return '/storage/' + path.replace(/^\/?storage\//, '');
}

function visitPage(url) {
    if (url) {
        router.visit(url, {
            preserveState: true,
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Katalog Barang - SEKENOVA" />

    <div class="min-h-screen bg-[#F8F5EF] text-[#443328]">
        <!-- Navbar -->
        <header class="border-b border-[#E8DED1] bg-white">
            <div
                class="mx-auto flex max-w-7xl items-center
                       justify-between gap-4 px-6 py-5"
            >
                <a
                    href="/"
                    class="text-2xl font-bold tracking-[0.15em]"
                >
                    SEKENOVA
                </a>

                <nav class="flex items-center gap-5 text-sm">
                    <a href="/" class="hover:text-[#A67C5B]">
                        Beranda
                    </a>
                    <a
                        href="/katalog"
                        class="font-semibold text-[#A67C5B]"
                    >
                        Katalog
                    </a>
                    <a href="/login" class="hover:text-[#A67C5B]">
                        Masuk
                    </a>
                </nav>
            </div>
        </header>

        <!-- Hero -->
        <section class="bg-[#EEE5D9]">
            <div class="mx-auto max-w-7xl px-6 py-14">
                <p
                    class="mb-3 text-xs font-semibold uppercase
                           tracking-[0.25em] text-[#96745C]"
                >
                    Preloved Marketplace
                </p>

                <h1 class="text-3xl font-semibold md:text-5xl">
                    Temukan Cerita Baru
                    <span class="text-[#A67C5B]">
                        dari Barang Lama
                    </span>
                </h1>

                <p class="mt-5 max-w-2xl text-[#806F60]">
                    Jelajahi koleksi barang bekas pilihan
                    yang siap menemukan pemilik barunya.
                </p>
            </div>
        </section>

        <main class="mx-auto max-w-7xl px-6 py-12">
            <!-- Filter -->
            <section
                class="mb-10 rounded-2xl border border-[#E9DFD4]
                       bg-white p-6 shadow-sm"
            >
                <h2 class="mb-5 text-xl font-semibold">
                    Cari Barang Impianmu
                </h2>

                <form
                    class="grid gap-4 md:grid-cols-4"
                    @submit.prevent="applyFilters"
                >
                    <input
                        v-model="search"
                        type="search"
                        placeholder="Cari nama barang..."
                        class="rounded-xl border-[#DED3C5]
                               focus:border-[#A67C5B]
                               focus:ring-[#A67C5B]"
                    />

                    <select
                        v-model="category"
                        class="rounded-xl border-[#DED3C5]
                               focus:border-[#A67C5B]
                               focus:ring-[#A67C5B]"
                    >
                        <option value="">Semua Kategori</option>
                        <option
                            v-for="item in categories"
                            :key="item"
                            :value="item"
                        >
                            {{ item }}
                        </option>
                    </select>

                    <select
                        v-model="condition"
                        class="rounded-xl border-[#DED3C5]
                               focus:border-[#A67C5B]
                               focus:ring-[#A67C5B]"
                    >
                        <option value="">Semua Kondisi</option>
                        <option
                            v-for="item in conditions"
                            :key="item.value"
                            :value="item.value"
                        >
                            {{ item.label }}
                        </option>
                    </select>

                    <button
                        type="submit"
                        class="rounded-xl bg-[#684735] px-5 py-3
                               font-medium text-white transition
                               hover:bg-[#503526]"
                    >
                        Cari Barang
                    </button>
                </form>

                <button
                    type="button"
                    class="mt-4 text-sm text-[#96745C]
                           hover:underline"
                    @click="resetFilters"
                >
                    Hapus semua filter
                </button>
            </section>

            <!-- Product header -->
            <div
                class="mb-6 flex items-center
                       justify-between gap-4"
            >
                <div>
                    <h2 class="text-2xl font-semibold">
                        Koleksi Pilihan
                    </h2>
                    <p class="mt-1 text-sm text-[#897669]">
                        {{ products.total ?? 0 }} barang ditemukan
                    </p>
                </div>
            </div>

            <!-- Product grid -->
            <section
                v-if="items.length"
                class="grid gap-6 sm:grid-cols-2
                       lg:grid-cols-3 xl:grid-cols-4"
            >
                <article
                    v-for="product in items"
                    :key="product.id"
                    class="overflow-hidden rounded-2xl
                           border border-[#E9DFD4]
                           bg-white shadow-sm transition
                           hover:-translate-y-1 hover:shadow-md"
                >
                    <div
                        class="flex h-56 items-center
                               justify-center bg-[#EBE1D5]"
                    >
                        <img
                            v-if="productImage(product.image)"
                            :src="productImage(product.image)"
                            :alt="product.name"
                            class="h-full w-full object-cover"
                        />

                        <span
                            v-else
                            class="text-sm text-[#9D8979]"
                        >
                            Foto belum tersedia
                        </span>
                    </div>

                    <div class="p-5">
                        <p
                            class="text-xs uppercase tracking-wider
                                   text-[#96745C]"
                        >
                            {{ product.category }}
                        </p>

                        <h3
                            class="mt-2 line-clamp-2
                                   text-lg font-semibold"
                        >
                            {{ product.name }}
                        </h3>

                        <p class="mt-2 text-sm text-[#88766A]">
                            Kondisi:
                            {{ conditionLabel(product.condition) }}
                        </p>

                        <p class="mt-4 text-xl font-bold">
                            {{ rupiah(product.price) }}
                        </p>

                        <p class="mt-1 text-xs text-[#88766A]">
                            Stok: {{ product.stock }}
                        </p>

                        <button
                            type="button"
                            disabled
                            class="mt-5 w-full cursor-not-allowed
                                   rounded-xl bg-[#684735] px-4 py-3
                                   text-sm font-medium text-white
                                   opacity-60"
                        >
                            Detail Barang — Segera
                        </button>
                    </div>
                </article>
            </section>

            <!-- Empty state -->
            <section
                v-else
                class="rounded-2xl border border-dashed
                       border-[#D9C9B7] bg-white px-6
                       py-20 text-center"
            >
                <h3 class="text-xl font-semibold">
                    Belum Ada Barang Ditemukan
                </h3>
                <p class="mt-3 text-[#897669]">
                    Coba gunakan kata kunci atau filter lainnya.
                </p>
            </section>

            <!-- Pagination -->
            <div
                v-if="products.links?.length > 3"
                class="mt-10 flex flex-wrap justify-center gap-2"
            >
                <button
                    v-for="(link, index) in products.links"
                    :key="index"
                    type="button"
                    :disabled="!link.url"
                    class="rounded-lg border px-4 py-2 text-sm"
                    :class="[
                        link.active
                            ? 'border-[#684735] bg-[#684735] text-white'
                            : 'border-[#DDD0C2] bg-white text-[#684735]',
                        !link.url
                            ? 'cursor-not-allowed opacity-40'
                            : 'hover:bg-[#EFE5DA]',
                    ]"
                    @click="visitPage(link.url)"
                >
                    <span v-if="index === 0">Sebelumnya</span>
                    <span v-else-if="index === products.links.length - 1">
                        Berikutnya
                    </span>
                    <span v-else>{{ link.label }}</span>
                </button>
            </div>
        </main>

        <footer
            class="mt-12 border-t border-[#E8DED1]
                   bg-white px-6 py-8 text-center
                   text-sm text-[#897669]"
        >
            © 2026 SEKENOVA. Every item deserves a second story.
        </footer>
    </div>
</template>