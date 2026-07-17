import { Head, Link } from '@inertiajs/react';

import { SiteFooter } from '@/components/site-footer';
import { SiteHeader } from '@/components/site-header';
import { Button } from '@/components/ui/button';

/**
 * Copy for each status we hand to Inertia. Anything else falls back to the
 * generic entry, so an unexpected code still reads as a sentence rather than a
 * bare number.
 */
const MESSAGES: Record<number, { title: string; body: string }> = {
    403: {
        title: 'Not your table',
        body: "You don't have access to this page.",
    },
    404: {
        title: 'Off the menu',
        body: "This page isn't here. It may have been moved or renamed.",
    },
    419: {
        title: 'That took a while',
        body: 'The page sat idle too long and expired. Load it again to carry on.',
    },
    429: {
        title: 'Slow down a moment',
        body: 'Too many requests came in at once. Try again shortly.',
    },
    500: {
        title: 'Something burned',
        body: "An error on our side stopped this page loading. We're on it.",
    },
    503: {
        title: 'Back shortly',
        body: 'The site is down for maintenance and will return soon.',
    },
};

const FALLBACK = {
    title: 'Something went wrong',
    body: "This page couldn't be loaded.",
};

export default function Error({ status }: { status: number }) {
    const { title, body } = MESSAGES[status] ?? FALLBACK;

    return (
        <>
            <Head title={`${status} — ${title}`} />

            <div className="flex min-h-dvh flex-col">
                <SiteHeader />

                <main className="flex flex-1 items-center justify-center px-6 py-20">
                    <div className="flex w-full max-w-md flex-col items-center text-center">
                        <p className="font-display text-6xl leading-none text-brand-teal sm:text-7xl dark:text-brand-teal-light">
                            {status}
                        </p>

                        <div
                            aria-hidden
                            className="mt-6 h-0.5 w-12 rounded-full bg-border"
                        />

                        <h1 className="mt-6 font-display text-2xl leading-tight tracking-[0.02em] uppercase sm:text-3xl">
                            {title}
                        </h1>

                        <p className="mt-3 text-sm text-muted-foreground">{body}</p>

                        <Button asChild size="lg" className="mt-8">
                            <Link href="/">Back to the menu</Link>
                        </Button>
                    </div>
                </main>

                <SiteFooter />
            </div>
        </>
    );
}
