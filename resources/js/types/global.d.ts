import type { Auth } from '@/types/auth';
import type { Pricing } from '@/types/menu';
import type { Shop, Social, WhatsAppBadge } from '@/types/shop';

declare module 'react' {
    // eslint-disable-next-line @typescript-eslint/no-unused-vars
    interface InputHTMLAttributes<T> {
        passwordrules?: string;
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            pricing: Pricing;
            shop: Shop;
            socials: Social[];
            whatsappBadge: WhatsAppBadge;
            sidebarOpen: boolean;
            [key: string]: unknown;
        };
    }
}
