import { usePage } from '@inertiajs/react';
import { MapPin, Phone } from 'lucide-react';

/**
 * Where to find the shop. The location is fixed; the phone number comes from the
 * settings and drops out when it's switched off.
 */
export function FooterContact() {
    const { address, mapUrl, phone } = usePage().props.contact;

    return (
        <div>
            <h4 className="text-sm font-semibold text-foreground">Find us</h4>

            <ul className="mt-2 space-y-2 text-sm text-muted-foreground">
                <li>
                    <a
                        href={mapUrl}
                        target="_blank"
                        rel="noreferrer"
                        className="flex items-center gap-2 transition-colors hover:text-foreground"
                    >
                        <MapPin className="size-4 shrink-0" />
                        {address}
                    </a>
                </li>

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
