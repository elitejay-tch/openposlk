<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useMenuManager } from '@/composables/useMenuManager';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import SidebarMenuItem from '@/Components/SidebarMenuItem.vue';
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
    ChevronRight,
    Bell,
    Search,
    Shield,
    Database,
    TrendingUp,
    Calendar,
    MessageSquare,
    Archive,
    Truck,
    DollarSign,
    Receipt,
    UserCheck,
    Store,
    Layers,
    Globe
} from 'lucide-vue-next';

const page = usePage();
const {
    openSubmenus,
    toggleSubmenu,
    isSubmenuOpen,
    closeAllSubmenus,
    setActiveMenuItem
} = useMenuManager();

const sidebarOpen = ref(false);
const sidebarExpanded = ref(true);
const isMobile = ref(false);

// Get app name from environment or use default
const appName = computed(() => {
    return page.props.appName || import.meta.env.VITE_APP_NAME || 'POS System';
});

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
    updateActiveMenuItems();
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

// Watch for route changes to update active menu items
watch(() => page.url, () => {
    updateActiveMenuItems();
});

// Navigation items with nested structure
const navigation = ref([
    {
        id: 'dashboard',
        name: 'Dashboard',
        route: 'dashboard',
        icon: LayoutDashboard,
        exists: true,
        active: false
    },
    {
        id: 'sales',
        name: 'Sales',
        icon: ShoppingCart,
        exists: true,
        active: false,
        children: [
            {
                id: 'sales-pos',
                name: 'POS Terminal',
                route: 'sales.pos',
                icon: Store,
                exists: true, // Set to true since we'll create this route
                active: false
            },
            {
                id: 'sales-orders',
                name: 'Orders',
                route: 'sales.orders',
                icon: Receipt,
                exists: true, // Set to true since we'll create this route
                active: false,
                badge: '12'
            },
            {
                id: 'sales-invoices',
                name: 'Invoices',
                route: 'sales.invoices',
                icon: FileText,
                exists: true, // Set to true since we'll create this route
                active: false
            }
        ]
    },
    {
        id: 'inventory',
        name: 'Inventory',
        icon: Package,
        exists: true,
        active: false,
        children: [
            {
                id: 'products',
                name: 'Products',
                route: 'products.index',
                icon: Package,
                exists: true,
                active: false
            },
            {
                id: 'categories',
                name: 'Categories',
                route: 'categories.index',
                icon: Layers,
                exists: true,
                active: false
            },
            {
                id: 'suppliers',
                name: 'Suppliers',
                route: 'suppliers.index',
                icon: Truck,
                exists: true,
                active: false
            },
            {
                id: 'stock',
                name: 'Stock Management',
                route: 'stock.index',
                icon: Archive,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'customers',
        name: 'Customers',
        icon: Users,
        exists: true,
        active: false,
        children: [
            {
                id: 'customers-all',
                name: 'All Customers',
                route: 'customers.index',
                icon: Users,
                exists: true,
                active: false
            },
            {
                id: 'customers-groups',
                name: 'Customer Groups',
                route: 'customers.groups',
                icon: UserCheck,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'reports',
        name: 'Reports & Analytics',
        icon: BarChart3,
        exists: true,
        active: false,
        children: [
            {
                id: 'reports-sales',
                name: 'Sales Reports',
                route: 'reports.sales',
                icon: TrendingUp,
                exists: true,
                active: false
            },
            {
                id: 'reports-inventory',
                name: 'Inventory Reports',
                route: 'reports.inventory',
                icon: Database,
                exists: true,
                active: false
            },
            {
                id: 'reports-financial',
                name: 'Financial Reports',
                route: 'reports.financial',
                icon: DollarSign,
                exists: true,
                active: false
            }
        ]
    },
    {
        id: 'transactions',
        name: 'Transactions',
        route: 'transactions.index',
        icon: CreditCard,
        exists: true,
        active: false
    },
    {
        id: 'settings',
        name: 'Settings',
        icon: Settings,
        exists: true,
        active: false,
        children: [
            {
                id: 'settings-general',
                name: 'General Settings',
                route: 'settings.general',
                icon: Settings,
                exists: true,
                active: false
            },
            {
                id: 'settings-users',
                name: 'User Management',
                route: 'settings.users',
                icon: Shield,
                exists: true,
                active: false
            },
            {
                id: 'settings-system',
                name: 'System Settings',
                route: 'settings.system',
                icon: Globe,
                exists: true,
                active: false
            }
        ]
    }
]);

const updateActiveMenuItems = () => {
    const currentRoute = page.props.route || { name: '', path: '' };
    setActiveMenuItem(navigation.value, currentRoute);

    // Update isOpen state for submenus
    navigation.value.forEach(item => {
        if (item.children) {
            item.isOpen = isSubmenuOpen(item.id);
        }
    });
};

const handleToggleSubmenu = (menuId) => {
    toggleSubmenu(menuId);

    // Update isOpen state
    navigation.value.forEach(item => {
        if (item.id === menuId) {
            item.isOpen = isSubmenuOpen(menuId);
        }
    });
};

const toggleSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = !sidebarOpen.value;
    } else {
        sidebarExpanded.value = !sidebarExpanded.value;
        // Close all submenus when collapsing
        if (!sidebarExpanded.value) {
            closeAllSubmenus();
            updateActiveMenuItems();
        }
    }
};

const closeSidebar = () => {
    if (isMobile.value) {
        sidebarOpen.value = false;
    }
};

// Filter navigation to show existing or placeholder items
const filteredNavigation = computed(() => {
    return navigation.value.filter(item => item.exists || item.children);
});
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
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out shadow-lg"
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
                            {{ appName }}
                        </span>
                    </Link>

                    <!-- Desktop toggle -->
                    <button
                        v-if="!isMobile"
                        @click="toggleSidebar"
                        class="p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-colors"
                        :title="sidebarExpanded ? 'Collapse sidebar' : 'Expand sidebar'"
                    >
                        <ChevronLeft v-if="sidebarExpanded" class="h-5 w-5" />
                        <ChevronRight v-else class="h-5 w-5" />
                    </button>

                    <!-- Mobile close -->
                    <button
                        v-if="isMobile"
                        @click="closeSidebar"
                        class="p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-colors"
                    >
                        <X class="h-6 w-6" />
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto">
                    <ul class="space-y-2">
                        <SidebarMenuItem
                            v-for="item in filteredNavigation"
                            :key="item.id"
                            :item="item"
                            :is-collapsed="!sidebarExpanded"
                            :is-mobile="isMobile"
                            @toggle-submenu="handleToggleSubmenu"
                            @close-sidebar="closeSidebar"
                        />
                    </ul>
                </nav>

                <!-- User section -->
                <div class="p-4 border-t border-gray-200">
                    <div class="relative">
                        <Dropdown align="right" width="56">
                            <template #trigger>
                                <button
                                    :class="[
                                        'flex items-center w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors',
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
                                    <ChevronDown
                                        v-if="sidebarExpanded || isMobile"
                                        class="h-4 w-4 text-gray-400"
                                    />
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
                            class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 mr-4 transition-colors"
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
