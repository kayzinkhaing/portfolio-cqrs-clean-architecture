<template>
  <div class="p-4 border-t border-slate-700/50">
    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-700/50 hover:bg-slate-700 transition-all duration-300">
      <div class="relative">
        <img
          src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face&auto=format"
          alt="Developer"
          class="w-10 h-10 rounded-full ring-2 ring-blue-500/50 object-cover"
        />
        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-slate-800"></div>
      </div>
      <div class="flex-1 min-w-0">
        <div class="text-sm font-semibold text-white">K Developer</div>
        <div class="text-xs text-slate-400">Senior Developer</div>
      </div>
    </div>
  </div>
</template>