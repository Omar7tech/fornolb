import { MapPin, Phone } from 'lucide-react';

import { FooterHours } from '@/components/footer-hours';

export function SiteFooter() {
    return (
        <footer className="w-full border-t border-border bg-background">
            <div className="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6">
                <div className="grid gap-8 sm:grid-cols-3">
                    <div>
                        <h3 className="font-heading text-lg font-semibold text-foreground">Forno Flat Bread Co.</h3>
                        <p className="mt-2 text-sm text-muted-foreground">
                            Stone-baked manakish, pies and pizza, made fresh every morning.
                        </p>
                    </div>

                    <FooterHours />

                    <div>
                        <h4 className="font-heading text-sm font-semibold text-foreground">Find us</h4>
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

                        <div className="mt-3 flex gap-4 text-sm">
                            <a href="#" className="text-muted-foreground transition-colors hover:text-foreground">
                                Instagram
                            </a>
                            <a href="#" className="text-muted-foreground transition-colors hover:text-foreground">
                                Facebook
                            </a>
                        </div>
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
