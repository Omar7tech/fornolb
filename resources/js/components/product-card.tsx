import { useState } from 'react';

import { ProductDialog } from '@/components/product-dialog';
import { ProductPrice } from '@/components/product-price';
import { SmartImage } from '@/components/smart-image';
import { cn } from '@/lib/utils';
import type { Product } from '@/types';

/**
 * Compact card with the thumbnail on the left and the title, description and
 * price on the right. The whole card opens the details dialog.
 */
export function ProductCard({ product }: { product: Product }) {
    const [open, setOpen] = useState(false);
    const image = product.thumb ?? product.image;

    return (
        <>
            <button
                type="button"
                onClick={() => setOpen(true)}
                className={cn(
                    'group flex h-full w-full min-w-0 cursor-pointer flex-col rounded-xl border bg-card p-3 text-left text-card-foreground shadow-sm transition-all hover:shadow-md focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none',
                    product.is_featured ? 'border-amber-400' : 'border-border hover:border-brand-teal/40',
                )}
            >
                <div className="flex w-full gap-4">
                    {image ? (
                        <SmartImage
                            src={image}
                            alt={product.title}
                            className="size-20 shrink-0 rounded-lg md:size-28"
                            imgClassName="object-cover transition-transform duration-300 group-hover:scale-105"
                            draggable={false}
                        />
                    ) : (
                        <div className="size-20 shrink-0 overflow-hidden rounded-lg bg-muted md:size-28" />
                    )}

                    <div className="flex min-w-0 flex-1 flex-col">
                        <div className="flex items-center gap-2">
                            <h3 className="min-w-0 flex-1 truncate text-sm leading-tight font-semibold">
                                {product.title}
                            </h3>

                            {product.is_new && (
                                <span className="shrink-0 rounded-full bg-brand-teal px-2 py-0.5 text-[10px] font-bold tracking-wide text-white uppercase">
                                    New
                                </span>
                            )}
                        </div>

                        {product.description && (
                            <p className="mt-1 truncate text-xs text-muted-foreground">{product.description}</p>
                        )}

                        <div className="mt-auto flex items-center pt-2">
                            <ProductPrice basePrice={product.price} discountPrice={product.discount_price} />
                        </div>
                    </div>
                </div>
            </button>

            <ProductDialog product={product} open={open} onOpenChange={setOpen} />
        </>
    );
}
