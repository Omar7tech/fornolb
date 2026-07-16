import { MapPin, Phone } from 'lucide-react';

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

                    <div>
                        <h4 className="text-sm font-semibold text-foreground">Find us</h4>
                        <ul className="mt-2 space-y-2 text-sm text-muted-foreground">
                            <li className="flex items-center gap-2">
                                <MapPin className="size-4 shrink-0" />
                                Main Street, Beirut
                            </li>
                            <li className="flex items-center gap-2">
                                <Phone className="size-4 shrink-0" />
                                +961 1 234 567
                            </li>
                        </ul>
                    </div>
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
