import { ProductCard } from '@/components/product-card';
import { menuCategories } from '@/lib/menu-data';

export function Menu() {
    return (
        <div className="mx-auto w-full max-w-6xl px-6 py-12">
            {menuCategories.map((category) => (
                <section
                    key={category.id}
                    id={`category-${category.id}`}
                    className="scroll-mt-30 pb-12 last:pb-0"
                >
                    <h2 className="mb-6 text-2xl font-semibold text-foreground">{category.label}</h2>

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
