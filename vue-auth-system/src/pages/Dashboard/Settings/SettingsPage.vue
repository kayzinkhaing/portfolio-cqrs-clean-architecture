<template>
  <div>
    <!-- Settings nav bar -->
    <nav class="flex border-b mb-6">
      <RouterLink
        v-for="tab in tabs"
        :key="tab.key"
        :to="{ name: 'DashboardSettings', params: { tab: tab.key } }"
        class="px-4 py-2 font-medium"
        :class="{ 'border-b-2 border-indigo-600 text-indigo-600': currentTab === tab.key }"
      >
        {{ tab.label }}
      </RouterLink>
    </nav>

    <!-- Settings content -->
    <component :is="currentComponent" />
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

// Import child components
import InfoView from './InformationView.vue'
import ProfileEdit from './ProfileEdit.vue'
import TwoFactor from './TwoFactor.vue'
import BlogsView from './Blogs.vue'

const route = useRoute()

const tabs = [
  { key: 'info', label: 'Account Info', component: InfoView },
  { key: 'profile', label: 'Profile Edit', component: ProfileEdit },
  { key: '2fa', label: 'Security & 2FA', component: TwoFactor },
  { key: 'blogs', label: 'Blogs', component: BlogsView },
]

const currentTab = computed(() => route.params.tab || 'info')

const currentComponent = computed(() => {
  const tab = tabs.find(t => t.key === currentTab.value)
  return tab ? tab.component : InfoView
})
</script>
