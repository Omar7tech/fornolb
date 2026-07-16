import { Clock, Star } from 'lucide-react';

import { ProductPrice } from '@/components/product-price';
import { SmartImage } from '@/components/smart-image';
import { VariantSelector } from '@/components/variant-selector';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import type { Product, ProductVariant } from '@/types';

/**
 * Full product details: image, title, preparation time, description, variant
 * picker, and the price in a footer that stays put while the description
 * scrolls.
 */
export function ProductDialog({
    product,
    open,
    onOpenChange,
    variants,
    hasVariants,
    selectedIndex,
    onSelectVariant,
    basePrice,
    discountPrice,
}: {
    product: Product;
    open: boolean;
    onOpenChange: (open: boolean) => void;
    variants: ProductVariant[];
    hasVariants: boolean;
    selectedIndex: number;
    onSelectVariant: (index: number) => void;
    basePrice: number;
    discountPrice: number | null;
}) {
    const image = product.image ?? product.thumb;

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            {/* The panel itself doesn't scroll: the image and footer stay fixed
                and only the description scrolls within its own bounds. That needs
                a bounded flex column — the shadcn default is an unbounded grid. */}
            <DialogContent className="flex max-h-[85vh] flex-col gap-0 overflow-hidden p-0 sm:max-w-lg">
                {image && (
                    // pt-12 keeps the image clear of the overlaid close button.
                    <div className="shrink-0 px-5 pt-12">
                        <SmartImage
                            src={image}
                            alt={product.title}
                            className="aspect-video w-full rounded-xl"
                            imgClassName="object-cover"
                            draggable={false}
                        />
                    </div>
                )}

                <div className="flex min-h-0 flex-1 flex-col gap-4 overflow-y-auto p-5">
                    <DialogHeader className="shrink-0">
                        <DialogTitle className="flex items-start gap-2 pr-6 font-heading">
                            <span className="flex-1">{product.title}</span>

                            {product.is_featured && (
                                <Star className="mt-0.5 size-5 shrink-0 fill-amber-400 text-amber-400" />
                            )}
                        </DialogTitle>

                        {product.preparation_time !== null && product.preparation_time > 0 && (
                            <span className="mt-1 inline-flex w-fit items-center gap-1.5 rounded-full border border-border px-2.5 py-1 text-xs text-muted-foreground">
                                <Clock className="size-3.5" />
                                Ready in ~{product.preparation_time} min
                            </span>
                        )}
                    </DialogHeader>

                    <DialogDescription
                        className={
                            product.description
                                ? 'max-h-[35vh] overflow-y-auto overscroll-contain pr-1 text-left leading-relaxed'
                                : 'sr-only'
                        }
                    >
                        {product.description ?? `Details for ${product.title}`}
                    </DialogDescription>

                    {hasVariants && (
                        <VariantSelector
                            variants={variants}
                            selectedIndex={selectedIndex}
                            onSelect={onSelectVariant}
                        />
                    )}
                </div>

                {/* Fixed footer: the price stays visible no matter how long the
                    description scrolls. */}
                <div className="flex shrink-0 items-center justify-between gap-3 border-t border-border p-5">
                    <ProductPrice basePrice={basePrice} discountPrice={discountPrice} size="lg" />
                </div>
            </DialogContent>
        </Dialog>
    );
}
