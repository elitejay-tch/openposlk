<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard, Users, Settings, FileText, ShoppingCart, BarChart3,
    Menu, X, ChevronDown, LogOut, User, Package, CreditCard, Bell, Search,
    TrendingUp, Receipt, Store, ChevronRight, ChevronLeft, Plus, HelpCircle,
    Moon, Sun
} from 'lucide-vue-next';

const page = usePage();
const { isDarkMode, toggleDarkMode } = useDarkMode();

// Responsive state
const sidebarOpen = ref(false);
const sidebarExpanded = ref(true);
const activeSubmenu = ref(null);
const windowWidth = ref(0);
const searchOpen = ref(false);
const notificationOpen = ref(false);

// Device detection
const isMobile = computed(() => windowWidth.value < 768);
const isTablet = computed(() => windowWidth.value >= 768 && windowWidth.value < 1024);
const isDesktop = computed(() => windowWidth.value >= 1024);
const isLargeScreen = computed(() => windowWidth.value >= 1280);

// App name
const appName = computed(() => {
    return page.props.appName || import.meta.env.VITE_APP_NAME || 'NexaFlow';
});

// Route helpers
const routeExists = (routeName) => {
    try {
        route(routeName);
        return true;
    } catch {
        return false;
    }
};

const safeRoute = (routeName, fallback = '#') => {
    try {
        return route(routeName);
    } catch {
        return fallback;
    }
};

// Navigation structure
const navigation = ref([
    {
        id: 'dashboard',
        name: 'Dashboard',
        route: 'dashboard',
        icon: LayoutDashboard,
        color: 'blue',
        active: true
    },
    {
        id: 'sales',
        name: 'Sales',
        icon: ShoppingCart,
        color: 'emerald',
        children: [
            {
                id: 'pos',
                name: 'Point of Sale',
                route: 'sales.pos',
                icon: Store,
                description: 'POS Terminal & Transactions'
            },
            {
                id: 'orders',
                name: 'Orders',
                route: 'sales.orders',
                icon: Receipt,
                description: 'Order Processing',
                badge: '23'
            },
            {
                id: 'invoices',
                name: 'Invoices',
                route: 'sales.invoices',
                icon: FileText,
                description: 'Billing & Invoices'
            }
        ]
    },
    {
        id: 'inventory',
        name: 'Inventory',
        icon: Package,
        color: 'orange',
        children: [
            {
                id: 'products',
                name: 'Products',
                route: 'products.index',
                icon: Package,
                description: 'Product Management'
            }
        ]
    },
    {
        id: 'customers',
        name: 'Customers',
        icon: Users,
        color: 'purple',
        children: [
            {
                id: 'all-customers',
                name: 'All Customers',
                route: 'customers.index',
                icon: Users,
                description: 'Customer Directory'
            }
        ]
    },
    {
        id: 'reports',
        name: 'Reports',
        icon: BarChart3,
        color: 'indigo',
        children: [
            {
                id: 'sales-reports',
                name: 'Sales Reports',
                route: 'reports.sales',
                icon: TrendingUp,
                description: 'Sales Analytics'
            }
        ]
    },
    {
        id: 'transactions',
        name: 'Transactions',
        route: 'transactions.index',
        icon: CreditCard,
        color: 'cyan'
    },
    {
        id: 'settings',
        name: 'Settings',
        icon: Settings,
        color: 'slate',
        children: [
            {
                id: 'general',
                name: 'General',
                route: 'settings.general',
                icon: Settings,
                description: 'App Configuration'
            }
        ]
    }
]);

// Responsive behavior
const updateWindowSize = () => {
    const prevWidth = windowWidth.value;
    windowWidth.value = window.innerWidth;

    if (prevWidth !== windowWidth.value) {
        searchOpen.value = false;
        notificationOpen.value = false;
    }

    if (isMobile.value) {
        sidebarExpanded.value = false;
        if (prevWidth >= 768) {
            sidebarOpen.value = false;
            activeSubmenu.value = null;
        }
    } else if (isDesktop.value && prevWidth < 1024) {
        sidebarExpanded.value = true;
    }
};

let resizeTimeout;
const debouncedResize = () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(updateWindowSize, 150);
};

onMounted(() => {
    updateWindowSize();
    window.addEventListener('resize', debouncedResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', debouncedResize);
    if (resizeTimeout) clearTimeout(resizeTimeout);
});

// Navigation handlers
const toggleSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = !sidebarOpen.value;
    } else {
        sidebarExpanded.value = !sidebarExpanded.value;
        if (!sidebarExpanded.value) {
            activeSubmenu.value = null;
        }
    }
};

const toggleSubmenu = (itemId) => {
    if (activeSubmenu.value === itemId) {
        activeSubmenu.value = null;
    } else {
        activeSubmenu.value = itemId;
    }
};

const closeAllDropdowns = () => {
    if (isMobile.value) {
        sidebarOpen.value = false;
    }
    activeSubmenu.value = null;
    searchOpen.value = false;
    notificationOpen.value = false;
};

// Color utilities using only Tailwind classes
const getNavItemClasses = (color, active = false) => {
    const baseClasses = 'flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 group';

    if (active) {
        const activeColors = {
            blue: 'bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-700/50',
            emerald: 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-300 dark:border-emerald-700/50',
            orange: 'bg-orange-50 text-orange-700 border border-orange-200 dark:bg-orange-900/20 dark:text-orange-300 dark:border-orange-700/50',
            purple: 'bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-700/50',
            indigo: 'bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-900/20 dark:text-indigo-300 dark:border-indigo-700/50',
            cyan: 'bg-cyan-50 text-cyan-700 border border-cyan-200 dark:bg-cyan-900/20 dark:text-cyan-300 dark:border-cyan-700/50',
            slate: 'bg-slate-100 text-slate-700 border border-slate-300 dark:bg-slate-700/50 dark:text-slate-200 dark:border-slate-600'
        };
        return `${baseClasses} ${activeColors[color] || activeColors.slate}`;
    }

    const hoverColors = {
        blue: 'hover:bg-blue-50/70 hover:text-blue-700 dark:hover:bg-blue-900/10 dark:hover:text-blue-300',
        emerald: 'hover:bg-emerald-50/70 hover:text-emerald-700 dark:hover:bg-emerald-900/10 dark:hover:text-emerald-300',
        orange: 'hover:bg-orange-50/70 hover:text-orange-700 dark:hover:bg-orange-900/10 dark:hover:text-orange-300',
        purple: 'hover:bg-purple-50/70 hover:text-purple-700 dark:hover:bg-purple-900/10 dark:hover:text-purple-300',
        indigo: 'hover:bg-indigo-50/70 hover:text-indigo-700 dark:hover:bg-indigo-900/10 dark:hover:text-indigo-300',
        cyan: 'hover:bg-cyan-50/70 hover:text-cyan-700 dark:hover:bg-cyan-900/10 dark:hover:text-cyan-300',
        slate: 'hover:bg-slate-50/70 hover:text-slate-700 dark:hover:bg-slate-700/30 dark:hover:text-slate-200'
    };

    return `${baseClasses} text-gray-700 dark:text-gray-300 border border-transparent ${hoverColors[color] || hoverColors.slate}`;
};

// Layout classes
const sidebarClasses = computed(() => {
    const baseClasses = 'fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 shadow-lg';

    if (isMobile.value) {
        return `${baseClasses} w-72 transform ${sidebarOpen.value ? 'translate-x-0' : '-translate-x-full'}`;
    }

    return `${baseClasses} ${sidebarExpanded.value ? 'w-72' : 'w-16'}`;
});

const submenuClasses = computed(() => {
    if (isMobile.value || !sidebarExpanded.value || !activeSubmenu.value) return 'hidden';

    const activeItem = navigation.value.find(item => item.id === activeSubmenu.value);
    if (!activeItem?.children?.length) return 'hidden';

    return 'fixed inset-y-0 left-72 z-40 w-80 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-lg transform transition-all duration-300';
});

const mainContentClasses = computed(() => {
    const baseClasses = 'min-h-screen transition-all duration-300';

    if (isMobile.value) {
        return `${baseClasses} ml-0`;
    }

    if (!sidebarExpanded.value) {
        return `${baseClasses} ml-16`;
    }

    const hasActiveSubmenu = activeSubmenu.value &&
        navigation.value.find(item => item.id === activeSubmenu.value)?.children?.length;

    return `${baseClasses} ${hasActiveSubmenu ? 'ml-[22rem]' : 'ml-72'}`;
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Mobile Overlay -->
        <div
            v-if="isMobile && (sidebarOpen || searchOpen || notificationOpen)"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm transition-opacity duration-300"
            @click="closeAllDropdowns"
        />

        <!-- Main Sidebar -->
        <aside :class="sidebarClasses">
            <!-- Logo Header -->
            <div class="h-16 px-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-gray-800">
                <Link :href="route('dashboard')" class="flex items-center space-x-3 group min-w-0 flex-1">
                    <ApplicationLogo class="h-6 w-6 text-white" />
                    <div v-if="sidebarExpanded || isMobile" class="flex flex-col min-w-0 flex-1">
                        <span class="text-lg font-bold text-gray-900 dark:text-white truncate">
                            {{ appName }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                            Enterprise Suite
                        </span>
                    </div>
                </Link>

                <button
                    v-if="!isMobile"
                    @click="toggleSidebar"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 flex-shrink-0"
                >
                    <ChevronLeft v-if="sidebarExpanded" class="h-4 w-4" />
                    <ChevronRight v-else class="h-4 w-4" />
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-3 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent">
                <div class="space-y-1">
                    <template v-for="item in navigation" :key="item.id">
                        <!-- Simple Navigation Item -->
                        <Link
                            v-if="!item.children"
                            :href="safeRoute(item.route)"
                            :class="getNavItemClasses(item.color, item.active)"
                            @click="closeAllDropdowns"
                        >
                            <component :is="item.icon" class="h-5 w-5 flex-shrink-0" />
                            <span v-if="sidebarExpanded || isMobile" class="ml-3 truncate">
                                {{ item.name }}
                            </span>
                        </Link>

                        <!-- Parent Navigation Item -->
                        <div v-else>
                            <button
                                :class="getNavItemClasses(item.color, activeSubmenu === item.id)"
                                @click="toggleSubmenu(item.id)"
                            >
                                <component :is="item.icon" class="h-5 w-5 flex-shrink-0" />
                                <span v-if="sidebarExpanded || isMobile" class="ml-3 flex-1 text-left truncate">
                                    {{ item.name }}
                                </span>
                                <ChevronRight
                                    v-if="sidebarExpanded || isMobile"
                                    class="h-4 w-4 transition-transform duration-200 flex-shrink-0 ml-auto"
                                    :class="{ 'rotate-90': activeSubmenu === item.id }"
                                />
                            </button>

                            <!-- Mobile Inline Submenu -->
                            <div
                                v-if="isMobile && activeSubmenu === item.id && item.children?.length"
                                class="ml-8 mt-1 space-y-1 border-l-2 border-gray-200 dark:border-gray-600 pl-3 transition-all duration-300"
                            >
                                <Link
                                    v-for="child in item.children"
                                    :key="child.id"
                                    :href="safeRoute(child.route)"
                                    class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group"
                                    @click="closeAllDropdowns"
                                >
                                    <component :is="child.icon" class="h-4 w-4 text-gray-500 dark:text-gray-400 flex-shrink-0" />
                                    <span class="ml-3 truncate">{{ child.name }}</span>
                                    <span
                                        v-if="child.badge"
                                        class="ml-auto text-xs px-2 py-0.5 bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 rounded-full font-medium flex-shrink-0"
                                    >
                                        {{ child.badge }}
                                    </span>
                                </Link>
                            </div>
                        </div>
                    </template>
                </div>
            </nav>
        </aside>

        <!-- Desktop Submenu Panel -->
        <aside :class="submenuClasses">
            <div
                v-if="activeSubmenu && navigation.find(item => item.id === activeSubmenu)?.children?.length"
                class="h-full flex flex-col"
            >
                <!-- Submenu Header -->
                <div class="h-16 px-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-white dark:bg-gray-800">
                    <div class="flex items-center space-x-3 min-w-0 flex-1">
                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <component :is="navigation.find(item => item.id === activeSubmenu)?.icon" class="h-4 w-4 text-gray-600 dark:text-gray-400" />
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                {{ navigation.find(item => item.id === activeSubmenu)?.name }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ navigation.find(item => item.id === activeSubmenu)?.children?.length }} modules
                            </p>
                        </div>
                    </div>
                    <button
                        @click="activeSubmenu = null"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex-shrink-0"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>

                <!-- Submenu Content -->
                <nav class="flex-1 p-4 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent">
                    <div class="space-y-2">
                        <Link
                            v-for="child in navigation.find(item => item.id === activeSubmenu)?.children || []"
                            :key="child.id"
                            :href="safeRoute(child.route)"
                            class="group flex items-start p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        >
                            <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-white dark:group-hover:bg-gray-600 transition-colors duration-200 flex-shrink-0">
                                <component :is="child.icon" class="h-5 w-5 text-gray-600 dark:text-gray-300" />
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium text-sm text-gray-900 dark:text-white truncate">
                                        {{ child.name }}
                                    </h4>
                                    <span
                                        v-if="child.badge"
                                        class="text-xs px-2 py-1 bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 rounded-full font-medium flex-shrink-0 ml-2"
                                    >
                                        {{ child.badge }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ child.description }}
                                </p>
                            </div>
                        </Link>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div :class="mainContentClasses">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <!-- Left Side -->
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <button
                            v-if="isMobile"
                            @click="toggleSidebar"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex-shrink-0"
                        >
                            <Menu class="h-5 w-5" />
                        </button>

                        <div class="flex-1 min-w-0">
                            <slot name="header">
                                <h1 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                    Dashboard
                                </h1>
                            </slot>
                        </div>
                    </div>

                    <!-- Center - Search Bar -->
                    <div class="flex-1 max-w-md mx-4 hidden md:block">
                        <div class="relative">
                            <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                            <input
                                type="text"
                                placeholder="Search..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0">
                        <!-- Mobile Search Toggle -->
                        <button
                            v-if="isMobile"
                            @click="searchOpen = !searchOpen"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex-shrink-0"
                            :class="{ 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300': searchOpen }"
                        >
                            <Search class="h-5 w-5" />
                        </button>

                        <!-- Notifications -->
                        <div class="relative">
                            <button
                                @click="notificationOpen = !notificationOpen"
                                class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex-shrink-0"
                                :class="{ 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300': notificationOpen }"
                            >
                                <Bell class="h-5 w-5" />
                                <span class="absolute top-1.5 right-1.5 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div
                                v-if="notificationOpen"
                                class="absolute right-0 top-full mt-2 w-80 max-w-[calc(100vw-2rem)] bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50 transform transition-all duration-200 origin-top-right"
                            >
                                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                </div>
                                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                    No new notifications
                                </div>
                            </div>
                        </div>

                        <!-- Theme Toggle - Moved before user profile -->
                        <button
                            @click="toggleDarkMode"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 flex-shrink-0"
                        >
                            <component :is="isDarkMode ? Sun : Moon" class="h-5 w-5" />
                        </button>

                        <!-- User Menu -->
                        <Dropdown align="right" width="64">
                            <template #trigger>
                                <button class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 min-w-0">
                                    <img
                                        class="h-8 w-8 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600 flex-shrink-0"
                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=3b82f6&color=fff&rounded=true&size=32`"
                                        :alt="$page.props.auth.user.name"
                                    />
                                    <div v-if="isLargeScreen" class="text-left min-w-0 max-w-[120px] hidden lg:block">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200 truncate">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>
                                    <ChevronDown v-if="isLargeScreen" class="h-4 w-4 text-gray-400 flex-shrink-0 hidden lg:block" />
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $page.props.auth.user.email }}
                                    </p>
                                </div>

                                <DropdownLink :href="route('profile.edit')" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <User class="mr-3 h-4 w-4 text-gray-400" />
                                    <span>Profile Settings</span>
                                </DropdownLink>

                                <DropdownLink href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <HelpCircle class="mr-3 h-4 w-4 text-gray-400" />
                                    <span>Help & Support</span>
                                </DropdownLink>

                                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20"
                                >
                                    <LogOut class="mr-3 h-4 w-4 text-red-500" />
                                    <span>Sign Out</span>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Mobile Search Bar -->
                <div
                    v-if="isMobile && searchOpen"
                    class="px-4 pb-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 transition-all duration-300"
                >
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                        <input
                            type="text"
                            placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>
                </div>
            </header>

<!--             Page Content-->
            <main class="p-4 sm:p-6 lg:p-8 max-w-full overflow-x-hidden">
                <slot />
            </main>
        </div>
    </div>
</template>
