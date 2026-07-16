import { Head } from '@inertiajs/react';
import { useMemo, useState } from 'react';

import { CategoryFilter } from '@/components/category-filter';
import { Hero } from '@/components/hero';
import { Menu } from '@/components/menu';
import { MenuEmpty } from '@/components/menu-empty';
import { MenuSearch } from '@/components/menu-search';
import { SiteFooter } from '@/components/site-footer';
import { SiteHeader } from '@/components/site-header';
import { WhatsAppFab } from '@/components/whatsapp-fab';
import { searchMenu } from '@/lib/menu-search';
import type { Category } from '@/types';

export default function Welcome({ categories }: { categories: Category[] }) {
    const [query, setQuery] = useState('');

    // The whole menu is already on the page, so searching is a filter rather
    // than a request: results land as you type, offline included.
    const results = useMemo(
        () => searchMenu(categories, query),
        [categories, query],
    );

    return (
        <>
            <Head title="Forno Flat Bread Co." />

            <div className="flex min-h-dvh flex-col">
                <SiteHeader />

                <main className="flex flex-1 flex-col">
                    <Hero />

                    {/* No bottom padding: the sticky bar below brings its own
                        pt-2.5, which is the whole gap. */}
                    <div className="mx-auto w-full max-w-6xl px-4 sm:px-6">
                        <MenuSearch value={query} onChange={setQuery} />
                    </div>

                    {results.length > 0 ? (
                        <>
                            {/* The pills get the results, not the whole menu, so one
                                never scrolls to a section a search has filtered out. */}
                            <CategoryFilter categories={results} />
                            <Menu categories={results} />
                        </>
                    ) : (
                        <MenuEmpty query={query} onClear={() => setQuery('')} />
                    )}
                </main>

                <SiteFooter />
            </div>

            <WhatsAppFab />
        </>
    );
}
