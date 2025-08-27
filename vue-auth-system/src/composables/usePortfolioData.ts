import { ref, computed } from 'vue'

// Types
interface Project {
  id: number
  title: string
  subtitle: string
  description: string
  image: string
  technologies: string[]
  features: string[]
  type: 'Full-Stack' | 'Backend' | 'Frontend'
  githubUrl?: string
  liveUrl?: string
  status: 'Completed' | 'In Progress'
}

interface Skill {
  name: string
  level: number
  category: 'frontend' | 'backend' | 'tools' | 'database'
  color: string
}

interface Experience {
  id: number
  title: string
  company: string
  location: string
  startDate: string
  endDate: string | null
  description: string
  responsibilities: string[]
  technologies: string[]
  projects: string[]
}

export const usePortfolioData = () => {
  // Personal Information
  const personalInfo = ref({
    name: 'Kay Zin Khaing',
    title: 'Full-Stack Web Developer',
    location: 'Yangon, Myanmar',
    email: 'kayzinkhaing1331@gmail.com',
    phone: '+959 762 194 708',
    github: 'https://github.com/kayzinkhaing',
    linkedin: 'https://www.linkedin.com/in/kay-zin-khaing-679109315/',
    portfolio: 'https://kayzinkhaing.github.io/my-portfolio/',
    motivation: 'Code with clarity, Deliver with speed, Aim for excellence',
    dateOfBirth: 'March 13, 2001',
    nationality: 'Myanmar',
    languages: ['Burmese (Native)', 'English (Conversational)']
  })

  // Skills Data
  const skills = ref<Skill[]>([
    // Frontend
    { name: 'HTML5', level: 95, category: 'frontend', color: 'orange' },
    { name: 'CSS3', level: 90, category: 'frontend', color: 'blue' },
    { name: 'JavaScript', level: 85, category: 'frontend', color: 'yellow' },
    { name: 'Vue.js', level: 90, category: 'frontend', color: 'green' },
    { name: 'jQuery', level: 80, category: 'frontend', color: 'blue' },
    { name: 'Bootstrap', level: 85, category: 'frontend', color: 'purple' },
    { name: 'TailwindCSS', level: 90, category: 'frontend', color: 'cyan' },
    { name: 'Blade', level: 85, category: 'frontend', color: 'red' },
    
    // Backend
    { name: 'PHP', level: 90, category: 'backend', color: 'indigo' },
    { name: 'Laravel', level: 95, category: 'backend', color: 'red' },
    { name: 'Livewire', level: 80, category: 'backend', color: 'pink' },
    { name: 'OOP', level: 90, category: 'backend', color: 'blue' },
    { name: 'SOLID Principles', level: 85, category: 'backend', color: 'purple' },
    { name: 'RESTful APIs', level: 90, category: 'backend', color: 'green' },
    
    // Database
    { name: 'MySQL', level: 85, category: 'database', color: 'orange' },
    { name: 'Firebase', level: 75, category: 'database', color: 'yellow' },
    
    // Tools
    { name: 'Git', level: 90, category: 'tools', color: 'orange' },
    { name: 'GitHub', level: 85, category: 'tools', color: 'gray' },
    { name: 'Docker', level: 75, category: 'tools', color: 'blue' },
    { name: 'CI/CD', level: 80, category: 'tools', color: 'green' },
    { name: 'Postman', level: 85, category: 'tools', color: 'orange' },
    { name: 'VS Code', level: 95, category: 'tools', color: 'blue' },
    { name: 'Figma', level: 70, category: 'tools', color: 'purple' },
    { name: 'DigitalOcean', level: 75, category: 'tools', color: 'blue' }
  ])

  // Projects Data
  const projects = ref<Project[]>([
    {
      id: 1,
      title: 'GiveMM',
      subtitle: 'Charity Crowdfunding Platform',
      description: 'A full-stack Laravel-based web platform that allows users to launch and manage fundraising campaigns, donate securely, and monitor campaign progress. Built with clean architecture, performance optimization, and scalability in mind.',
      image: '/project-givemm.jpg',
      technologies: ['Laravel', 'MySQL', 'Docker', 'Redis', 'GitHub Actions', 'DigitalOcean'],
      features: [
        'Campaign Management',
        'Secure Payment Integration',
        'Real-time Progress Tracking',
        'Role-based Access Control',
        'Docker Containerization',
        'CI/CD with GitHub Actions'
      ],
      type: 'Full-Stack',
      githubUrl: 'https://github.com/ITVHBaseCode/Givemm',
      status: 'Completed'
    },
    {
      id: 2,
      title: 'Daily Fair Deal',
      subtitle: 'Multi-Service Marketplace',
      description: 'A comprehensive multi-service marketplace integrating food delivery, e-commerce, and ride-hailing services. Built RESTful APIs serving users, restaurants, shops, and drivers with real-time features.',
      image: '/project-dailyfairdeal.jpg',
      technologies: ['Laravel', 'PHP 8', 'MySQL', 'Laravel Sanctum', 'Stripe', 'PayPal'],
      features: [
        'User Authentication (OTP)',
        'Restaurant Management',
        'Order Processing System',
        'Taxi Booking Service',
        'Real-time Tracking',
        'Payment Integration'
      ],
      type: 'Backend',
      status: 'Completed'
    },
    {
      id: 3,
      title: 'Real Estate System',
      subtitle: 'Property Management Platform',
      description: 'A comprehensive real estate backend system enabling users to register, manage properties, book viewings, and leave reviews. Features secure authentication with social login integration.',
      image: '/project-realestate.jpg',
      technologies: ['Laravel 11', 'Laravel Passport', 'Laravel Socialite', 'MySQL', 'RESTful API'],
      features: [
        'Property Listings',
        'Social Authentication',
        'Booking Management',
        'Review System',
        'Token-based Auth',
        'Location Services'
      ],
      type: 'Backend',
      status: 'Completed'
    },
    {
      id: 4,
      title: 'Yummy Restaurant',
      subtitle: 'Restaurant Management Platform',
      description: 'A scalable restaurant management platform designed to streamline online ordering for customers and simplify menu/order management for administrators.',
      image: '/project-yummy.jpg',
      technologies: ['PHP', 'JavaScript', 'Ajax', 'Bootstrap', 'MySQL', 'MVC Pattern'],
      features: [
        'Menu Browsing',
        'Category Filtering',
        'Shopping Cart',
        'Order Management',
        'Admin Dashboard',
        'User Management'
      ],
      type: 'Full-Stack',
      status: 'Completed'
    }
  ])

  // Experience Data
  const experience = ref<Experience[]>([
    {
      id: 1,
      title: 'Web Developer',
      company: 'ITVisionHub Co., Ltd',
      location: 'Yangon, Myanmar',
      startDate: 'April 2023',
      endDate: null,
      description: 'Working as a full-stack developer on multiple web applications including charity platforms, marketplaces, and management systems. Responsible for both frontend and backend development, with focus on clean architecture and scalable solutions.',
      responsibilities: [
        'Backend development with Laravel and PHP',
        'RESTful API design and implementation',
        'Frontend collaboration and integration',
        'Database design and optimization',
        'Project architecture planning',
        'Technical documentation writing',
        'Code review and quality assurance',
        'Deployment and DevOps practices'
      ],
      technologies: ['Laravel', 'PHP', 'MySQL', 'Vue.js', 'JavaScript', 'Docker', 'Redis', 'GitHub Actions'],
      projects: ['GiveMM Platform', 'Daily Fair Deal', 'Real Estate System', 'Yummy Restaurant']
    }
  ])

  // Education Data
  const education = ref([
    {
      id: 1,
      degree: 'Bachelor of Computer Science',
      institution: 'University of Computer Studies, Meiktila',
      location: 'Myanmar',
      startYear: '2017',
      endYear: '2024',
      description: 'Completed comprehensive 7-year program in Computer Science, building strong foundations in programming, software engineering, and system design.',
      subjects: [
        'Data Structures & Algorithms',
        'Database Management',
        'Software Engineering',
        'Web Technologies',
        'Object-Oriented Programming',
        'System Analysis & Design'
      ]
    },
    {
      id: 2,
      degree: 'IT Camp Volunteer',
      institution: 'Meiktila IT-Camp',
      location: 'Myanmar',
      startYear: '2018',
      endYear: '2018',
      description: 'Volunteered as mentor and instructor, helping students learn basic programming concepts and web development fundamentals.'
    }
  ])

  // Computed Properties
  const skillsByCategory = computed(() => {
    return skills.value.reduce((acc, skill) => {
      if (!acc[skill.category]) {
        acc[skill.category] = []
      }
      acc[skill.category].push(skill)
      return acc
    }, {} as Record<string, Skill[]>)
  })

  const featuredProjects = computed(() => {
    return projects.value.filter(project => project.status === 'Completed').slice(0, 4)
  })

  const currentExperience = computed(() => {
    return experience.value.find(exp => exp.endDate === null)
  })

  const yearsOfExperience = computed(() => {
    const startDate = new Date('2023-04-01')
    const currentDate = new Date()
    const diffTime = Math.abs(currentDate.getTime() - startDate.getTime())
    const diffYears = diffTime / (1000 * 60 * 60 * 24 * 365)
    return Math.floor(diffYears * 10) / 10 // Round to 1 decimal place
  })

  // Methods
  const getSkillsByCategory = (category: string) => {
    return skills.value.filter(skill => skill.category === category)
  }

  const getProjectById = (id: number) => {
    return projects.value.find(project => project.id === id)
  }

  return {
    // Data
    personalInfo,
    skills,
    projects,
    experience,
    education,
    
    // Computed
    skillsByCategory,
    featuredProjects,
    currentExperience,
    yearsOfExperience,
    
    // Methods
    getSkillsByCategory,
    getProjectById
  }
}