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
                <HeroLogo className="w-full max-w-[280px] sm:max-w-[340px] animate-in fade-in zoom-in-95 duration-1000 ease-out" />
            </div>
        </section>
    );
}
