<!--<template>-->
<!--    <li class="relative">-->
<!--        &lt;!&ndash; Menu item without children &ndash;&gt;-->
<!--        <Link-->
<!--            v-if="!item.children || item.children.length === 0"-->
<!--            :href="getMenuItemHref(item)"-->
<!--            :class="menuItemClasses"-->
<!--            @click="handleClick"-->
<!--            :disabled="item.disabled || !item.exists"-->
<!--        >-->
<!--            <div class="flex items-center min-w-0 flex-1">-->
<!--                <div class="relative">-->
<!--                    <component-->
<!--                        :is="item.icon"-->
<!--                        :class="iconClasses"-->
<!--                    />-->
<!--                    &lt;!&ndash; Active indicator dot &ndash;&gt;-->
<!--                    <div v-if="item.active && item.exists" class="absolute -top-1 -right-1 h-2 w-2 bg-emerald-400 rounded-full ring-2 ring-white dark:ring-slate-800"></div>-->
<!--                </div>-->
<!--                <div v-if="showLabel" class="ml-4 flex-1 min-w-0">-->
<!--                    <p class="font-semibold truncate">{{ item.name }}</p>-->
<!--                    <p v-if="item.description" class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ item.description }}</p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div v-if="showLabel" class="flex items-center space-x-2">-->
<!--                <span v-if="item.badge" :class="badgeClasses">{{ item.badge }}</span>-->
<!--                <span v-if="!item.exists" class="text-xs px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-md font-medium">Soon</span>-->
<!--            </div>-->
<!--        </Link>-->

<!--        &lt;!&ndash; Menu item with children &ndash;&gt;-->
<!--        <div v-else>-->
<!--            <button-->
<!--                :class="menuItemClasses"-->
<!--                @click="toggleSubmenu"-->
<!--                :disabled="item.disabled"-->
<!--            >-->
<!--                <div class="flex items-center min-w-0 flex-1">-->
<!--                    <div class="relative">-->
<!--                        <component-->
<!--                            :is="item.icon"-->
<!--                            :class="iconClasses"-->
<!--                        />-->
<!--                        &lt;!&ndash; Active indicator dot &ndash;&gt;-->
<!--                        <div v-if="item.active && item.exists" class="absolute -top-1 -right-1 h-2 w-2 bg-emerald-400 rounded-full ring-2 ring-white dark:ring-slate-800"></div>-->
<!--                    </div>-->
<!--                    <div v-if="showLabel" class="ml-4 flex-1 min-w-0">-->
<!--                        <p class="font-semibold truncate">{{ item.name }}</p>-->
<!--                        <p v-if="item.description" class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ item.description }}</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div v-if="showLabel" class="flex items-center space-x-2">-->
<!--                    <span v-if="item.badge" :class="badgeClasses">{{ item.badge }}</span>-->
<!--                    <ChevronDown :class="chevronClasses" />-->
<!--                </div>-->
<!--            </button>-->

<!--            &lt;!&ndash; Submenu with animation &ndash;&gt;-->
<!--            <div-->
<!--                v-if="item.children && item.children.length > 0"-->
<!--                :class="submenuClasses"-->
<!--            >-->
<!--                <div class="py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700 pl-4">-->
<!--                    <div class="space-y-1">-->
<!--                        <SidebarMenuItem-->
<!--                            v-for="child in item.children"-->
<!--                            :key="child.id"-->
<!--                            :item="child"-->
<!--                            :level="level + 1"-->
<!--                            :is-collapsed="isCollapsed"-->
<!--                            :is-mobile="isMobile"-->
<!--                            @toggle-submenu="$emit('toggle-submenu', $event)"-->
<!--                            @close-sidebar="$emit('close-sidebar')"-->
<!--                        />-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </li>-->
<!--</template>-->

<!--<script setup>-->
<!--import { computed } from 'vue';-->
<!--import { Link } from '@inertiajs/vue3';-->
<!--import { ChevronDown } from 'lucide-vue-next';-->

<!--const props = defineProps({-->
<!--    item: {-->
<!--        type: Object,-->
<!--        required: true-->
<!--    },-->
<!--    level: {-->
<!--        type: Number,-->
<!--        default: 0-->
<!--    },-->
<!--    isCollapsed: {-->
<!--        type: Boolean,-->
<!--        default: false-->
<!--    },-->
<!--    isMobile: {-->
<!--        type: Boolean,-->
<!--        default: false-->
<!--    }-->
<!--});-->

<!--const emit = defineEmits(['toggle-submenu', 'close-sidebar']);-->

<!--const showLabel = computed(() => !props.isCollapsed || props.isMobile);-->

<!--// Helper function to safely get route href-->
<!--const getMenuItemHref = (item) => {-->
<!--    if (!item.exists || !item.route) {-->
<!--        return '#';-->
<!--    }-->

<!--    try {-->
<!--        return route(item.route);-->
<!--    } catch (error) {-->
<!--        console.warn(`Route '${item.route}' not found`);-->
<!--        return '#';-->
<!--    }-->
<!--};-->

<!--const menuItemClasses = computed(() => [-->
<!--    'group relative flex items-center w-full px-4 py-3 text-sm rounded-xl transition-all duration-200 hover:scale-[1.02]',-->
<!--    props.item.active && props.item.exists-->
<!--        ? 'bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 text-emerald-700 dark:text-emerald-300 shadow-md shadow-emerald-500/10 border border-emerald-200 dark:border-emerald-700'-->
<!--        : props.item.exists-->
<!--            ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white'-->
<!--            : 'text-slate-400 dark:text-slate-500 cursor-not-allowed opacity-60',-->
<!--    props.item.disabled ? 'opacity-50 cursor-not-allowed' : '',-->
<!--    props.level > 0 ? 'ml-2' : '',-->
<!--    !showLabel.value ? 'justify-center px-3' : ''-->
<!--]);-->

<!--const iconClasses = computed(() => [-->
<!--    'h-5 w-5 flex-shrink-0 transition-all duration-200',-->
<!--    props.item.active && props.item.exists-->
<!--        ? 'text-emerald-600 dark:text-emerald-400'-->
<!--        : props.item.exists-->
<!--            ? 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-300'-->
<!--            : 'text-slate-300 dark:text-slate-600'-->
<!--]);-->

<!--const badgeClasses = computed(() => [-->
<!--    'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold transition-all duration-200',-->
<!--    props.item.active && props.item.exists-->
<!--        ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'-->
<!--        : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300'-->
<!--]);-->

<!--const chevronClasses = computed(() => [-->
<!--    'h-4 w-4 transition-all duration-300',-->
<!--    props.item.active && props.item.exists-->
<!--        ? 'text-emerald-600 dark:text-emerald-400'-->
<!--        : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300',-->
<!--    props.item.isOpen ? 'rotate-180' : 'rotate-0'-->
<!--]);-->

<!--const submenuClasses = computed(() => [-->
<!--    'overflow-hidden transition-all duration-300 ease-in-out',-->
<!--    props.item.isOpen ? 'max-h-96 opacity-100 mt-2' : 'max-h-0 opacity-0'-->
<!--]);-->

<!--const handleClick = (event) => {-->
<!--    if (props.item.disabled || !props.item.exists) {-->
<!--        event.preventDefault();-->
<!--        return;-->
<!--    }-->

<!--    if (props.isMobile) {-->
<!--        emit('close-sidebar');-->
<!--    }-->
<!--};-->

<!--const toggleSubmenu = () => {-->
<!--    if (props.item.disabled) return;-->

<!--    emit('toggle-submenu', props.item.id);-->
<!--};-->
<!--</script>-->
