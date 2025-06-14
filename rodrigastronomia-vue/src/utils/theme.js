// Dark Mode
export function toggleDarkMode() {
  const isDark = document.body.classList.toggle('dark-mode')
  localStorage.setItem('dark-mode', isDark ? 'on' : 'off')
}

export function applyInitialTheme() {
  const stored = localStorage.getItem('dark-mode')
  if (stored === 'on') {
    document.body.classList.add('dark-mode')
  }
}
