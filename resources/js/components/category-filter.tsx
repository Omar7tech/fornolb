import { CategoryFilterPill } from '@/components/category-filter-pill';
import type { Category } from '@/types';

export function CategoryFilter({ categories }: { categories: Category[] }) {
    const scrollToCategory = (slug: string) => {
        document.getElementById(`category-${slug}`)?.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        });
    };

    return (
        <section className="sticky top-0 z-40 w-full border-b border-border bg-background">
            <div className="mx-auto w-full max-w-6xl px-4 py-2.5 sm:px-6">
                <div className="no-scrollbar scroll-fade-x -mx-4 flex gap-2 overflow-x-auto px-4 sm:-mx-6 sm:px-6">
                    {categories.map((category) => (
                        <CategoryFilterPill
                            key={category.id}
                            label={category.title}
                            onClick={() => scrollToCategory(category.slug)}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
