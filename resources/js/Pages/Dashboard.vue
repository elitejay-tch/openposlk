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
    Clock,
    MoreHorizontal,
    ArrowUpRight,
    Zap
} from 'lucide-vue-next';

const stats = [
    {
        name: 'Today\'s Sales',
        value: '$2,845',
        change: '+12%',
        changeType: 'increase',
        icon: DollarSign,
        color: 'blue'
    },
    {
        name: 'Total Orders',
        value: '156',
        change: '+8%',
        changeType: 'increase',
        icon: ShoppingCart,
        color: 'green'
    },
    {
        name: 'Active Customers',
        value: '1,284',
        change: '+3%',
        changeType: 'increase',
        icon: Users,
        color: 'purple'
    },
    {
        name: 'Products Sold',
        value: '2,847',
        change: '+15%',
        changeType: 'increase',
        icon: Package,
        color: 'orange'
    },
];

const recentTransactions = [
    { id: 1, customer: 'John Doe', amount: '$45.00', time: '2 min ago', status: 'completed' },
    { id: 2, customer: 'Jane Smith', amount: '$128.50', time: '5 min ago', status: 'completed' },
    { id: 3, customer: 'Mike Johnson', amount: '$67.25', time: '8 min ago', status: 'pending' },
    { id: 4, customer: 'Sarah Wilson', amount: '$89.75', time: '12 min ago', status: 'completed' },
];

const quickActions = [
    { name: 'New Sale', icon: DollarSign, color: 'blue' },
    { name: 'Add Product', icon: Package, color: 'green' },
    { name: 'View Reports', icon: Activity, color: 'purple' },
    { name: 'Manage Inventory', icon: Zap, color: 'orange' },
];

const getColorClasses = (color) => {
    const colors = {
        blue: 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400',
        green: 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400',
        purple: 'bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400',
        orange: 'bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400',
    };
    return colors[color] || colors.blue;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Welcome back! Here's what's happening today.</p>
                </div>

            </div>
        </template>

        <div class="space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="stat in stats"
                    :key="stat.name"
                    class="bg-white dark:bg-gray-800 rounded-2xl border-0 shadow-sm hover:shadow-md transition-all duration-200 p-6 group"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div :class="[getColorClasses(stat.color), 'p-3 rounded-xl']">
                                <component :is="stat.icon" class="h-6 w-6" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ stat.name }}</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ stat.value }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <TrendingUp v-if="stat.changeType === 'increase'" class="h-4 w-4 text-green-500" />
                            <TrendingDown v-else class="h-4 w-4 text-red-500" />
                            <span
                                :class="[
                                    stat.changeType === 'increase' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400',
                                    'text-sm font-semibold'
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
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Transactions</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Latest customer transactions</p>
                                </div>
                                <button class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
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
                                        Customer
                                    </th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Time
                                    </th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                <tr v-for="transaction in recentTransactions" :key="transaction.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-4">
                                                {{ transaction.customer.split(' ').map(n => n[0]).join('') }}
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ transaction.customer }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ transaction.amount }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ transaction.time }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span :class="[
                                            transaction.status === 'completed'
                                                ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                                : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            'inline-flex px-3 py-1 text-xs font-semibold rounded-full'
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
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0">
                        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg mr-3">
                                        <Activity class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quick Actions</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Common tasks</p>
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <MoreHorizontal class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-3">
                                <button
                                    v-for="action in quickActions"
                                    :key="action.name"
                                    class="flex flex-col items-center justify-center p-4 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200 group"
                                >
                                    <div :class="[getColorClasses(action.color), 'p-2 rounded-lg mb-2 group-hover:scale-110 transition-transform']">
                                        <component :is="action.icon" class="h-5 w-5" />
                                    </div>
                                    <span class="text-xs font-semibold">{{ action.name }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0">
                        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg mr-3">
                                    <Clock class="h-5 w-5 text-green-600 dark:text-green-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">System Status</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">All systems operational</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="h-2 w-2 bg-green-500 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Database</span>
                                    </div>
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400">Online</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="h-2 w-2 bg-green-500 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Payment Gateway</span>
                                    </div>
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400">Active</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="h-2 w-2 bg-green-500 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Inventory Sync</span>
                                    </div>
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400">Updated</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
