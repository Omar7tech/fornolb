import { Link } from '@inertiajs/react';

import { AppLogo } from '@/components/app-logo';
import { ThemeSwitcher } from '@/components/theme-switcher';

export function SiteHeader() {
    return (
        <header className="sticky top-0 z-50 w-full border-b border-border bg-background">
            <div className="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-6">
                <Link href="/" aria-label="Forno Flat Bread Co. home" className="shrink-0">
                    <AppLogo />
                </Link>

                <ThemeSwitcher />
            </div>
        </header>
    );
}
