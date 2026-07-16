import type { ClassValue } from 'clsx';
import { clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

const usdFormatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

export function formatPrice(amount: number): string {
    return usdFormatter.format(amount);
}

/**
 * The scroll behaviour to use for programmatic scrolling. An explicit
 * `behavior: 'smooth'` overrides the CSS `scroll-behavior` the reduced-motion
 * media query sets, so scripted scrolls have to check the preference directly.
 */
export function scrollBehavior(): ScrollBehavior {
    if (typeof window === 'undefined') {
        return 'auto';
    }

    return window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
}
