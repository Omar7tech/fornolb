import { Star } from 'lucide-react';
import { useState } from 'react';

import { HeroLogo } from '@/components/hero-logo';
import { ProductDialog } from '@/components/product-dialog';
import { ProductPrice } from '@/components/product-price';
import { SmartImage } from '@/components/smart-image';
import { VariantSelector } from '@/components/variant-selector';
import { cn } from '@/lib/utils';
import type { Product } from '@/types';

/**
 * Compact card with the thumbnail on the left and the title, description and
 * price on the right, plus a variant picker underneath when the product has
 * options. Pressing the card opens the details dialog.
 */
export function ProductCard({ product }: { product: Product }) {
    const variants = product.variants ?? [];
    const hasVariants = variants.length > 0;

    // Default to the last variant when variants exist.
    const [selectedIndex, setSelectedIndex] = useState(hasVariants ? variants.length - 1 : 0);
    const [open, setOpen] = useState(false);

    const selectedVariant = hasVariants ? variants[selectedIndex] : null;
    const basePrice = selectedVariant ? selectedVariant.price : product.price;
    const discountPrice = selectedVariant ? selectedVariant.discount_price : product.discount_price;

    const image = product.thumb ?? product.image;

    return (
        <>
            <div
                className={cn(
                    'group flex h-full min-w-0 flex-col rounded-xl border bg-card p-3 text-card-foreground shadow-sm transition-all hover:shadow-md',
                    product.is_featured ? 'border-brand-teal dark:border-brand-teal-light' : 'border-border hover:border-brand-teal/40',
                )}
            >
                {/* The variant picker below has its own buttons, so only this
                    region opens the dialog rather than the whole card. */}
                <button
                    type="button"
                    onClick={() => setOpen(true)}
                    className="flex w-full cursor-pointer gap-3 rounded-lg text-left focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                >
                    {image ? (
                        <SmartImage
                            src={image}
                            alt={product.title}
                            className="size-20 shrink-0 rounded-md md:size-28"
                            imgClassName="object-cover transition-transform duration-300 group-hover:scale-105"
                            draggable={false}
                        />
                    ) : (
                        <HeroLogo className="size-20 shrink-0 md:size-28" />
                    )}

                    <div className="flex min-w-0 flex-1 flex-col">
                        <div className="flex items-center gap-1.5">
                            <h3 className="min-w-0 flex-1 truncate text-lg leading-tight font-semibold">
                                {product.title}
                            </h3>

                            {product.is_new && (
                                <span className="shrink-0 rounded-full bg-brand-teal px-2 py-0.5 text-[10px] font-bold tracking-wide text-white uppercase">
                                    New
                                </span>
                            )}

                            {product.is_featured && (
                                <Star className="size-3.5 shrink-0 fill-amber-400 text-amber-400" />
                            )}
                        </div>

                        {product.description && (
                            <p className="line-clamp-3 text-xs text-muted-foreground">{product.description}</p>
                        )}

                        <div className="mt-auto flex items-center justify-between gap-2 pt-1.5">
                            <ProductPrice basePrice={basePrice} discountPrice={discountPrice} size="lg" />
                        </div>
                    </div>
                </button>

                {hasVariants && (
                    <div className="mt-3 border-t border-dashed border-border pt-3">
                        <VariantSelector
                            variants={variants}
                            selectedIndex={selectedIndex}
                            onSelect={setSelectedIndex}
                        />
                    </div>
                )}
            </div>

            <ProductDialog
                product={product}
                open={open}
                onOpenChange={setOpen}
                variants={variants}
                hasVariants={hasVariants}
                selectedIndex={selectedIndex}
                onSelectVariant={setSelectedIndex}
                basePrice={basePrice}
                discountPrice={discountPrice}
            />
        </>
    );
}
