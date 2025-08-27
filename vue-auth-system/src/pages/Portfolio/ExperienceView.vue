<template>
  <div class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <SectionTitle 
        title="Professional Experience" 
        subtitle="My journey in web development and software engineering"
        class="mb-16"
      />
      
      <!-- Experience Timeline -->
      <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 hidden md:block"></div>
        
        <div class="space-y-12">
          <!-- Current Role -->
          <div class="relative">
            <!-- Timeline Dot -->
            <div class="absolute left-6 w-4 h-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full border-4 border-gray-900 hidden md:block"></div>
            
            <!-- Experience Card -->
            <div class="md:ml-20">
              <div class="glass-card p-8">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
                  <div>
                    <h3 class="text-2xl font-bold text-white mb-2">Web Developer</h3>
                    <h4 class="text-xl text-indigo-400 mb-2">ITVisionHub Co., Ltd</h4>
                    <p class="text-white">Yangon, Myanmar</p>
                  </div>
                  <div class="mt-4 lg:mt-0 text-right">
                    <span class="inline-block px-4 py-2 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">
                      Current Position
                    </span>
                    <p class="text-white mt-2">April 2023 - Present</p>
                    <p class="text-white text-sm">2+ Years</p>
                  </div>
                </div>
                
                <!-- Role Description -->
                <p class="text-white mb-6 leading-relaxed">
                  Working as a full-stack developer on multiple web applications including charity platforms, 
                  marketplaces, and management systems. Responsible for both frontend and backend development, 
                  with a focus on clean architecture, performance optimization, and scalable solutions.
                </p>
                
                <!-- Key Responsibilities -->
                <div class="mb-6">
                  <h5 class="text-lg font-semibold text-white mb-4">Key Responsibilities</h5>
                  <div class="grid md:grid-cols-2 gap-4">
                    <ul class="space-y-2">
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Backend development with Laravel and PHP
                      </li>
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        RESTful API design and implementation
                      </li>
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Frontend collaboration and integration
                      </li>
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Database design and optimization
                      </li>
                    </ul>
                    <ul class="space-y-2">
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Project architecture planning
                      </li>
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Technical documentation writing
                      </li>
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Code review and quality assurance
                      </li>
                      <li class="flex items-start text-gray-300">
                        <span class="text-indigo-400 mr-3 mt-1">▸</span>
                        Deployment and DevOps practices
                      </li>
                    </ul>
                  </div>
                </div>
                
                <!-- Major Projects -->
                <div class="mb-6">
                  <h5 class="text-lg font-semibold text-white mb-4">Major Projects Contributed</h5>
                  <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-800/50 rounded-lg p-4">
                      <h6 class="font-semibold text-indigo-400 mb-2">GiveMM Platform</h6>
                      <p class="text-sm text-gray-300">Full-stack charity crowdfunding platform with payment integration</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                      <h6 class="font-semibold text-purple-400 mb-2">Daily Fair Deal</h6>
                      <p class="text-sm text-gray-300">Multi-service marketplace backend with real-time features</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                      <h6 class="font-semibold text-green-400 mb-2">Real Estate System</h6>
                      <p class="text-sm text-gray-300">Property management backend with social authentication</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                      <h6 class="font-semibold text-green-400 mb-2">Yummy Restaurant</h6>
                      <p class="text-sm text-gray-300">Restaurant management platform with order processing</p>
                    </div>
                  </div>
                </div>
                
                <!-- Technologies Used -->
                <div>
                  <h5 class="text-lg font-semibold text-white mb-4">Technologies & Tools</h5>
                  <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm">Laravel</span>
                    <span class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-full text-sm">PHP</span>
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-sm">MySQL</span>
                    <span class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-sm">Vue.js</span>
                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-sm">JavaScript</span>
                    <span class="px-3 py-1 bg-red-500/20 text-red-300 rounded-full text-sm">Docker</span>
                    <span class="px-3 py-1 bg-pink-500/20 text-pink-300 rounded-full text-sm">Redis</span>
                    <span class="px-3 py-1 bg-green-500/20 text-green-300 rounded-full text-sm">GitHub Actions</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Skills Development Section -->
      <div class="mt-20">
        <h3 class="text-3xl font-bold text-white text-center mb-12">Professional Growth</h3>
        <div class="grid md:grid-cols-3 gap-8">
          <!-- Technical Skills -->
          <div class="glass-card p-8 text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl">💻</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-4">Technical Expertise</h4>
            <p class="text-gray-300 mb-6">
              Mastered full-stack development with Laravel, Vue.js, and modern web technologies through hands-on project experience.
            </p>
            <ul class="text-left space-y-2">
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Laravel Framework Mastery
              </li>
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                API Development & Integration
              </li>
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Database Design & Optimization
              </li>
            </ul>
          </div>
          
          <!-- Project Management -->
          <div class="glass-card p-8 text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl">📋</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-4">Project Leadership</h4>
            <p class="text-gray-300 mb-6">
              Led development initiatives, collaborated with cross-functional teams, and delivered projects on time with high quality standards.
            </p>
            <ul class="text-left space-y-2">
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Agile Development Practices
              </li>
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Code Review & Mentoring
              </li>
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Documentation & Testing
              </li>
            </ul>
          </div>
          
          <!-- Problem Solving -->
          <div class="glass-card p-8 text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-2xl">🎯</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-4">Problem Solving</h4>
            <p class="text-gray-300 mb-6">
              Developed analytical thinking and creative problem-solving skills through complex real-world challenges and client requirements.
            </p>
            <ul class="text-left space-y-2">
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Performance Optimization
              </li>
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Architecture Design
              </li>
              <li class="flex items-center text-sm text-gray-300">
                <span class="text-green-400 mr-2">✓</span>
                Scalability Solutions
              </li>
            </ul>
          </div>
        </div>
      </div>
      
      <!-- Reference Section -->
      <div class="mt-20">
        <h3 class="text-3xl font-bold text-white text-center mb-12">Professional Reference</h3>
        <div class="max-w-2xl mx-auto">
          <div class="glass-card p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
              <span class="text-3xl">👨‍💼</span>
            </div>
            <h4 class="text-2xl font-bold text-white mb-2">Mr. Yan Aung</h4>
            <p class="text-lg text-indigo-400 mb-4">Founder of ITVisionHub Co., Ltd</p>
            <div class="space-y-2 text-gray-300">
              <p class="flex items-center justify-center">
                <span class="mr-2">📞</span>
                +959 406 880 124
              </p>
              <p class="flex items-center justify-center">
                <span class="mr-2">✉️</span>
                yanaung85@gmail.com
              </p>
            </div>
            <div class="mt-6 p-4 bg-gray-800/50 rounded-lg">
              <p class="text-gray-300 italic">
                "Available for professional reference and recommendations regarding Kay Zin Khaing's 
                work performance, technical skills, and professional conduct."
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>