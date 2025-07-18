<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    Package,
    Plus,
    Search,
    Filter,
    Download,
    Eye,
    Edit,
    Trash2,
    AlertTriangle,
    TrendingUp,
    TrendingDown,
    Star
} from 'lucide-vue-next';

const products = ref([
    {
        id: 1,
        name: 'Wireless Headphones',
        sku: 'WH-001',
        category: 'Electronics',
        price: 89.99,
        stock: 15,
        status: 'active',
        sales: 127,
        rating: 4.5,
        image: '/placeholder.jpg'
    },
    {
        id: 2,
        name: 'Smartphone Case',
        sku: 'SC-002',
        category: 'Accessories',
        price: 24.99,
        stock: 32,
        status: 'active',
        sales: 89,
        rating: 4.2,
        image: '/placeholder.jpg'
    },
    {
        id: 3,
        name: 'Bluetooth Speaker',
        sku: 'BS-003',
        category: 'Electronics',
        price: 59.99,
        stock: 3,
        status: 'low_stock',
        sales: 156,
        rating: 4.8,
        image: '/placeholder.jpg'
    },
    {
        id: 4,
        name: 'USB Cable',
        sku: 'UC-004',
        category: 'Accessories',
        price: 12.99,
        stock: 0,
        status: 'out_of_stock',
        sales: 234,
        rating: 4.1,
        image: '/placeholder.jpg'
    },
    {
        id: 5,
        name: 'Power Bank',
        sku: 'PB-005',
        category: 'Electronics',
        price: 39.99,
        stock: 20,
        status: 'active',
        sales: 98,
        rating: 4.6,
        image: '/placeholder.jpg'
    }
]);

const stats = ref([
    { name: 'Total Products', value: '247', change: '+12%', color: 'blue' },
    { name: 'Low Stock Items', value: '8', change: '+3%', color: 'orange' },
    { name: 'Out of Stock', value: '4', change: '-2%', color: 'red' },
    { name: 'Top Seller', value: 'USB Cable', change: '234 sold', color: 'green' }
]);

const getStatusColor = (status) => {
    const colors = {
        active: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        low_stock: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        out_of_stock: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        inactive: 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400'
    };
    return colors[status] || colors.active;
};

const getStockStatus = (stock) => {
    if (stock === 0) return 'out_of_stock';
    if (stock < 10) return 'low_stock';
    return 'active';
};
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Products</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your product inventory</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <Download class="h-4 w-4" />
                        <span>Export</span>
                    </button>
                    <button class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                        <Plus class="h-4 w-4" />
                        <span>Add Product</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="space-y-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.name"
                    class="bg-white dark:bg-gray-800 rounded-2xl border-0 shadow-sm hover:shadow-md transition-all duration-200 p-6"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ stat.name }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ stat.value }}</p>
                        </div>
                        <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                            {{ stat.change }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Product Inventory</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ products.length }} products found</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                <input
                                    type="text"
                                    placeholder="Search products..."
                                    class="pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 text-sm w-64"
                                />
                            </div>
                            <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                <Filter class="h-4 w-4" />
                                <span>Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-750">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                SKU
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Sales
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Rating
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-4">
                                        <Package class="h-6 w-6" />
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ product.name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ product.category }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-mono text-gray-900 dark:text-white">
                                    {{ product.sku }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        {{ product.category }}
                                    </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    ${{ product.price }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ product.stock }}
                                        </span>
                                    <span :class="[getStatusColor(getStockStatus(product.stock)), 'inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full']">
                                            <AlertTriangle v-if="product.stock < 10" class="h-3 w-3 mr-1" />
                                            {{ getStockStatus(product.stock).replace('_', ' ') }}
                                        </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-1">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ product.sales }}</span>
                                    <TrendingUp class="h-4 w-4 text-green-500" />
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-1">
                                    <Star class="h-4 w-4 text-yellow-400 fill-current" />
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ product.rating }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <Eye class="h-4 w-4" />
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                        <Edit class="h-4 w-4" />
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
