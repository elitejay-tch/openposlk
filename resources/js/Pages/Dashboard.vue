<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    DollarSign,
    ShoppingCart,
    Users,
    Package,
    TrendingUp,
    TrendingDown,
    Activity,
    Calendar,
    Clock
} from 'lucide-vue-next';

const stats = [
    {
        name: 'Today\'s Sales',
        value: '$2,845',
        change: '+12%',
        changeType: 'increase',
        icon: DollarSign
    },
    {
        name: 'Total Orders',
        value: '156',
        change: '+8%',
        changeType: 'increase',
        icon: ShoppingCart
    },
    {
        name: 'Active Customers',
        value: '1,284',
        change: '+3%',
        changeType: 'increase',
        icon: Users
    },
    {
        name: 'Products Sold',
        value: '2,847',
        change: '+15%',
        changeType: 'increase',
        icon: Package
    },
];

const recentTransactions = [
    { id: 1, customer: 'John Doe', amount: '$45.00', time: '2 min ago', status: 'completed' },
    { id: 2, customer: 'Jane Smith', amount: '$128.50', time: '5 min ago', status: 'completed' },
    { id: 3, customer: 'Mike Johnson', amount: '$67.25', time: '8 min ago', status: 'pending' },
    { id: 4, customer: 'Sarah Wilson', amount: '$89.75', time: '12 min ago', status: 'completed' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <Calendar class="h-4 w-4" />
                    <span>7/17/2025</span>
                </div>
            </div>
        </template>

        <div class="space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.name"
                    class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-gray-50 rounded-lg">
                            <component :is="stat.icon" class="h-6 w-6 text-gray-600" />
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">{{ stat.name }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ stat.value }}</p>
                        </div>
                        <div class="flex items-center">
                            <TrendingUp v-if="stat.changeType === 'increase'" class="h-4 w-4 text-green-500 mr-1" />
                            <TrendingDown v-else class="h-4 w-4 text-red-500 mr-1" />
                            <span
                                :class="[
                                    stat.changeType === 'increase' ? 'text-green-600' : 'text-red-600',
                                    'text-sm font-medium'
                                ]"
                            >
                                {{ stat.change }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Transactions -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
                                <button class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                                    View all
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="transaction in recentTransactions" :key="transaction.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ transaction.customer }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ transaction.amount }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ transaction.time }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="[
                                                transaction.status === 'completed'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-yellow-100 text-yellow-800',
                                                'inline-flex px-2 py-1 text-xs font-semibold rounded-full'
                                            ]">
                                                {{ transaction.status }}
                                            </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <Activity class="h-5 w-5 text-gray-600 mr-2" />
                                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <button class="w-full text-left px-4 py-3 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                                    New Sale
                                </button>
                                <button class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    Add Product
                                </button>
                                <button class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    View Reports
                                </button>
                                <button class="w-full text-left px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    Manage Inventory
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <Clock class="h-5 w-5 text-gray-600 mr-2" />
                                <h3 class="text-lg font-semibold text-gray-900">System Status</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Database</span>
                                    <span class="text-sm font-medium text-green-600">Online</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Payment Gateway</span>
                                    <span class="text-sm font-medium text-green-600">Active</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Inventory Sync</span>
                                    <span class="text-sm font-medium text-green-600">Updated</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
