import { usePage } from '@inertiajs/react';
import { Link2 } from 'lucide-react';

/**
 * The social media links from the settings, as a row of brand icons. Platforms
 * without a brand mark (i.e. "Other") fall back to a generic link icon.
 */
export function FooterSocials() {
    const socials = usePage().props.socials;

    if (socials.length === 0) {
        return null;
    }

    return (
        <ul className="mt-4 flex items-center gap-3">
            {socials.map((social) => (
                <li key={`${social.platform}-${social.url}`}>
                    <a
                        href={social.url}
                        target="_blank"
                        rel="noreferrer"
                        aria-label={social.label}
                        title={social.label}
                        className="flex size-9 items-center justify-center rounded-full border border-border transition-colors hover:border-brand-teal/40 hover:bg-muted focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                    >
                        {social.icon ? (
                            <img src={social.icon} alt="" className="size-4.5" />
                        ) : (
                            <Link2 className="size-4.5 text-muted-foreground" />
                        )}
                    </a>
                </li>
            ))}
        </ul>
    );
}
