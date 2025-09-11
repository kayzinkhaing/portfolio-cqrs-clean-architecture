// src/services/routes.ts

export const ROUTES = {
  auth: {
    register: '/register',
    login: '/login',
    refresh:'refresh-token',
    logout: '/logout',
    profile: '/profile',
    updateProfile: '/update-profile',
    forgotPassword: '/forgot-password',   
    resetPassword: '/reset-password',  
    enable2FA: '/2fa/enable', 
    disable2FA: '/2fa/disable', 
    verify2FA: '/2fa/verify',    
  },
  blogs: {
    list: '/blogs',
    item: (id: number | string) => `/blogs/${id}`,
    user: (userId: number | string) => `/users/${userId}/blogs`,
  },
  location: {
    townships: '/townships',
    wards: '/wards',
  },
    statuses: {
    list: '/statuses',
    item: (id: number | string) => `/statuses/${id}`,
  },
    technologies: {
    list: '/technologies',
    item: (id: number | string) => `/technologies/${id}`,
  },
  projects: {
    list: '/projects',
    item: (id: number | string) => `/projects/${id}`,
  },
  educations: {
    list: '/educations',
    item: (id: number | string) => `/educations/${id}`,
  },
  experiences: {
    list: '/experiences',
    item: (id: number | string) => `/experiences/${id}`,
  },
  contactMessages: {
    list: '/contact-messages',
    item: (id: number | string) => `/contact-messages/${id}`,
  },
  notiMessage:{
    unread: '/notifications/unread',
  },

  csrf: '/sanctum/csrf-cookie',
}
