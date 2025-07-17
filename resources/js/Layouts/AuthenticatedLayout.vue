<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    Users,
    Settings,
    FileText,
    ShoppingCart,
    BarChart3,
    Menu,
    X,
    ChevronDown,
    LogOut,
    User,
    Package,
    CreditCard,
    ChevronLeft,
    ChevronRight
} from 'lucide-vue-next';

const sidebarOpen = ref(false);
const sidebarExpanded = ref(true);
const isMobile = ref(false);

// Check if we're on mobile
const checkMobile = () => {
    isMobile.value = window.innerWidth < 1024;
    if (isMobile.value) {
        sidebarOpen.value = false;
    }
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

// Navigation items
const navigation = [
    { name: 'Dashboard', href: 'dashboard', icon: LayoutDashboard, exists: true },
    { name: 'Sales', href: 'sales.index', icon: ShoppingCart, exists: false },
    { name: 'Products', href: 'products.index', icon: Package, exists: false },
    { name: 'Customers', href: 'customers.index', icon: Users, exists: false },
    { name: 'Reports', href: 'reports.index', icon: BarChart3, exists: false },
    { name: 'Transactions', href: 'transactions.index', icon: CreditCard, exists: false },
    { name: 'Settings', href: 'settings.index', icon: Settings, exists: false },
];

const activeNavigation = navigation.filter(item => item.exists || item.href === '#');

const toggleSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = !sidebarOpen.value;
    } else {
        sidebarExpanded.value = !sidebarExpanded.value;
    }
};

const closeSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = false;
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Mobile sidebar overlay -->
        <div
            v-if="isMobile && sidebarOpen"
            class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 transition-opacity"
            @click="closeSidebar"
        ></div>

        <!-- Sidebar -->
        <div
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out"
            :class="[
                isMobile
                    ? (sidebarOpen ? 'translate-x-0' : '-translate-x-full') + ' w-64'
                    : 'translate-x-0 ' + (sidebarExpanded ? 'w-64' : 'w-16')
            ]"
        >
            <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
                    <Link :href="route('dashboard')" class="flex items-center space-x-2">
                        <ApplicationLogo class="h-8 w-8 text-gray-600 flex-shrink-0" />
                        <span
                            v-if="sidebarExpanded || isMobile"
                            class="text-xl font-semibold text-gray-900 whitespace-nowrap"
                        >
                            POS System
                        </span>
                    </Link>

                    <!-- Desktop toggle -->
                    <button
                        v-if="!isMobile"
                        @click="toggleSidebar"
                        class="p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
                    >
                        <ChevronLeft v-if="sidebarExpanded" class="h-5 w-5" />
                        <ChevronRight v-else class="h-5 w-5" />
                    </button>

                    <!-- Mobile close -->
                    <button
                        v-if="isMobile"
                        @click="closeSidebar"
                        class="p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
                    >
                        <X class="h-6 w-6" />
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <template v-for="item in activeNavigation" :key="item.name">
                        <!-- Existing routes -->
                        <Link
                            v-if="item.exists"
                            :href="route(item.href)"
                            :class="[
                                route().current(item.href)
                                    ? 'bg-gray-900 text-white'
                                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900',
                                'group flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors'
                            ]"
                            @click="closeSidebar"
                        >
                            <component
                                :is="item.icon"
                                :class="[
                                    route().current(item.href) ? 'text-white' : 'text-gray-400 group-hover:text-gray-600',
                                    'h-5 w-5 flex-shrink-0',
                                    (sidebarExpanded || isMobile) ? 'mr-3' : 'mx-auto'
                                ]"
                            />
                            <span v-if="sidebarExpanded || isMobile">{{ item.name }}</span>
                        </Link>

                        <!-- Placeholder for future routes -->
                        <div
                            v-else
                            :class="[
                                'group flex items-center px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-md',
                                !(sidebarExpanded || isMobile) && 'justify-center'
                            ]"
                        >
                            <component
                                :is="item.icon"
                                :class="[
                                    'h-5 w-5 text-gray-300 flex-shrink-0',
                                    (sidebarExpanded || isMobile) ? 'mr-3' : 'mx-auto'
                                ]"
                            />
                            <span v-if="sidebarExpanded || isMobile">{{ item.name }}</span>
                            <span v-if="sidebarExpanded || isMobile" class="ml-auto text-xs text-gray-300">(Soon)</span>
                        </div>
                    </template>
                </nav>

                <!-- User section -->
                <div class="p-4 border-t border-gray-200">
                    <div class="relative">
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button
                                    :class="[
                                        'flex items-center w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500',
                                        !(sidebarExpanded || isMobile) && 'justify-center'
                                    ]"
                                >
                                    <div class="flex items-center space-x-3 flex-1">
                                        <div class="flex-shrink-0 h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <User class="h-4 w-4 text-gray-500" />
                                        </div>
                                        <div v-if="sidebarExpanded || isMobile" class="text-left min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $page.props.auth.user.name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $page.props.auth.user.email }}</p>
                                        </div>
                                    </div>
                                    <ChevronDown v-if="sidebarExpanded || isMobile" class="h-4 w-4 text-gray-400" />
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    <div class="flex items-center">
                                        <User class="mr-3 h-4 w-4 text-gray-400" />
                                        Profile
                                    </div>
                                </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    <div class="flex items-center">
                                        <LogOut class="mr-3 h-4 w-4 text-gray-400" />
                                        Log Out
                                    </div>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div
            class="transition-all duration-300 ease-in-out"
            :class="[
                isMobile
                    ? 'ml-0'
                    : (sidebarExpanded ? 'ml-64' : 'ml-16')
            ]"
        >
            <!-- Top bar -->
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button
                            v-if="isMobile"
                            @click="toggleSidebar"
                            class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 mr-4"
                        >
                            <Menu class="h-6 w-6" />
                        </button>
                        <div>
                            <slot name="header" />
                        </div>
                    </div>

                    <!-- Desktop user menu -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-4">
                        <div class="text-sm text-gray-500">
                            Welcome back, {{ $page.props.auth.user.name }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
