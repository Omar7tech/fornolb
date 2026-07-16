import { Clock, Star } from 'lucide-react';

import { ProductPrice } from '@/components/product-price';
import { SmartImage } from '@/components/smart-image';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import type { Product } from '@/types';

/**
 * Full product details: image, title, preparation time, description and price.
 */
export function ProductDialog({
    product,
    open,
    onOpenChange,
}: {
    product: Product;
    open: boolean;
    onOpenChange: (open: boolean) => void;
}) {
    const image = product.image ?? product.thumb;

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="gap-0 overflow-hidden p-0">
                {image ? (
                    <SmartImage
                        src={image}
                        alt={product.title}
                        className="aspect-video w-full shrink-0"
                        imgClassName="object-cover"
                        draggable={false}
                    />
                ) : (
                    <div className="aspect-video w-full shrink-0 bg-muted" />
                )}

                <div className="flex min-h-0 flex-1 flex-col gap-4 overflow-y-auto p-5">
                    <DialogHeader>
                        <DialogTitle className="flex items-start gap-2 pr-6 font-heading">
                            <span className="flex-1">{product.title}</span>

                            {product.is_featured && (
                                <Star className="mt-1 size-5 shrink-0 fill-amber-400 text-amber-400" />
                            )}
                        </DialogTitle>

                        {product.description ? (
                            <DialogDescription className="text-left leading-relaxed">
                                {product.description}
                            </DialogDescription>
                        ) : (
                            <DialogDescription className="sr-only">Details for {product.title}</DialogDescription>
                        )}
                    </DialogHeader>

                    {product.preparation_time !== null && product.preparation_time > 0 && (
                        <span className="inline-flex w-fit items-center gap-1.5 rounded-full border border-border px-2.5 py-1 text-xs text-muted-foreground">
                            <Clock className="size-3.5" />
                            Ready in ~{product.preparation_time} min
                        </span>
                    )}
                </div>

                <div className="flex shrink-0 items-center justify-between gap-3 border-t border-border p-5">
                    <ProductPrice basePrice={product.price} discountPrice={product.discount_price} size="lg" />
                </div>
            </DialogContent>
        </Dialog>
    );
}
