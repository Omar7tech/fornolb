import { Head } from '@inertiajs/react';

import { CategoryFilter } from '@/components/category-filter';
import { Hero } from '@/components/hero';
import { Menu } from '@/components/menu';
import { SiteFooter } from '@/components/site-footer';
import { SiteHeader } from '@/components/site-header';
import { WhatsAppFab } from '@/components/whatsapp-fab';
import type { Category } from '@/types';

export default function Welcome({ categories }: { categories: Category[] }) {
    return (
        <>
            <Head title="Forno Flat Bread Co." />

            <div className="flex min-h-dvh flex-col">
                <SiteHeader />

                <main className="flex flex-1 flex-col">
                    <Hero />
                    <CategoryFilter categories={categories} />
                    <Menu categories={categories} />
                </main>

                <SiteFooter />
            </div>

            <WhatsAppFab />
        </>
    );
}
