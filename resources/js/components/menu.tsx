import { ProductCard } from '@/components/product-card';
import type { Category } from '@/types';

export function Menu({ categories }: { categories: Category[] }) {
    return (
        <div className="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6">
            {categories.map((category) => (
                <section
                    key={category.id}
                    id={`category-${category.slug}`}
                    className="scroll-mt-32 pb-12 last:pb-0"
                >
                    {/* Anchored left so the heading lines up with the cards below,
                        and in the same teal as the active filter pill you arrive
                        from. The rule fades out rather than ruling off: it carries
                        the eye into the section instead of fencing it. */}
                    <div className="mb-5 flex items-center gap-4">
                        <h2 className="font-display text-2xl leading-none tracking-[0.02em] text-brand-teal uppercase sm:text-3xl dark:text-brand-teal-light">
                            {category.title}
                        </h2>

                        <span
                            aria-hidden
                            className="h-0.5 flex-1 rounded-full bg-gradient-to-r from-brand-teal/35 to-transparent dark:from-brand-teal-light/25"
                        />
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
