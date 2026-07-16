import { CodeXml } from 'lucide-react';

import { FooterContact } from '@/components/footer-contact';
import { FooterHours } from '@/components/footer-hours';
import { FooterSocials } from '@/components/footer-socials';
import { buildWhatsAppUrl } from '@/lib/whatsapp';

/** The developer's own WhatsApp, for the credit line — not the shop's number. */
const DEVELOPER_NUMBER = '+961 71 387 946';

const DEVELOPER_MESSAGE =
    "Hi Omar! I saw your work on the Forno Flat Bread site and I'd like to talk about a project.";

export function SiteFooter() {
    return (
        <footer className="relative w-full overflow-hidden border-t border-border bg-background">
            {/* The same grid the hero opens with, masked from the bottom instead of
                the top, so the page closes on the texture it started with. */}
            <div
                aria-hidden
                className="pointer-events-none absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] [mask-image:radial-gradient(ellipse_70%_60%_at_50%_100%,#000_60%,transparent_100%)] bg-[size:14px_24px] dark:bg-[linear-gradient(to_right,#ffffff1a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff1a_1px,transparent_1px)]"
            />

            <div className="relative mx-auto w-full max-w-6xl px-4 py-14 sm:px-6">
                {/* Brand on the left, details on the right. The details wrap rather
                    than sit in fixed columns: hours and contact can each switch off
                    in the settings, and a grid would leave a hole where they were. */}
                <div className="flex flex-col gap-12 md:flex-row md:justify-between md:gap-16">
                    <div className="max-w-xs">
                        <img
                            src="/logos/flatbread.svg"
                            alt="Forno Flat Bread Co."
                            className="h-7 w-auto dark:invert"
                        />

                        <p className="mt-5 font-display text-2xl leading-[1.15] text-brand-teal uppercase sm:text-[1.75rem] dark:text-brand-teal-light">
                            One oven.
                            <br />
                            Two traditions.
                        </p>

                        <p className="mt-3 text-sm text-muted-foreground">
                            Manakish, pizza, wraps and pasta.
                        </p>
                    </div>

                    <div className="flex flex-wrap gap-x-14 gap-y-10">
                        <FooterHours />
                        <FooterContact />
                        <FooterSocials />
                    </div>
                </div>

                <div className="mt-14 flex flex-col gap-2 text-xs text-muted-foreground sm:flex-row sm:items-center sm:justify-between">
                    <p>
                        &copy; {new Date().getFullYear()} Forno Flat Bread Co.
                        All rights reserved.
                    </p>

                    <p className="flex items-center gap-1.5">
                        <CodeXml className="size-3.5 shrink-0 text-brand-teal dark:text-brand-teal-light" />
                        Crafted by{' '}
                        <a
                            href={buildWhatsAppUrl(
                                DEVELOPER_NUMBER,
                                DEVELOPER_MESSAGE,
                            )}
                            target="_blank"
                            rel="noreferrer"
                            className="font-medium text-foreground underline decoration-brand-teal/40 underline-offset-4 transition-colors hover:decoration-brand-teal dark:decoration-brand-teal-light/40 dark:hover:decoration-brand-teal-light"
                        >
                            Omar Abi Farraj
                        </a>
                    </p>
                </div>
            </div>
        </footer>
    );
}
