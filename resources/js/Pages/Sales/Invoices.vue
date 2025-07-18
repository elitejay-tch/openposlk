<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    FileText,
    Plus,
    Search,
    Filter,
    Download,
    Eye,
    Edit,
    Trash2,
    Send,
    Printer,
    DollarSign,
    Calendar,
    Clock,
    CheckCircle,
    XCircle,
    AlertCircle
} from 'lucide-vue-next';

const invoices = ref([
    {
        id: 'INV-001',
        customer: 'John Doe',
        date: '2025-07-17',
        dueDate: '2025-08-16',
        amount: 1250.50,
        status: 'paid',
        items: 5,
        paymentMethod: 'Card'
    },
    {
        id: 'INV-002',
        customer: 'Jane Smith',
        date: '2025-07-16',
        dueDate: '2025-08-15',
        amount: 890.25,
        status: 'pending',
        items: 3,
        paymentMethod: 'Bank Transfer'
    },
    {
        id: 'INV-003',
        customer: 'Mike Johnson',
        date: '2025-07-15',
        dueDate: '2025-08-14',
        amount: 2150.75,
        status: 'sent',
        items: 8,
        paymentMethod: 'Check'
    },
    {
        id: 'INV-004',
        customer: 'Sarah Wilson',
        date: '2025-07-14',
        dueDate: '2025-08-13',
        amount: 340.00,
        status: 'overdue',
        items: 2,
        paymentMethod: 'Cash'
    },
    {
        id: 'INV-005',
        customer: 'David Brown',
        date: '2025-07-13',
        dueDate: '2025-08-12',
        amount: 3250.80,
        status: 'paid',
        items: 12,
        paymentMethod: 'Card'
    }
]);

const stats = ref([
    { name: 'Total Invoices', value: '347', change: '+8%', color: 'blue' },
    { name: 'Paid Invoices', value: '289', change: '+12%', color: 'green' },
    { name: 'Pending Payment', value: '45', change: '+3%', color: 'orange' },
    { name: 'Overdue', value: '13', change: '-5%', color: 'red' }
]);

const getStatusColor = (status) => {
    const colors = {
        paid: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        pending: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        sent: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        overdue: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        draft: 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400'
    };
    return colors[status] || colors.pending;
};

const getStatusIcon = (status) => {
    const icons = {
        paid: CheckCircle,
        pending: Clock,
        sent: Send,
        overdue: AlertCircle,
        draft: FileText
    };
    return icons[status] || Clock;
};
</script>

<template>
    <Head title="Invoices" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Invoices</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage billing and invoice processing</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <Download class="h-4 w-4" />
                        <span>Export</span>
                    </button>
                    <button class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                        <Plus class="h-4 w-4" />
                        <span>Create Invoice</span>
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

            <!-- Invoices Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Invoice Management</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ invoices.length }} invoices found</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                <input
                                    type="text"
                                    placeholder="Search invoices..."
                                    class="pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 text-sm w-64"
                                />
                            </div>
                            <button class="flex items-center space-x-2 bg<button class="flex items-center space-x-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
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
                                Invoice ID
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Amount
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
                        <tr v-for="invoice in invoices" :key="invoice.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ invoice.id }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ invoice.items }} items
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ invoice.customer.split(' ').map(n => n[0]).join('') }}
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ invoice.customer }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <Calendar class="h-4 w-4 text-gray-400" />
                                    <span class="text-sm text-gray-900 dark:text-white">{{ invoice.date }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <Clock class="h-4 w-4 text-gray-400" />
                                    <span class="text-sm text-gray-900 dark:text-white">{{ invoice.dueDate }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <DollarSign class="h-4 w-4 text-gray-400" />
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">${{ invoice.amount.toFixed(2) }}</span>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ invoice.paymentMethod }}
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                    <span :class="[getStatusColor(invoice.status), 'inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full capitalize']">
                                        <component :is="getStatusIcon(invoice.status)" class="h-3 w-3 mr-1" />
                                        {{ invoice.status }}
                                    </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <Eye class="h-4 w-4" />
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                        <Edit class="h-4 w-4" />
                                    </button>
                                    <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        <Printer class="h-4 w-4" />
                                    </button>
                                    <button class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                        <Send class="h-4 w-4" />
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
