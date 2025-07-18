<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    ShoppingCart,
    Plus,
    Minus,
    Trash2,
    CreditCard,
    DollarSign,
    Calculator,
    Scan,
    Users,
    Package,
    X
} from 'lucide-vue-next';

const cart = ref([
    { id: 1, name: 'Wireless Headphones', price: 89.99, quantity: 1, image: '/placeholder.jpg' },
    { id: 2, name: 'Smartphone Case', price: 24.99, quantity: 2, image: '/placeholder.jpg' }
]);

const products = ref([
    { id: 1, name: 'Wireless Headphones', price: 89.99, stock: 15, category: 'Electronics' },
    { id: 2, name: 'Smartphone Case', price: 24.99, stock: 32, category: 'Accessories' },
    { id: 3, name: 'Bluetooth Speaker', price: 59.99, stock: 8, category: 'Electronics' },
    { id: 4, name: 'USB Cable', price: 12.99, stock: 50, category: 'Accessories' },
    { id: 5, name: 'Power Bank', price: 39.99, stock: 20, category: 'Electronics' },
    { id: 6, name: 'Screen Protector', price: 9.99, stock: 45, category: 'Accessories' }
]);

const subtotal = ref(139.97);
const tax = ref(11.20);
const total = ref(151.17);

const addToCart = (product) => {
    const existingItem = cart.value.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.value.push({ ...product, quantity: 1 });
    }
    updateTotals();
};

const removeFromCart = (productId) => {
    const index = cart.value.findIndex(item => item.id === productId);
    if (index > -1) {
        cart.value.splice(index, 1);
        updateTotals();
    }
};

const updateQuantity = (productId, change) => {
    const item = cart.value.find(item => item.id === productId);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        }
        updateTotals();
    }
};

const updateTotals = () => {
    const sub = cart.value.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    subtotal.value = sub;
    tax.value = sub * 0.08;
    total.value = sub + tax.value;
};
</script>

<template>
    <Head title="Point of Sale" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Point of Sale</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Process transactions and manage sales</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                        <Scan class="h-4 w-4" />
                        <span>Scan Barcode</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Products Grid -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Products</h3>
                            <div class="flex items-center space-x-4">
                                <input
                                    type="text"
                                    placeholder="Search products..."
                                    class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 text-sm"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                            <div
                                v-for="product in products"
                                :key="product.id"
                                @click="addToCart(product)"
                                class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all cursor-pointer group"
                            >
                                <div class="flex items-center justify-between mb-3">
                                    <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <Package class="h-6 w-6 text-white" />
                                    </div>
                                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2 py-1 rounded-full">
                                        {{ product.category }}
                                    </span>
                                </div>
                                <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ product.name }}</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">${{ product.price }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Stock: {{ product.stock }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart & Checkout -->
            <div class="space-y-6">
                <!-- Cart -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border-0">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Current Order</h3>
                            <div class="flex items-center space-x-2">
                                <ShoppingCart class="h-5 w-5 text-gray-400" />
                                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ cart.length }} items</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4 mb-6">
                            <div
                                v-for="item in cart"
                                :key="item.id"
                                class="flex items-center space-x-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-xl"
                            >
                                <div class="h-12 w-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <Package class="h-6 w-6 text-white" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ item.name }}</h4>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">${{ item.price }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button
                                        @click="updateQuantity(item.id, -1)"
                                        class="p-1 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors"
                                    >
                                        <Minus class="h-4 w-4" />
                                    </button>
                                    <span class="w-8 text-center font-semibold text-gray-900 dark:text-white">{{ item.quantity }}</span>
                                    <button
                                        @click="updateQuantity(item.id, 1)"
                                        class="p-1 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors"
                                    >
                                        <Plus class="h-4 w-4" />
                                    </button>
                                </div>
                                <button
                                    @click="removeFromCart(item.id)"
                                    class="p-1 rounded-lg bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                                >
                                    <X class="h-4 w-4 text-red-600 dark:text-red-400" />
                                </button>
                            </div>
                        </div>

                        <!-- Totals -->
                        <div class="space-y-3 border-t border-gray-100 dark:border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Tax</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">${{ tax.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                <span class="text-lg font-bold text-gray-900 dark:text-white">${{ total.toFixed(2) }}</span>
                            </div>
                        </div>

                        <!-- Payment Buttons -->
                        <div class="grid grid-cols-1 gap-3 mt-6">
                            <button class="flex items-center justify-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-colors font-semibold">
                                <CreditCard class="h-5 w-5" />
                                <span>Pay with Card</span>
                            </button>
                            <button class="flex items-center justify-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition-colors font-semibold">
                                <DollarSign class="h-5 w-5" />
                                <span>Cash Payment</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
