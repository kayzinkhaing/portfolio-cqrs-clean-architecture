<template>
  <div class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <!-- Section Header -->
      <SectionTitle 
        title="About Me" 
        subtitle="Get to know the person behind the code"
        class="mb-16"
      />
      
      <!-- Main Content Grid -->
      <div class="grid lg:grid-cols-2 gap-12 items-start">
        <!-- Personal Story -->
        <div class="space-y-8">
          <div class="glass-card p-8">
            <h3 class="text-2xl font-bold text-white mb-6">My Journey</h3>
            <div class="space-y-4 text-white leading-relaxed">
              <p>
                Born in Myanmar on March 13, 2001, I discovered my passion for technology 
                during my Computer Science studies at the University of Computer Studies, Meiktila.
              </p>
              <p>
                Since April 2023, I've been working as a Full-Stack Web Developer at ITVisionHub, 
                where I've contributed to multiple live projects including charity platforms, 
                marketplaces, and restaurant management systems.
              </p>
              <p>
                My motivation: <em class="text-indigo-400">"Code with clarity, Deliver with speed, Aim for excellence"</em>
              </p>
            </div>
          </div>
          
          <!-- Personal Details -->
          <div class="glass-card p-8">
            <h3 class="text-2xl font-bold text-white mb-6">Personal Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="space-y-3">
                <div class="flex items-center">
                  <span class="text-indigo-400 font-medium w-20">Location:</span>
                  <span class="text-white">Yangon, Myanmar</span>
                </div>
                <div class="flex items-center">
                  <span class="text-indigo-400 font-medium w-20">Languages:</span>
                  <span class="text-white">Burmese (Native), English</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Stats and Achievements -->
        <div class="space-y-8">
          <!-- Stats Cards -->
          <div class="grid grid-cols-2 gap-4">
            <div class="glass-card p-6 text-center">
              <div class="text-3xl font-bold text-indigo-400 mb-2">2+</div>
              <div class="text-white">Years Experience</div>
            </div>
            <div class="glass-card p-6 text-center">
              <div class="text-3xl font-bold text-purple-400 mb-2">5+</div>
              <div class="text-white">Projects Completed</div>
            </div>
            <div class="glass-card p-6 text-center">
              <div class="text-3xl font-bold text-pink-400 mb-2">15+</div>
              <div class="text-white">Technologies</div>
            </div>
            <div class="glass-card p-6 text-center">
              <div class="text-3xl font-bold text-white text-amber-400 mb-2">100%</div>
              <div class="text-white">Satisfaction Rate</div>
            </div>
          </div>
          
          <!-- Achievements -->
          <div class="glass-card p-8">
            <h3 class="text-2xl font-bold text-white mb-6">Key Achievements</h3>
            <ul class="space-y-3">
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                <span class="text-white">Graduated with B.C.Sc in Computer Sciences (2017-2024)</span>
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                <span class="text-white">Volunteer at Meiktila IT-Camp (2018)</span>
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                <span class="text-white">Led multiple full-stack development projects</span>
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                <span class="text-white">Expert in Laravel, Vue.js, and modern web technologies</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>