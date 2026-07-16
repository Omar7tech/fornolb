import { cn } from '@/lib/utils';
import type { Product } from '@/types';

/**
 * The dietary markers for a product: a chilli when it's spicy, a leaf when it's
 * vegetarian. Renders nothing when neither applies.
 */
export function ProductDietIcons({ product, className }: { product: Product; className?: string }) {
    if (!product.is_spicy && !product.is_vegetarian) {
        return null;
    }

    return (
        <span className={cn('flex shrink-0 items-center gap-1', className)}>
            {product.is_spicy && <img src="/icons/chili.png" alt="Spicy" title="Spicy" className="size-4" />}

            {product.is_vegetarian && (
                <img src="/icons/vegetarian.png" alt="Vegetarian" title="Vegetarian" className="size-4" />
            )}
        </span>
    );
}
