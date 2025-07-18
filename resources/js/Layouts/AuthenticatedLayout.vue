<script setup>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/composables/useDarkMode';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard, Users, Settings, FileText, ShoppingCart, BarChart3,
    Menu, X, ChevronDown, LogOut, User, Package, CreditCard, Bell, Search,
    Shield, Database, TrendingUp, Archive, Truck, DollarSign, Receipt,
    UserCheck, Store, Layers, Globe, Plus, HelpCircle, Moon, Sun, Home,
    Activity, ChevronRight, Calendar, PieChart, Zap, ChevronLeft, Palette
} from 'lucide-vue-next';

const page = usePage();
const { isDarkMode, toggleDarkMode } = useDarkMode();

// Enhanced responsive state management
const sidebarOpen = ref(false);
const sidebarExpanded = ref(true);
const activeSubmenu = ref(null);
const submenuVisible = ref(false);
const windowWidth = ref(0);

// Improved device detection
const isMobile = computed(() => windowWidth.value < 768);
const isTablet = computed(() => windowWidth.value >= 768 && windowWidth.value < 1024);
const isDesktop = computed(() => windowWidth.value >= 1024);
const touchDevice = computed(() => isMobile.value || isTablet.value);

// Get app name from environment or use default
const appName = computed(() => {
    return page.props.appName || import.meta.env.VITE_APP_NAME || 'NexaFlow';
});

// Helper function to safely check if route exists
const routeExists = (routeName) => {
    try {
        route(routeName);
        return true;
    } catch (error) {
        return false;
    }
};

// Helper function to safely get route href
const safeRoute = (routeName, fallback = '#') => {
    try {
        return route(routeName);
    } catch (error) {
        console.warn(`Route '${routeName}' not found`);
        return fallback;
    }
};

// Enhanced responsive behavior
const updateResponsiveState = () => {
    windowWidth.value = window.innerWidth;

    // Auto-close sidebar and submenu on mobile
    if (isMobile.value) {
        sidebarExpanded.value = false;
        submenuVisible.value = false;
        activeSubmenu.value = null;
    } else if (isDesktop.value && windowWidth.value > 1200) {
        // Auto-expand on larger desktop screens
        sidebarExpanded.value = true;
    }
};

onMounted(() => {
    updateResponsiveState();
    window.addEventListener('resize', updateResponsiveState);
});

onUnmounted(() => {
    window.removeEventListener('resize', updateResponsiveState);
});

// Enhanced navigation structure - more enterprise focused
const navigation = ref([
    {
        id: 'dashboard',
        name: 'Dashboard',
        route: 'dashboard',
        icon: LayoutDashboard,
        color: 'blue',
        active: true,
        exists: true
    },
    {
        id: 'sales',
        name: 'Sales Management',
        icon: ShoppingCart,
        color: 'emerald',
        active: false,
        exists: true,
        children: [
            {
                id: 'pos',
                name: 'Point of Sale',
                route: 'sales.pos',
                icon: Store,
                description: 'POS Terminal & Transactions',
                exists: routeExists('sales.pos')
            },
            {
                id: 'orders',
                name: 'Order Management',
                route: 'sales.orders',
                icon: Receipt,
                description: 'Order Processing & Tracking',
                badge: '23',
                exists: routeExists('sales.orders')
            },
            {
                id: 'invoices',
                name: 'Invoice Management',
                route: 'sales.invoices',
                icon: FileText,
                description: 'Billing & Invoice Generation',
                exists: routeExists('sales.invoices')
            },
            {
                id: 'quotes',
                name: 'Quotation System',
                route: 'sales.quotes',
                icon: PieChart,
                description: 'Customer Quotes & Proposals',
                exists: routeExists('sales.quotes')
            }
        ]
    },
    {
        id: 'inventory',
        name: 'Inventory Control',
        icon: Package,
        color: 'orange',
        active: false,
        exists: true,
        children: [
            {
                id: 'products',
                name: 'Product Catalog',
                route: 'products.index',
                icon: Package,
                description: 'Product Information Management',
                exists: routeExists('products.index')
            },
            {
                id: 'categories',
                name: 'Category Management',
                route: 'categories.index',
                icon: Layers,
                description: 'Product Classification System',
                exists: routeExists('categories.index')
            },
            {
                id: 'suppliers',
                name: 'Supplier Relations',
                route: 'suppliers.index',
                icon: Truck,
                description: 'Vendor & Supplier Management',
                exists: routeExists('suppliers.index')
            },
            {
                id: 'stock',
                name: 'Stock Control',
                route: 'stock.index',
                icon: Archive,
                description: 'Inventory Levels & Tracking',
                badge: 'Low',
                exists: routeExists('stock.index')
            }
        ]
    },
    {
        id: 'customers',
        name: 'Customer Relations',
        icon: Users,
        color: 'purple',
        active: false,
        exists: true,
        children: [
            {
                id: 'all-customers',
                name: 'Customer Database',
                route: 'customers.index',
                icon: Users,
                description: 'Complete Customer Directory',
                exists: routeExists('customers.index')
            },
            {
                id: 'customer-groups',
                name: 'Customer Segmentation',
                route: 'customers.groups',
                icon: UserCheck,
                description: 'Customer Groups & Categories',
                exists: routeExists('customers.groups')
            },
            {
                id: 'loyalty',
                name: 'Loyalty Programs',
                route: 'customers.loyalty',
                icon: Zap,
                description: 'Customer Rewards & Retention',
                exists: routeExists('customers.loyalty')
            }
        ]
    },
    {
        id: 'reports',
        name: 'Analytics & Reports',
        icon: BarChart3,
        color: 'indigo',
        active: false,
        exists: true,
        children: [
            {
                id: 'sales-reports',
                name: 'Sales Analytics',
                route: 'reports.sales',
                icon: TrendingUp,
                description: 'Sales Performance Metrics',
                exists: routeExists('reports.sales')
            },
            {
                id: 'inventory-reports',
                name: 'Inventory Analytics',
                route: 'reports.inventory',
                icon: Database,
                description: 'Stock Movement Analysis',
                exists: routeExists('reports.inventory')
            },
            {
                id: 'financial-reports',
                name: 'Financial Reports',
                route: 'reports.financial',
                icon: DollarSign,
                description: 'Financial Performance Analysis',
                exists: routeExists('reports.financial')
            },
            {
                id: 'custom-reports',
                name: 'Custom Reports',
                route: 'reports.custom',
                icon: Calendar,
                description: 'Build Custom Analytics',
                exists: routeExists('reports.custom')
            }
        ]
    },
    {
        id: 'transactions',
        name: 'Financial Transactions',
        route: 'transactions.index',
        icon: CreditCard,
        color: 'cyan',
        active: false,
        exists: routeExists('transactions.index')
    },
    {
        id: 'settings',
        name: 'System Administration',
        icon: Settings,
        color: 'slate',
        active: false,
        exists: true,
        children: [
            {
                id: 'general-settings',
                name: 'General Settings',
                route: 'settings.general',
                icon: Settings,
                description: 'Application Configuration',
                exists: routeExists('settings.general')
            },
            {
                id: 'user-management',
                name: 'User Management',
                route: 'settings.users',
                icon: Shield,
                description: 'Users, Roles & Permissions',
                exists: routeExists('settings.users')
            },
            {
                id: 'system-settings',
                name: 'System Configuration',
                route: 'settings.system',
                icon: Globe,
                description: 'System-wide Settings',
                exists: routeExists('settings.system')
            }
        ]
    }
]);

// Enhanced touch event handling
const handleMenuClick = (item) => {
    if (item.children && item.children.length > 0) {
        if (activeSubmenu.value === item.id) {
            activeSubmenu.value = null;
            submenuVisible.value = false;
        } else {
            activeSubmenu.value = item.id;
            submenuVisible.value = true;
        }
    } else {
        activeSubmenu.value = null;
        submenuVisible.value = false;
        if (touchDevice.value) {
            sidebarOpen.value = false;
        }
    }
};

const handleSubmenuItemClick = () => {
    if (touchDevice.value) {
        sidebarOpen.value = false;
        submenuVisible.value = false;
        activeSubmenu.value = null;
    }
};

const toggleSidebar = () => {
    if (touchDevice.value) {
        sidebarOpen.value = !sidebarOpen.value;
    } else {
        sidebarExpanded.value = !sidebarExpanded.value;
        if (!sidebarExpanded.value) {
            submenuVisible.value = false;
            activeSubmenu.value = null;
        }
    }
};

// Close sidebar when clicking outside on mobile
const handleOutsideClick = () => {
    if (touchDevice.value && sidebarOpen.value) {
        sidebarOpen.value = false;
        submenuVisible.value = false;
        activeSubmenu.value = null;
    }
};

const activeSubmenuData = computed(() => {
    if (!activeSubmenu.value) return null;
    return navigation.value.find(item => item.id === activeSubmenu.value);
});

const availableChildren = computed(() => {
    if (!activeSubmenuData.value || !activeSubmenuData.value.children) return [];
    return activeSubmenuData.value.children.filter(child => child.exists);
});

// Enhanced enterprise color system
const getColorClasses = (color, active = false) => {
    const colors = {
        blue: active ? 'bg-blue-50 text-blue-700 border-blue-200' : 'hover:bg-blue-50/70 hover:text-blue-700',
        emerald: active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'hover:bg-emerald-50/70 hover:text-emerald-700',
        orange: active ? 'bg-orange-50 text-orange-700 border-orange-200' : 'hover:bg-orange-50/70 hover:text-orange-700',
        purple: active ? 'bg-purple-50 text-purple-700 border-purple-200' : 'hover:bg-purple-50/70 hover:text-purple-700',
        indigo: active ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'hover:bg-indigo-50/70 hover:text-indigo-700',
        cyan: active ? 'bg-cyan-50 text-cyan-700 border-cyan-200' : 'hover:bg-cyan-50/70 hover:text-cyan-700',
        slate: active ? 'bg-slate-100 text-slate-700 border-slate-200' : 'hover:bg-slate-50/70 hover:text-slate-700'
    };
    return colors[color] || colors.slate;
};

const getIconColorClasses = (color, active = false) => {
    const colors = {
        blue: active ? 'text-blue-600' : 'text-blue-500',
        emerald: active ? 'text-emerald-600' : 'text-emerald-500',
        orange: active ? 'text-orange-600' : 'text-orange-500',
        purple: active ? 'text-purple-600' : 'text-purple-500',
        indigo: active ? 'text-indigo-600' : 'text-indigo-500',
        cyan: active ? 'text-cyan-600' : 'text-cyan-500',
        slate: active ? 'text-slate-600' : 'text-slate-500'
    };
    return colors[color] || colors.slate;
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Mobile Overlay -->
        <div
            v-if="touchDevice && sidebarOpen"
            class="fixed inset-0 z-40 bg-black/30 backdrop-blur-sm"
            @click="handleOutsideClick"
        />

        <!-- Main Sidebar -->
        <div
            class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 shadow-lg"
            :class="[
                touchDevice
                    ? (sidebarOpen ? 'translate-x-0' : '-translate-x-full') + ' w-80'
                    : 'translate-x-0 ' + (sidebarExpanded ? 'w-80' : 'w-16')
            ]"
        >
            <!-- Logo Header -->
            <div class="h-16 px-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-750">
                <Link :href="route('dashboard')" class="flex items-center space-x-3 group min-w-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow flex-shrink-0">
                        <ApplicationLogo class="h-6 w-6 text-white" />
                    </div>
                    <div v-if="sidebarExpanded || touchDevice" class="flex flex-col min-w-0">
                        <span class="text-lg font-bold text-gray-900 dark:text-white truncate">
                            {{ appName }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                            Enterprise Suite
                        </span>
                    </div>
                </Link>

                <button
                    v-if="!touchDevice"
                    @click="toggleSidebar"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all flex-shrink-0"
                >
                    <ChevronLeft v-if="sidebarExpanded" class="h-4 w-4" />
                    <ChevronRight v-else class="h-4 w-4" />
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="space-y-2">
                    <div v-for="item in navigation" :key="item.id">
                        <!-- Main Menu Item (No Children) -->
                        <Link
                            v-if="!item.children && item.exists"
                            :href="safeRoute(item.route)"
                            :class="[
                                'flex items-center w-full p-3 rounded-lg transition-all duration-200 border text-sm font-medium group',
                                'min-h-[48px]',
                                item.active
                                    ? getColorClasses(item.color, true) + ' shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 border-transparent ' + getColorClasses(item.color)
                            ]"
                        >
                            <component
                                :is="item.icon"
                                :class="[
                                    'h-5 w-5 flex-shrink-0 transition-colors',
                                    item.active ? getIconColorClasses(item.color, true) : 'text-gray-500 dark:text-gray-400 group-hover:' + getIconColorClasses(item.color, false).replace('text-', '')
                                ]"
                            />
                            <span v-if="sidebarExpanded || touchDevice" class="ml-3 truncate">
                                {{ item.name }}
                            </span>
                        </Link>

                        <!-- Menu Item with Children -->
                        <button
                            v-else-if="item.children && item.exists"
                            :class="[
                                'flex items-center w-full p-3 rounded-lg transition-all duration-200 border text-sm font-medium group',
                                'min-h-[48px]',
                                activeSubmenu === item.id
                                    ? getColorClasses(item.color, true) + ' shadow-sm'
                                    : 'text-gray-700 dark:text-gray-300 border-transparent ' + getColorClasses(item.color)
                            ]"
                            @click="handleMenuClick(item)"
                        >
                            <component
                                :is="item.icon"
                                :class="[
                                    'h-5 w-5 flex-shrink-0 transition-colors',
                                    activeSubmenu === item.id ? getIconColorClasses(item.color, true) : 'text-gray-500 dark:text-gray-400 group-hover:' + getIconColorClasses(item.color, false).replace('text-', '')
                                ]"
                            />
                            <div v-if="sidebarExpanded || touchDevice" class="ml-3 flex-1 flex items-center justify-between min-w-0">
                                <span class="truncate">{{ item.name }}</span>
                                <ChevronRight
                                    :class="[
                                        'h-4 w-4 transition-transform duration-200 flex-shrink-0 ml-2',
                                        activeSubmenu === item.id ? 'rotate-90' : 'rotate-0'
                                    ]"
                                />
                            </div>
                        </button>

                        <!-- Submenu Items (Mobile Inline) -->
                        <div
                            v-if="touchDevice && activeSubmenu === item.id && availableChildren.length > 0"
                            class="ml-8 mt-2 space-y-1 border-l-2 border-gray-200 dark:border-gray-600 pl-4"
                        >
                            <Link
                                v-for="child in availableChildren"
                                :key="child.id"
                                :href="safeRoute(child.route)"
                                class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-sm min-h-[44px] group"
                                @click="handleSubmenuItemClick"
                            >
                                <component :is="child.icon" class="h-4 w-4 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 flex-shrink-0" />
                                <div class="ml-3 flex-1 min-w-0">
                                    <span class="text-gray-600 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white truncate block">{{ child.name }}</span>
                                </div>
                                <span
                                    v-if="child.badge"
                                    :class="[
                                        'text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 ml-2',
                                        child.badge === 'Low' ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400'
                                    ]"
                                >
                                    {{ child.badge }}
                                </span>
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Desktop Submenu Panel -->
        <div
            v-if="!touchDevice && submenuVisible && activeSubmenuData && sidebarExpanded && availableChildren.length > 0"
            class="fixed inset-y-0 left-80 z-40 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-lg transition-all duration-300"
        >
            <!-- Submenu Header -->
            <div class="h-16 px-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-750">
                <div class="flex items-center space-x-3 min-w-0">
                    <div :class="[
                        'w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0',
                        getColorClasses(activeSubmenuData.color, true)
                    ]">
                        <component :is="activeSubmenuData.icon" class="h-4 w-4" />
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                            {{ activeSubmenuData.name }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ availableChildren.length }} modules
                        </p>
                    </div>
                </div>
                <button
                    @click="submenuVisible = false; activeSubmenu = null"
                    class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex-shrink-0"
                >
                    <X class="h-4 w-4" />
                </button>
            </div>

            <!-- Submenu Content -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="space-y-2">
                    <Link
                        v-for="child in availableChildren"
                        :key="child.id"
                        :href="safeRoute(child.route)"
                        class="group flex items-start p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 border border-transparent hover:border-gray-200 dark:hover:border-gray-600 min-h-[60px]"
                        @click="handleSubmenuItemClick"
                    >
                        <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-white dark:group-hover:bg-gray-600 transition-colors flex-shrink-0">
                            <component :is="child.icon" class="h-5 w-5 text-gray-600 dark:text-gray-300" />
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-sm text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200 truncate">
                                    {{ child.name }}
                                </h4>
                                <span
                                    v-if="child.badge"
                                    :class="[
                                        'text-xs px-2 py-1 rounded-full font-medium flex-shrink-0 ml-2',
                                        child.badge === 'Low' ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400'
                                    ]"
                                >
                                    {{ child.badge }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 group-hover:text-gray-600 dark:group-hover:text-gray-300">
                                {{ child.description }}
                            </p>
                        </div>
                    </Link>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div
            class="transition-all duration-300"
            :class="[
                touchDevice ? 'ml-0' : (
                    sidebarExpanded
                        ? (submenuVisible && availableChildren.length > 0 ? 'ml-[38rem]' : 'ml-80')
                        : 'ml-16'
                )
            ]"
        >
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <!-- Left Side -->
                    <div class="flex items-center space-x-4">
                        <button
                            v-if="touchDevice"
                            @click="toggleSidebar"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"
                        >
                            <Menu class="h-5 w-5" />
                        </button>

                        <div class="flex-1">
                            <slot name="header" />
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-2">
                        <!-- Theme Toggle -->
                        <button
                            @click="toggleDarkMode"
                            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"
                            :title="isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                        >
                            <component :is="isDarkMode ? Sun : Moon" class="h-5 w-5" />
                        </button>

                        <!-- Search -->
                        <button class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center">
                            <Search class="h-5 w-5" />
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center">
                            <Bell class="h-5 w-5" />
                            <span class="absolute top-1.5 right-1.5 h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Quick Action -->
                        <button class="hidden sm:flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors min-h-[44px]">
                            <Plus class="h-4 w-4" />
                            <span>Quick Action</span>
                        </button>

                        <!-- User Menu -->
                        <Dropdown align="right" width="64">
                            <template #trigger>
                                <button class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors min-h-[44px]">
                                    <!-- Circular Avatar -->
                                    <img
                                        class="h-8 w-8 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=3b82f6&color=fff&rounded=true&size=32`"
                                        :alt="$page.props.auth.user.name"
                                    />
                                    <div class="hidden lg:block text-left">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200 truncate max-w-[120px]">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[120px]">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>
                                    <ChevronDown class="hidden lg:block h-4 w-4 text-gray-400 flex-shrink-0" />
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

                                <DropdownLink :href="route('profile.edit')" class="min-h-[44px] flex items-center">
                                    <div class="flex items-center">
                                        <User class="mr-3 h-4 w-4 text-gray-400" />
                                        Profile Settings
                                    </div>
                                </DropdownLink>

                                <DropdownLink href="#" class="min-h-[44px] flex items-center">
                                    <div class="flex items-center">
                                        <HelpCircle class="mr-3 h-4 w-4 text-gray-400" />
                                        Help & Support
                                    </div>
                                </DropdownLink>

                                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

                                <DropdownLink :href="route('logout')" method="post" as="button" class="min-h-[44px] flex items-center text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <div class="flex items-center">
                                        <LogOut class="mr-3 h-4 w-4 text-red-500" />
                                        Sign Out
                                    </div>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Enhanced scrollbar styling for enterprise look */
nav::-webkit-scrollbar {
    width: 6px;
}

nav::-webkit-scrollbar-track {
    background: transparent;
}

nav::-webkit-scrollbar-thumb {
    background: rgba(156, 163, 175, 0.4);
    border-radius: 3px;
}

nav::-webkit-scrollbar-thumb:hover {
    background: rgba(156, 163, 175, 0.6);
}

/* Dark mode scrollbar */
.dark nav::-webkit-scrollbar-thumb {
    background: rgba(75, 85, 99, 0.4);
}

.dark nav::-webkit-scrollbar-thumb:hover {
    background: rgba(75, 85, 99, 0.6);
}

/* Smooth transitions for all interactive elements */
button, a {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Focus styles for accessibility */
button:focus-visible, a:focus-visible {
    outline: 2px solid rgb(59, 130, 246);
    outline-offset: 2px;
}

/* Enhanced hover states */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}
</style>
