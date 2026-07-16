import { usePage } from '@inertiajs/react';
import { MapPin, Phone } from 'lucide-react';

/**
 * The shop's address and phone number from the settings. Each line is dropped
 * when it's switched off, and the whole block disappears when both are.
 */
export function FooterContact() {
    const { address, mapUrl, phone } = usePage().props.contact;

    if (!address && !phone) {
        return null;
    }

    return (
        <div>
            <h4 className="text-sm font-semibold text-foreground">Find us</h4>

            <ul className="mt-2 space-y-2 text-sm text-muted-foreground">
                {address && (
                    <li>
                        {mapUrl ? (
                            <a
                                href={mapUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="flex items-center gap-2 transition-colors hover:text-foreground"
                            >
                                <MapPin className="size-4 shrink-0" />
                                {address}
                            </a>
                        ) : (
                            <span className="flex items-center gap-2">
                                <MapPin className="size-4 shrink-0" />
                                {address}
                            </span>
                        )}
                    </li>
                )}

                {phone && (
                    <li>
                        <a
                            href={`tel:${phone.replace(/[^\d+]/g, '')}`}
                            className="flex items-center gap-2 transition-colors hover:text-foreground"
                        >
                            <Phone className="size-4 shrink-0" />
                            {phone}
                        </a>
                    </li>
                )}
            </ul>
        </div>
    );
}
