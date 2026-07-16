import { ProductCard } from '@/components/product-card';
import type { Category } from '@/types';

export function Menu({ categories }: { categories: Category[] }) {
    return (
        <div className="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6">
            {categories.map((category) => (
                <section key={category.id} id={`category-${category.slug}`} className="scroll-mt-32 pb-12 last:pb-0">
                    <div className="mb-3 flex items-center gap-4">
                        <span className="h-px flex-1 bg-border" />

                        <h2 className="font-display text-xl tracking-tight text-brand-teal uppercase sm:text-2xl dark:text-brand-teal-light">
                            {category.title}
                        </h2>

                        <span className="h-px flex-1 bg-border" />
                    </div>

                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                        {category.products.map((product) => (
                            <ProductCard key={product.id} product={product} />
                        ))}
                    </div>
                </section>
            ))}
        </div>
    );
}
