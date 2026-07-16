import { Head } from '@inertiajs/react';

import { CategoryFilter } from '@/components/category-filter';
import { Hero } from '@/components/hero';
import { Menu } from '@/components/menu';
import { SiteFooter } from '@/components/site-footer';
import { SiteHeader } from '@/components/site-header';

export default function Welcome() {
    return (
        <>
            <Head title="Forno Flat Bread Co." />

            <div className="flex min-h-dvh flex-col">
                <SiteHeader />

                <main className="flex flex-1 flex-col">
                    <Hero />
                    <CategoryFilter />
                    <Menu />
                </main>

                <SiteFooter />
            </div>
        </>
    );
}
