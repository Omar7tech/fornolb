import { Clock } from 'lucide-react';

import { formatTime, isShopOpen, useShop, weeklyHours } from '@/lib/shop';
import { cn } from '@/lib/utils';

/**
 * Weekly opening-hours list for the footer, shown only when the shop runs on the
 * automatic schedule. Consecutive days with the same hours are merged into ranges,
 * today's row is highlighted, and a live "Open / Closed" badge sits on top.
 */
export function FooterHours() {
    const shop = useShop();

    if (shop.statusMode !== 'automatic') {
        return null;
    }

    const rows = weeklyHours(shop);
    const open = isShopOpen(shop);

    return (
        <div>
            <h4 className="flex items-baseline gap-2 font-heading text-sm font-semibold text-foreground">
                Opening hours
                <span
                    className={cn(
                        'text-xs font-medium',
                        open ? 'text-brand-teal dark:text-brand-teal-light' : 'text-muted-foreground',
                    )}
                >
                    {open ? 'Open now' : 'Closed'}
                </span>
            </h4>

            <ul className="mt-2 space-y-1 text-sm text-muted-foreground">
                {rows.map((row) => (
                    <li
                        key={row.label}
                        className={cn('flex items-center justify-between gap-4', row.isToday && 'text-foreground')}
                    >
                        <span className="flex items-center gap-1.5">
                            {row.isToday && <Clock className="size-3.5 shrink-0" />}
                            {row.label}
                        </span>

                        {row.isClosed ? <span>Closed</span> : (
                            <span className="tabular-nums">
                                {formatTime(row.opensAt)} – {formatTime(row.closesAt)}
                            </span>
                        )}
                    </li>
                ))}
            </ul>
        </div>
    );
}
