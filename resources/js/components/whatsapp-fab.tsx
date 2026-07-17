import { usePage } from '@inertiajs/react';

import { buildWhatsAppUrl } from '@/lib/whatsapp';

/** The message the badge opens WhatsApp with, ready for the customer to send. */
const ORDER_MESSAGE = "Hi Forno Flat Bread! I'd like to place an order.";

/**
 * Floating WhatsApp button pinned to the bottom-right corner. Opens WhatsApp
 * with an order message already written, so the customer only has to hit send.
 * Controlled by the WhatsApp badge settings.
 */
export function WhatsAppFab() {
    const { whatsappBadge } = usePage().props;

    if (!whatsappBadge.show || !whatsappBadge.number) {
        return null;
    }

    return (
        <a
            href={buildWhatsAppUrl(whatsappBadge.number, ORDER_MESSAGE)}
            target="_blank"
            rel="noreferrer"
            aria-label="Order on WhatsApp"
            title="Order on WhatsApp"
            className="fixed right-4 bottom-[calc(1rem+env(safe-area-inset-bottom))] z-40 flex size-14 items-center justify-center rounded-full bg-brand-teal-bright shadow-lg transition-transform hover:scale-105 focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none active:scale-95 md:right-6 md:bottom-[calc(1.5rem+env(safe-area-inset-bottom))]"
        >
            {/* The brand glyph is green on transparent; flatten it to white to
                sit on the teal button. */}
            <img src="/social-icons/whatsapp.svg" alt="" className="size-7 brightness-0 invert" />
        </a>
    );
}
