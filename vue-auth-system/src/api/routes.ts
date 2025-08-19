// src/services/routes.ts

export const ROUTES = {
  auth: {
    register: '/register',
    login: '/login',
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
  csrf: '/sanctum/csrf-cookie',
}
