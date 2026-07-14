import { HeroLogo } from '@/components/hero-logo';

export function Hero() {
    return (
        <section className="relative w-full overflow-hidden">
            {/* Tailwind grid pattern with a radial fade mask */}
            <div
                aria-hidden
                className="absolute inset-0 -z-10 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] dark:bg-[linear-gradient(to_right,#ffffff1a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff1a_1px,transparent_1px)]"
            />

            <div className="mx-auto flex min-h-[60vh] w-full max-w-6xl flex-col items-center justify-center gap-8 px-6 py-24">
                <HeroLogo className="w-full max-w-[280px] animate-in fade-in zoom-in-95 drop-shadow-[0_10px_30px_rgba(26,107,107,0.15)] duration-1000 ease-out" />

                <p className="animate-in fade-in text-center text-sm font-medium tracking-wide text-foreground/70 uppercase delay-500 duration-1000">
                    Online ordering is coming soon
                </p>
            </div>
        </section>
    );
}
