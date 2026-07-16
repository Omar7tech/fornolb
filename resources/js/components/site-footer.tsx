import { FooterContact } from '@/components/footer-contact';
import { FooterHours } from '@/components/footer-hours';
import { FooterSocials } from '@/components/footer-socials';

export function SiteFooter() {
    return (
        <footer className="w-full border-t border-border bg-background">
            <div className="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6">
                <div className="grid gap-8 sm:grid-cols-3">
                    <div>
                        <img
                            src="/logos/flatbread.svg"
                            alt="Forno Flat Bread Co."
                            className="h-8 w-auto dark:invert"
                        />

                        <p className="mt-3 text-sm text-muted-foreground">
                            Stone-baked manakish, pies and pizza, made fresh every morning.
                        </p>

                        <FooterSocials />
                    </div>

                    <FooterHours />

                    <FooterContact />
                </div>

                <div className="mt-10 border-t border-border pt-6">
                    <p className="text-xs text-muted-foreground">
                        &copy; {new Date().getFullYear()} Forno Flat Bread Co. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    );
}
