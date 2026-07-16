import { Moon, Sun } from 'lucide-react';

import { Button } from '@/components/ui/button';
import { useAppearance } from '@/hooks/use-appearance';

export function ThemeSwitcher() {
    const { appearance, updateAppearance } = useAppearance();

    const isDark =
        appearance === 'dark' ||
        (appearance === 'system' && typeof window !== 'undefined' && window.matchMedia('(prefers-color-scheme: dark)').matches);

    return (
        <Button
            variant="ghost"
            size="icon"
            // The size-8 default is a 32px target; the header has room for 44.
            className="size-11"
            aria-label={isDark ? 'Switch to light mode' : 'Switch to dark mode'}
            onClick={() => updateAppearance(isDark ? 'light' : 'dark')}
        >
            <Sun className="hidden dark:block" />
            <Moon className="block dark:hidden" />
        </Button>
    );
}
