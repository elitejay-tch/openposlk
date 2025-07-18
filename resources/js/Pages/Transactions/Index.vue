<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    CreditCard,
    Search,
    Filter,
    Download,
    Eye,
    ArrowUpRight,
    ArrowDownLeft,
    DollarSign,
    Calendar,
    CheckCircle,
    XCircle,
    Clock,
    RefreshCw
} from 'lucide-vue-next';

const transactions = ref([
    {
        id: 'TXN-001',
        type: 'sale',
        customer: 'John Doe',
        amount: 156.50,
        date: '2025-07-17 14:30',
        status: 'completed',
        method: 'Credit Card',
        reference: 'REF-001234'
    },
    {
        id: 'TXN-002',
        type: 'refund',
        customer: 'Jane Smith',
        amount: -45.99,
        date: '2025-07-17 13:45',
        status: 'completed',
        method: 'Credit Card',
        reference: 'REF-001235'
    },
    {
        id: 'TXN-003',
        type: 'sale',
        customer: 'Mike Johnson',
        amount: 234.75,
        date: '2025-07-17 12:15',
        status: 'pending',
        method: 'Bank Transfer',
        reference: 'REF-001236'
    },
    {
        id: 'TXN-004',
        type: 'sale',
        customer: 'Sarah Wilson',
        amount: 67.30,
        date: '2025-07-17 11:20',
        status: 'failed',
        method: 'Credit Card',
        reference: 'REF-001237'
    },
    {
        id: 'TXN-005',
        type: 'sale',
        customer: 'David Brown',
        amount: 189.45,
        date: '2025-07-17 10:10',
        status: 'completed',
        method: 'Cash',
        reference: 'REF-001238'
    }
]);

const stats = ref([
    { name: 'Total Transactions', value: '2,847', change: '+12%', color: 'blue' },
    { name: 'Successful', value: '2,645', change: '+8%', color: 'green' },
    { name: 'Pending', value: '156', change: '+15%', color: 'orange' },
    { name: 'Failed', value: '46', change: '-5%', color: 'red' }
]);

const getStatusColor = (status) => {
    const colors = {
        completed: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        pending: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        failed: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        processing: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
    };
    return colors[status] || colors.pending;
};

const getStatusIcon = (status) => {
    const icons = {
        completed: CheckCircle,
        pending: Clock,
        failed: XCircle,
        processing: RefreshCw
    };
    return icons[status] || Clock;
};

const getTypeIcon = (type) => {
    return type === 'refund' ? ArrowDownLeft : ArrowUpRight;
};

const getTypeColor = (type) => {
    return type === 'refund' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400';
};
</script>

<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Transactions</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor all payment transactions</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded-lg">
                        <Calendar class="h-4 w-4" />
                        <span>Today</span>
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
                        <div class="text-sm font-semibold text-green-600 dark:text-green-400">
                            {{ stat.change }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Transaction History</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ transactions.length }} transactions found</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                <input
                                    type="text"
                                    placeholder="Search transactions..."
                                    class="pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 text-sm w-64"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-750">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Transaction ID
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Method
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        <tr v-for="transaction in transactions" :key="transaction.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ transaction.id }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ transaction.reference }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ transaction.customer.split(' ').map(n => n[0]).join('') }}
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ transaction.customer }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <component :is="getTypeIcon(transaction.type)" :class="[getTypeColor(transaction.type), 'h-4 w-4']" />
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white capitalize">
                                            {{ transaction.type }}
                                        </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <DollarSign class="h-4 w-4 text-gray-400" />
                                    <span :class="[
                                            transaction.amount < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400',
                                            'text-sm font-bold'
                                        ]">
                                            ${{ Math.abs(transaction.amount).toFixed(2) }}
                                        </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <CreditCard class="h-4 w-4 text-gray-400" />
                                    <span class="text-sm text-gray-900 dark:text-white">
                                            {{ transaction.method }}
                                        </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ transaction.date }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                    <span :class="[getStatusColor(transaction.status), 'inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full capitalize']">
                                        <component :is="getStatusIcon(transaction.status)" class="h-3 w-3 mr-1" />
                                        {{ transaction.status }}
                                    </span>
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
