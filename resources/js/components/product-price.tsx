import { usePricing } from '@/hooks/use-pricing';
import { cn } from '@/lib/utils';

/**
 * Renders a product price for the active display mode (USD, LBP, or both).
 * In "both" mode the currencies stack, with the pre-discount price struck
 * through on the USD row only.
 */
export function ProductPrice({
    basePrice,
    discountPrice,
    size = 'sm',
    className,
}: {
    basePrice: number;
    discountPrice: number | null;
    /** Larger type for the detail dialog. */
    size?: 'sm' | 'lg';
    className?: string;
}) {
    const pricing = usePricing();
    const hasDiscount = discountPrice !== null;
    const effectivePrice = hasDiscount ? discountPrice : basePrice;
    const showBoth = pricing.showUsd && pricing.showLbp;

    if (showBoth) {
        return (
            <span className={cn('inline-flex min-w-0 flex-col items-start gap-0.5 leading-none', className)}>
                <span className="flex items-baseline gap-1.5">
                    <span
                        className={cn(
                            'font-semibold text-brand-teal dark:text-brand-teal-light',
                            size === 'lg' ? 'text-lg' : 'text-sm',
                        )}
                    >
                        {pricing.usd(effectivePrice)}
                    </span>
                    {hasDiscount && (
                        <span className="text-xs text-muted-foreground line-through">{pricing.usd(basePrice)}</span>
                    )}
                </span>

                <span className={cn('text-muted-foreground', size === 'lg' ? 'text-xs' : 'text-[11px]')}>
                    {pricing.lbp(effectivePrice)}
                </span>
            </span>
        );
    }

    const format = pricing.showUsd ? pricing.usd : pricing.lbp;

    return (
        <span className={cn('inline-flex min-w-0 flex-wrap items-baseline gap-x-1.5 gap-y-1', className)}>
            {hasDiscount && (
                <span className={cn('text-muted-foreground line-through', size === 'lg' ? 'text-base' : 'text-xs')}>
                    {format(basePrice)}
                </span>
            )}

            <span
                className={cn(
                    'font-semibold text-brand-teal dark:text-brand-teal-light',
                    size === 'lg' ? 'text-lg' : 'text-sm',
                )}
            >
                {format(effectivePrice)}
            </span>
        </span>
    );
}
