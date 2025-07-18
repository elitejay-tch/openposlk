<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    BarChart3,
    TrendingUp,
    TrendingDown,
    DollarSign,
    ShoppingCart,
    Package,
    Users,
    Calendar,
    Download,
    Filter,
    Eye,
    ArrowUpRight,
    ArrowDownRight
} from 'lucide-vue-next';

const salesData = ref([
    { month: 'Jan', sales: 45000, orders: 234, customers: 156 },
    { month: 'Feb', sales: 52000, orders: 267, customers: 178 },
    { month: 'Mar', sales: 48000, orders: 245, customers: 165 },
    { month: 'Apr', sales: 61000, orders: 312, customers: 203 },
    { month: 'May', sales: 55000, orders: 289, customers: 187 },
    { month: 'Jun', sales: 67000, orders: 334, customers: 221 },
    { month: 'Jul', sales: 72000, orders: 356, customers: 238 }
]);

const topProducts = ref([
    { name: 'Wireless Headphones', sales: 234, revenue: 20826, growth: 12.5 },
    { name: 'Smartphone Case', sales: 189, revenue: 4723, growth: 8.3 },
    { name: 'Bluetooth Speaker', sales: 167, revenue: 10017, growth: 15.7 },
    { name: 'USB Cable', sales: 145, revenue: 1883, growth: -2.1 },
    { name: 'Power Bank', sales: 123, revenue: 4917, growth: 6.8 }
]);

const stats = ref([
    { name: 'Total Revenue', value: '$285,742', change: '+12.5%', trend: 'up', color: 'blue' },
    { name: 'Total Orders', value: '2,347', change: '+8.2%', trend: 'up', color: 'green' },
    { name: 'Average Order', value: '$121.80', change: '+3.1%', trend: 'up', color: 'purple' },
    { name: 'Conversion Rate', value: '3.2%', change: '-0.5%', trend: 'down', color: 'orange' }
]);

const recentSales = ref([
    { id: 'ORD-1234', customer: 'John Doe', amount: 156.50, date: '2025-07-17 14:30' },
    { id: 'ORD-1235', customer: 'Jane Smith', amount: 89.99, date: '2025-07-17 13:45' },
    { id: 'ORD-1236', customer: 'Mike Johnson', amount: 234.75, date: '2025-07-17 12:15' },
    { id: 'ORD-1237', customer: 'Sarah Wilson', amount: 67.30, date: '2025-07-17 11:20' },
    { id: 'ORD-1238', customer: 'David Brown', amount: 189.45, date: '2025-07-17 10:10' }
]);
</script>

<template>
    <Head title="Sales Reports" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Sales Reports</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Analyze sales performance and trends</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded-lg">
                        <Calendar class="h-4 w-4" />
                        <span>Last 30 days</span>
                    </div>
                    <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <Filter class="h-4 w-4" />
                        <span>Filter</span>
                    </button>
                    <button class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                        <Download class="h-4 w-4" />
                        <span>Export</span>
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
                        <div class="flex items-center space-x-1">
                            <TrendingUp v-if="stat.trend === 'up'" class="h-4 w-4 text-green-500" />
                            <TrendingDown v-else class="h-4 w-4 text-red-500" />
                            <span
                                :class="[
                                    stat.trend === 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400',
                                    'text-sm font-semibold'
                                ]"
                            >
                                {{ stat.change }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Sales Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Monthly Sales</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Revenue trend over time</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <BarChart3 class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <!-- Mock Chart Area -->
                        <div class="h-64 bg-gradient-to-t from-blue-50 to-transparent dark:from-blue-900/20 rounded-lg flex items-end justify-center space-x-4 p-4">
                            <div
                                v-for="data in salesData"
                                :key="data.month"
                                class="bg-blue-500 rounded-t-lg relative group cursor-pointer hover:bg-blue-600 transition-colors"
                                :style="`height: ${(data.sales / 72000) * 100}%`"
                                style="width: 40px;"
                            >
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    ${{ (data.sales / 1000).toFixed(0) }}k
                                </div>
                                <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs text-gray-500 dark:text-gray-400">
                                    {{ data.month }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Top Products</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Best selling items</p>
                            </div>
                            <button class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                <span>View all</span>
                                <ArrowUpRight class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div
                                v-for="(product, index) in topProducts"
                                :key="product.name"
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                            >
                                <div class="flex items-center space-x-4">
                                    <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ product.name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ product.sales }} sold</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">${{ product.revenue.toLocaleString() }}</div>
                                    <div class="flex items-center space-x-1">
                                        <TrendingUp v-if="product.growth > 0" class="h-3 w-3 text-green-500" />
                                        <TrendingDown v-else class="h-3 w-3 text-red-500" />
                                        <span
                                            :class="[
                                                product.growth > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400',
                                                'text-xs font-semibold'
                                            ]"
                                        >
                                            {{ product.growth > 0 ? '+' : '' }}{{ product.growth }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Sales</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Latest transactions</p>
                        </div>
                        <button class="flex items-center space-x-2 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            <span>View all</span>
                            <ArrowUpRight class="h-4 w-4" />
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-750">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        <tr v-for="sale in recentSales" :key="sale.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ sale.id }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ sale.customer.split(' ').map(n => n[0]).join('') }}
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ sale.customer }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    ${{ sale.amount.toFixed(2) }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ sale.date }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    <Eye class="h-4 w-4" />
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
