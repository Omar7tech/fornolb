import { useCallback, useEffect, useState } from 'react';

export type Appearance = 'light' | 'dark' | 'system';

const prefersDark = () => window.matchMedia('(prefers-color-scheme: dark)').matches;

const setCookie = (name: string, value: string, days = 365) => {
    if (typeof document === 'undefined') {
        return;
    }

    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};

const applyTheme = (appearance: Appearance) => {
    const isDark = appearance === 'dark' || (appearance === 'system' && prefersDark());
    const root = document.documentElement;

    if (root.classList.contains('dark') === isDark) {
        return;
    }

    root.classList.add('theme-switching');
    root.classList.toggle('dark', isDark);

    // Flush the new colours while transitions are still suppressed; removing the
    // class in the same frame would otherwise let them animate after all.
    void root.offsetWidth;

    root.classList.remove('theme-switching');
};

const mediaQuery = () => {
    if (typeof window === 'undefined') {
        return null;
    }

    return window.matchMedia('(prefers-color-scheme: dark)');
};

const handleSystemThemeChange = () => {
    const currentAppearance = localStorage.getItem('theme') as Appearance | null;

    applyTheme(currentAppearance || 'system');
};

export function initializeTheme() {
    const savedAppearance = (localStorage.getItem('theme') as Appearance | null) || 'system';

    applyTheme(savedAppearance);

    mediaQuery()?.addEventListener('change', handleSystemThemeChange);
}

const savedAppearance = (): Appearance => {
    if (typeof localStorage === 'undefined') {
        return 'system';
    }

    return (localStorage.getItem('theme') as Appearance | null) || 'system';
};

export function useAppearance() {
    const [appearance, setAppearance] = useState<Appearance>(savedAppearance);

    const updateAppearance = useCallback((mode: Appearance) => {
        setAppearance(mode);

        localStorage.setItem('theme', mode);
        setCookie('theme', mode);

        applyTheme(mode);
    }, []);

    useEffect(() => {
        // Mirror the stored preference into the cookie so SSR renders the same
        // theme the client already applied in initializeTheme().
        setCookie('theme', appearance);
        applyTheme(appearance);

        return () => mediaQuery()?.removeEventListener('change', handleSystemThemeChange);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    return { appearance, updateAppearance } as const;
}
