import { CodeXml } from 'lucide-react';

import { FooterContact } from '@/components/footer-contact';
import { FooterHours } from '@/components/footer-hours';
import { FooterSocials } from '@/components/footer-socials';
import { buildWhatsAppUrl } from '@/lib/whatsapp';

/** The developer's own WhatsApp, for the credit line — not the shop's number. */
const DEVELOPER_NUMBER = '+961 71 387 946';

const DEVELOPER_MESSAGE = "Hi Omar! I saw your work on the Forno Flat Bread site and I'd like to talk about a project.";

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

                <div className="mt-10 flex flex-col gap-2 border-t border-border pt-6 text-xs text-muted-foreground sm:flex-row sm:items-center sm:justify-between">
                    <p>&copy; {new Date().getFullYear()} Forno Flat Bread Co. All rights reserved.</p>

                    <p className="flex items-center gap-1.5">
                        <CodeXml className="size-3.5 shrink-0 text-brand-teal dark:text-brand-teal-light" />
                        Crafted by{' '}
                        <a
                            href={buildWhatsAppUrl(DEVELOPER_NUMBER, DEVELOPER_MESSAGE)}
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
