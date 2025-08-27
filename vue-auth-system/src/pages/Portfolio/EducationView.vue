<template>
  <div class="py-20 px-6">
    <div class="max-w-4xl mx-auto">
      <SectionTitle 
        title="Education & Learning" 
        subtitle="My academic journey and continuous learning path"
        class="mb-16"
      />
      
      <!-- Education Timeline -->
      <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute  top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500"></div>
        
        <div class="space-y-12">
          <!-- University Education -->
          <TimelineItem
            year="2017 - 2024"
            title="Bachelor of Computer Science"
            subtitle="University of Computer Studies, Meiktila, Myanmar"
            :highlight="true"
          >
            <div class="space-y-4">
              <p class="text-white">
                Completed a comprehensive 5-year program in Computer Science, building strong foundations 
                in programming, software engineering, and system design.
              </p>
              
              <div class="bg-slate-800/50 rounded-lg p-4">
                <h4 class="text-lg font-semibold text-white mb-3">Key Subjects</h4>
                <div class="grid grid-cols-2 gap-2">
                  <span class="text-indigo-400">• Data Structures & Algorithms</span>
                  <span class="text-indigo-400">• Database Management</span>
                  <span class="text-indigo-400">• Software Engineering</span>
                  <span class="text-indigo-400">• Web Technologies</span>
                  <span class="text-indigo-400">• Object-Oriented Programming</span>
                  <span class="text-indigo-400">• System Analysis & Design</span>
                </div>
              </div>
            </div>
          </TimelineItem>
          
          <!-- IT Camp Volunteer -->
          <TimelineItem
            year="2018"
            title="IT Camp Volunteer"
            subtitle="Meiktila IT-Camp"
          >
            <p class="text-white">
              Volunteered as a mentor and instructor at IT-Camp, helping students learn basic 
              programming concepts and web development fundamentals. This experience enhanced 
              my leadership and communication skills.
            </p>
          </TimelineItem>
        </div>
      </div>
      
      <!-- Continuous Learning Section -->
      <div class="mt-20">
        <h3 class="text-3xl font-bold text-white text-center mb-12">Continuous Learning</h3>
        <div class="grid md:grid-cols-2 gap-8">
          <!-- Online Learning -->
          <div class="glass-card p-8">
            <h4 class="text-xl font-bold text-white mb-6 flex items-center">
              <span class="w-6 h-6 bg-gradient-to-r from-blue-500 to-cyan-500 rounded mr-3"></span>
              Self-Directed Learning
            </h4>
            <ul class="space-y-3 text-white">
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Modern JavaScript frameworks and libraries
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Cloud platforms and deployment strategies
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                DevOps practices and CI/CD pipelines
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Advanced Laravel features and patterns
              </li>
            </ul>
          </div>
          
          <!-- Technical Skills Development -->
          <div class="glass-card p-8">
            <h4 class="text-xl font-bold text-white mb-6 flex items-center">
              <span class="w-6 h-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded mr-3"></span>
              Practical Application
            </h4>
            <ul class="space-y-3 text-white">
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Real-world project development at ITVisionHub
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Open-source contributions and personal projects
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Team collaboration and code review practices
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span>
                Client requirement analysis and solution design
              </li>
            </ul>
          </div>
        </div>
      </div>
      
      <!-- Learning Philosophy -->
      <div class="mt-16 text-center">
        <div class="glass-card p-8 max-w-3xl mx-auto">
          <h4 class="text-2xl font-bold text-white mb-4">Learning Philosophy</h4>
          <p class="text-lg text-white italic">
            "I believe in continuous learning and staying updated with the latest technologies. 
            My analytical thinking and eagerness to learn new technologies help me solve 
            real-world problems effectively."
          </p>
        </div>
      </div>
    </div>
  </div>
</template>