// src/services/routes.ts

export const ROUTES = {
  auth: {
    register: '/register',
    login: '/login',
    logout: '/logout',
    profile: '/profile',
    updateProfile: '/update-profile',
  },
  blogs: {
    list: '/blogs',
    item: (id: number | string) => `/blogs/${id}`,
  },
  location: {
    townships: '/townships',
    wards: '/wards',
  },
  csrf: '/sanctum/csrf-cookie',
}
