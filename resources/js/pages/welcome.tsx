import { Head } from '@inertiajs/react';

import { Hero } from '@/components/hero';
import { SiteHeader } from '@/components/site-header';

export default function Welcome() {
    return (
        <>
            <Head title="Forno Flat Bread Co." />

            <div className="flex min-h-dvh flex-col">
                <SiteHeader />

                <main className="flex flex-1 flex-col">
                    <Hero />
                </main>
            </div>
        </>
    );
}
