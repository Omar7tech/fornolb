import { Eye } from 'lucide-react';

import type { MenuProduct } from '@/lib/menu-data';

/**
 * Compact card with the thumbnail on the left and the title, description, price
 * and quick actions on the right.
 */
export function ProductCard({ product }: { product: MenuProduct }) {
    return (
        <div className="group flex h-full min-w-0 flex-col rounded-xl border border-border bg-card p-3 text-card-foreground shadow-sm transition-all hover:border-brand-teal/40 hover:shadow-md">
            <div className="flex gap-4">
                <div className="size-20 shrink-0 overflow-hidden rounded-lg bg-muted md:size-28" />

                <div className="flex min-w-0 flex-1 flex-col">
                    <h3 className="min-w-0 truncate text-sm leading-tight font-semibold">{product.name}</h3>

                    <p className="mt-1 truncate text-xs text-muted-foreground">{product.description}</p>

                    <div className="mt-auto flex items-center justify-between gap-2 pt-2">
                        <span className="text-sm font-semibold text-brand-teal dark:text-brand-teal-light">
                            {product.price}
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
