/** How the shop's open/closed state is decided. Mirrors PHP `ShopStatusMode`. */
export type ShopStatusMode = 'manual' | 'automatic';

/** A single weekday's opening hours. `day` is JS-style (0 = Sunday). */
export type OpeningHours = {
    day: number;
    isClosed: boolean;
    opensAt: string;
    closesAt: string;
};

export type Shop = {
    /** Authoritative open/closed snapshot from the server for the initial render. */
    isOpen: boolean;
    /** Whether the state is driven manually or by the weekly schedule. */
    statusMode: ShopStatusMode;
    /** The manual switch value; only authoritative in `manual` mode. */
    isManuallyOpen: boolean;
    /** The weekly schedule; only authoritative in `automatic` mode. */
    openingHours: OpeningHours[];
};

/** The floating WhatsApp chat badge config. */
export type WhatsAppBadge = {
    /** Whether the badge is switched on *and* has a number to send to. */
    show: boolean;
    number: string | null;
};

/** A social media link from the settings, ready to render in the footer. */
export type Social = {
    platform: string;
    /** The brand name, or the custom name when the platform is `other`. */
    label: string;
    url: string;
    /** Path to the brand icon, or null when the platform has no brand mark. */
    icon: string | null;
};
