import { Eye } from 'lucide-react';

import { SmartImage } from '@/components/smart-image';
import { cn, formatPrice } from '@/lib/utils';
import type { Product } from '@/types';

/**
 * Compact card with the thumbnail on the left and the title, description, price
 * and quick actions on the right.
 */
export function ProductCard({ product }: { product: Product }) {
    const image = product.thumb ?? product.image;
    const hasDiscount = product.discount_price !== null;

    return (
        <div
            className={cn(
                'group flex h-full min-w-0 flex-col rounded-xl border bg-card p-3 text-card-foreground shadow-sm transition-all hover:shadow-md',
                product.is_featured ? 'border-amber-400' : 'border-border hover:border-brand-teal/40',
            )}
        >
            <div className="flex gap-4">
                {image ? (
                    <SmartImage
                        src={image}
                        alt={product.title}
                        className="size-20 shrink-0 rounded-lg md:size-28"
                        imgClassName="object-cover"
                    />
                ) : (
                    <div className="size-20 shrink-0 overflow-hidden rounded-lg bg-muted md:size-28" />
                )}

                <div className="flex min-w-0 flex-1 flex-col">
                    <div className="flex items-center gap-2">
                        <h3 className="min-w-0 flex-1 truncate text-sm leading-tight font-semibold">{product.title}</h3>

                        {product.is_new && (
                            <span className="shrink-0 rounded-full bg-brand-teal px-2 py-0.5 text-[10px] font-bold tracking-wide text-white uppercase">
                                New
                            </span>
                        )}
                    </div>

                    {product.description && (
                        <p className="mt-1 truncate text-xs text-muted-foreground">{product.description}</p>
                    )}

                    <div className="mt-auto flex items-center justify-between gap-2 pt-2">
                        <span className="flex min-w-0 items-baseline gap-1.5">
                            {hasDiscount && (
                                <span className="truncate text-xs text-muted-foreground line-through">
                                    {formatPrice(product.price)}
                                </span>
                            )}
                            <span className="truncate text-sm font-semibold text-brand-teal dark:text-brand-teal-light">
                                {formatPrice(product.discount_price ?? product.price)}
                            </span>
                        </span>

                        <button
                            type="button"
                            aria-label="View details"
                            className="inline-flex size-8 shrink-0 items-center justify-center rounded-full text-muted-foreground transition-colors hover:bg-muted hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                        >
                            <Eye className="size-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
