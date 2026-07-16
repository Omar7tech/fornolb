import type { Category, Product } from '@/types';

/**
 * Arabizi digits — the numerals people type for Arabic sounds Latin letters
 * don't have. The menu is full of them ("ma3 Jebne", "Areshy w 3asal"), and
 * someone searching "asal" or "maa" should still find them.
 */
const ARABIZI: Record<string, string> = {
    '2': 'a', // hamza
    '3': 'a', // ayn
    '5': 'kh', // kha
    '7': 'h', // ha
    '8': 'gh', // ghayn
    '9': 's', // sad
};

/**
 * Reduce a string to something two spellings of the same word can agree on:
 * lowercase, accent-free, punctuation-free, with Arabizi digits spelled out.
 *
 * Digits are only translated when they sit against a letter, so "3asal" becomes
 * "aasal" while the "5" in "5 pieces" is left alone.
 */
function normalize(value: string): string {
    return value
        .toLowerCase()
        .normalize('NFD')
        .replace(/[̀-ͯ]/g, '')
        .replace(
            /(?<=[a-z])[235789]|[235789](?=[a-z])/g,
            (digit) => ARABIZI[digit] ?? digit,
        )
        .replace(/[^a-z0-9]+/g, ' ')
        .trim();
}

/** Everything about a product worth matching against, as one normalized string. */
function haystack(product: Product, categoryTitle: string): string {
    return normalize(
        [
            product.title,
            product.description ?? '',
            categoryTitle,
            ...(product.variants ?? []).map((variant) => variant.name),
            product.is_vegetarian ? 'vegetarian veggie' : '',
            product.is_spicy ? 'spicy hot' : '',
        ].join(' '),
    );
}

/**
 * The menu narrowed to what matches `query`, keeping the original order. Every
 * word typed has to appear somewhere in a product, so terms narrow the results
 * rather than widening them ("spicy chicken" means both, not either).
 *
 * An empty query returns the menu untouched.
 */
export function searchMenu(categories: Category[], query: string): Category[] {
    const terms = normalize(query).split(' ').filter(Boolean);

    if (terms.length === 0) {
        return categories;
    }

    return categories
        .map((category) => ({
            ...category,
            products: category.products.filter((product) => {
                const text = haystack(product, category.title);

                return terms.every((term) => text.includes(term));
            }),
        }))
        .filter((category) => category.products.length > 0);
}
