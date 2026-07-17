import { HeroLogo } from '@/components/hero-logo';

export function Hero() {
    return (
        <section className="relative w-full overflow-hidden">
            {/* Tailwind grid pattern with a radial fade mask */}
            <div
                aria-hidden
                className="absolute inset-0 -z-10 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] dark:bg-[linear-gradient(to_right,#ffffff1a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff1a_1px,transparent_1px)]"
            />

            <div className="mx-auto flex min-h-[60vh] w-full max-w-6xl flex-col items-center justify-center gap-8 px-6 pt-12 pb-20 sm:pt-16 sm:pb-24">
                {/* The logo is the headline, so it carries the <h1>. The text is
                    the accessible name for it: without one the page has no
                    heading above the category <h2>s, for readers or crawlers. */}
                <h1 className="contents">
                    <span className="sr-only">Forno Flat Bread — manakish, pizza and wraps in Aley, Lebanon</span>

                    {/* Neon in dark mode: drop-shadow follows the SVG's own alpha,
                        so the glow traces the teal ring like a lit tube instead of
                        haloing a box. Three passes — a tight bright core, a mid
                        bloom, then a wide ambient wash — is what sells it as light
                        rather than a blur. */}
                    <HeroLogo
                        decorative
                        className="w-full max-w-[280px] animate-in fade-in zoom-in-95 duration-1000 ease-out sm:max-w-[340px] dark:[filter:drop-shadow(0_0_2px_rgba(143,215,214,0.22))_drop-shadow(0_0_14px_rgba(143,215,214,0.12))_drop-shadow(0_0_44px_rgba(26,107,107,0.3))]"
                    />
                </h1>
            </div>
        </section>
    );
}
