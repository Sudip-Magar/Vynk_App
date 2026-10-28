// Dark mode. The saved choice is applied before first paint by the inline
// script in layouts/app.blade.php; these helpers handle the toggle button.
const applyTheme = (theme) => {
    document.documentElement.dataset.theme = theme
    document.documentElement.classList.toggle('dark', theme === 'dark')
}

const savedTheme = () => {
    try {
        return localStorage.getItem('theme')
    } catch {
        return null
    }
}

window.toggleTheme = () => {
    const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark'

    applyTheme(next)

    try {
        localStorage.setItem('theme', next)
    } catch {
        // storage blocked (private window): the choice just lasts for this page
    }

    window.dispatchEvent(new CustomEvent('theme-changed', { detail: next }))

    return next
}

// wire:navigate swaps the page without a reload; make sure the theme sticks
document.addEventListener('livewire:navigated', () => {
    const saved = savedTheme()

    if (saved === 'dark' || saved === 'light') {
        applyTheme(saved)
    }
})
