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
        <div>
            <h4 className="text-sm font-semibold text-foreground">Follow</h4>

            {/* The padding is the tap target, not decoration: it takes the 24px
                icons to 44px without drawing anything. The negative margin keeps
                the first icon optically aligned with the heading above. */}
            <ul className="mt-1 -ml-2.5 flex items-center">
                {socials.map((social) => (
                    <li key={`${social.platform}-${social.url}`}>
                        <a
                            href={social.url}
                            target="_blank"
                            rel="noreferrer"
                            aria-label={social.label}
                            title={social.label}
                            className="block rounded-sm p-2.5 opacity-80 transition-opacity hover:opacity-100 focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                        >
                            {social.icon ? (
                                <img
                                    src={social.icon}
                                    alt=""
                                    className="size-6"
                                />
                            ) : (
                                <Link2 className="size-6 text-muted-foreground" />
                            )}
                        </a>
                    </li>
                ))}
            </ul>
        </div>
    );
}
