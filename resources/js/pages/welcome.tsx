import { Head } from '@inertiajs/react';

import { SiteHeader } from '@/components/site-header';

export default function Welcome() {
    return (
        <>
            <Head title="Forno Flat Bread Co." />

            <div className="flex min-h-dvh flex-col">
                <SiteHeader />

                <div className="flex flex-1 flex-col items-center justify-center gap-8 px-6 py-16">
                    <img
                        src="/logos/main-logo.png"
                        alt="Forno Flat Bread Co."
                        className="w-full max-w-[220px]"
                    />

                    <p className="text-center text-sm font-medium tracking-wide text-brand-ink/70 uppercase dark:text-white/70">
                        Online ordering is coming soon
                    </p>
                </div>
            </div>
        </>
    );
}
