import { useCallback, useEffect, useRef, useState } from 'react';

import { CategoryFilterPill } from '@/components/category-filter-pill';
import type { Category } from '@/types';

/**
 * Where the readable part of the page starts: below the sticky header and this
 * bar. Anything above this line is covered, so it doesn't count as being read.
 */
const ACTIVE_OFFSET = 130;

export function CategoryFilter({ categories }: { categories: Category[] }) {
    const [activeSlug, setActiveSlug] = useState<string | null>(null);
    const listRef = useRef<HTMLDivElement>(null);

    /**
     * The category a pill press is scrolling to. While set, it wins over what's
     * on screen, so the pills don't flicker through every category the smooth
     * scroll passes on the way.
     */
    const pendingSlug = useRef<string | null>(null);

    const resolveActive = useCallback((): string | null => {
        // At the very bottom, the last category wins: a short final section can
        // never take up enough of the screen to win on its own.
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) {
            return categories.at(-1)?.slug ?? null;
        }

        // Otherwise it's whichever section fills most of the readable area —
        // which is what you'd point at if asked what you're looking at.
        let bestSlug: string | null = null;
        let bestVisible = 0;

        for (const category of categories) {
            const section = document.getElementById(`category-${category.slug}`);

            if (!section) {
                continue;
            }

            const { top, bottom } = section.getBoundingClientRect();
            const visible = Math.min(bottom, window.innerHeight) - Math.max(top, ACTIVE_OFFSET);

            if (visible > bestVisible) {
                bestVisible = visible;
                bestSlug = category.slug;
            }
        }

        return bestSlug;
    }, [categories]);

    const scrollToCategory = (slug: string) => {
        const section = document.getElementById(`category-${slug}`);

        if (!section) {
            return;
        }

        pendingSlug.current = slug;
        setActiveSlug(slug);

        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    useEffect(() => {
        let frame = 0;

        const update = () => {
            frame = 0;

            const pending = pendingSlug.current;

            if (pending !== null) {
                const section = document.getElementById(`category-${pending}`);
                const arrived = section !== null && Math.abs(section.getBoundingClientRect().top - ACTIVE_OFFSET) < 4;

                // Hold the pressed pill until the smooth scroll lands on it.
                if (!arrived) {
                    return;
                }

                pendingSlug.current = null;
            }

            setActiveSlug(resolveActive());
        };

        const onScroll = () => {
            frame ||= requestAnimationFrame(update);
        };

        // Taking over the scroll by hand abandons the pill press, otherwise an
        // interrupted smooth scroll would leave the wrong pill stuck on.
        const releasePending = () => {
            pendingSlug.current = null;
        };

        update();

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        window.addEventListener('wheel', releasePending, { passive: true });
        window.addEventListener('touchstart', releasePending, { passive: true });
        window.addEventListener('keydown', releasePending);

        return () => {
            window.removeEventListener('scroll', onScroll);
            window.removeEventListener('resize', onScroll);
            window.removeEventListener('wheel', releasePending);
            window.removeEventListener('touchstart', releasePending);
            window.removeEventListener('keydown', releasePending);

            if (frame) {
                cancelAnimationFrame(frame);
            }
        };
    }, [resolveActive]);

    // Keep the active pill within the bar's own horizontal scroll, without
    // touching the page's vertical position.
    useEffect(() => {
        const list = listRef.current;
        const index = categories.findIndex((category) => category.slug === activeSlug);

        if (!list || index === -1) {
            return;
        }

        const pill = list.children[index];

        if (!(pill instanceof HTMLElement)) {
            return;
        }

        list.scrollTo({
            left: pill.offsetLeft - list.clientWidth / 2 + pill.clientWidth / 2,
            behavior: 'smooth',
        });
    }, [activeSlug, categories]);

    return (
        <section className="sticky top-16 z-40 w-full bg-background/80 backdrop-blur-lg supports-[backdrop-filter]:bg-background/60">
            <div className="mx-auto w-full max-w-6xl px-4 py-2.5 sm:px-6">
                <div
                    ref={listRef}
                    className="no-scrollbar scroll-fade-x -mx-4 flex gap-2 overflow-x-auto px-4 sm:-mx-6 sm:px-6"
                >
                    {categories.map((category) => (
                        <CategoryFilterPill
                            key={category.id}
                            label={category.title}
                            isActive={category.slug === activeSlug}
                            onClick={() => scrollToCategory(category.slug)}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
