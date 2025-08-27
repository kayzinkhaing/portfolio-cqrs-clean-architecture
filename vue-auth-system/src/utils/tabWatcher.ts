// src/utils/tabWatcher.ts
export function initTabWatcher() {
  const originalTitle = 'Portfolio | Kay Zin Khaing'
  const originalFavicon = '/profile1.png'
  const hiddenFavicon = '/favhand.png'

  const changeFavicon = (href: string) => {
    let link: HTMLLinkElement | null = document.querySelector("link[rel~='icon']")
    if (!link) {
      link = document.createElement('link')
      link.rel = 'icon'
      document.getElementsByTagName('head')[0].appendChild(link)
    }
    link.href = href
  }

  const handleVisibilityChange = () => {
    if (document.hidden) {
      document.title = 'Come back to my portfolio '
      changeFavicon(hiddenFavicon)
    } else {
      document.title = originalTitle
      changeFavicon(originalFavicon)
    }
  }

  document.addEventListener('visibilitychange', handleVisibilityChange)

  // Optional: return cleanup function
  return () => document.removeEventListener('visibilitychange', handleVisibilityChange)
}
