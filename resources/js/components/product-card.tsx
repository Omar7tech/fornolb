import type { MenuProduct } from '@/lib/menu-data';

export function ProductCard({ product }: { product: MenuProduct }) {
    return (
        <article className="flex flex-col rounded-lg border border-border bg-background p-4">
            <div className="mb-4 aspect-square w-full rounded-md bg-muted" />

            <h3 className="text-base font-medium text-foreground">{product.name}</h3>
            <p className="mt-1 text-sm text-muted-foreground">{product.description}</p>
            <p className="mt-3 text-sm font-medium text-foreground">{product.price}</p>
        </article>
    );
}
