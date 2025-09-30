<template>
  <div class="relative profile-dropdown">
    <button
      class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-300"
      @click="$emit('toggle')"
    >
      <!-- Manual local image -->
      <!-- <img
        src="/src/assets/images/profile1.avif"
        alt="User"
        class="w-9 h-9 rounded-full ring-2 ring-blue-500 object-cover"
      /> -->
      <div class="text-left hidden lg:block">
        <div class="text-sm font-semibold text-gray-900 dark:text-white">
          {{ auth.user?.name || 'Guest User' }}
        </div>
        <div class="text-xs text-gray-600 dark:text-slate-400">
          {{ auth.user?.role || 'Admin' }}
        </div>
      </div>
      <ChevronDownIcon class="w-4 h-4 text-gray-400" />
    </button>

    <!-- Dropdown Menu -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95 translate-y-1"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 scale-100 translate-y-0"
      leave-to-class="opacity-0 scale-95 translate-y-1"
    >
      <div
        v-if="show"
        class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden z-30"
      >
        <!-- User Info -->
        <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-slate-700 dark:to-slate-800 border-b border-gray-200 dark:border-slate-600">
          <div class="flex items-center gap-3">
            <img
              src="/src/assets/images/profile1.avif"
              alt="User"
              class="w-12 h-12 rounded-full ring-2 ring-blue-500 object-cover"
            />
            <div>
              <div class="font-semibold text-gray-900 dark:text-white">
                {{ auth.user?.name || 'Guest User' }}
              </div>
              <div class="text-xs text-gray-600 dark:text-slate-400">
                {{ auth.user?.email || 'No email' }}
              </div>
            </div>
          </div>
        </div>

        <!-- Menu Links -->
        <div class="p-2">
          <RouterLink
            to="/dashboard/settings/profile"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200"
            @click="$emit('toggle')"
          >
            <UserIcon class="w-5 h-5" />
            Profile Settings
          </RouterLink>

          <RouterLink
            to="/dashboard/settings"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200"
            @click="$emit('toggle')"
          >
            <Cog6ToothIcon class="w-5 h-5" />
            Settings
          </RouterLink>

          <button
            class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200"
            @click="handleLogout"
          >
            <ArrowRightOnRectangleIcon class="w-5 h-5" />
            Sign Out
          </button>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup lang="ts">
import { ChevronDownIcon, UserIcon, Cog6ToothIcon, ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline'
import { useAuthStore } from '../../stores/auth'

interface Props { show: boolean }
defineProps<Props>()

const emit = defineEmits<{ toggle: []; logout: [] }>()
const auth = useAuthStore()

const handleLogout = () => {
  emit('toggle')
  emit('logout')
}
</script>
