/** Mirrors the `pricing` prop shared from `HandleInertiaRequests`. */
export type Pricing = {
    display: 'usd' | 'lbp' | 'both';
    /** LBP per 1 USD, or null when LBP prices are unavailable. */
    lbpRate: number | null;
};

/** Mirrors `App\Http\Resources\ProductResource`. */
export type Product = {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    price: number;
    discount_price: number | null;
    preparation_time: number | null;
    is_featured: boolean;
    is_new: boolean;
    variants: ProductVariant[] | null;
    image: string | null;
    thumb: string | null;
};

export type ProductVariant = {
    name: string;
    price: number;
    discount_price: number | null;
};

/** Mirrors `App\Http\Resources\CategoryResource`. */
export type Category = {
    id: number;
    title: string;
    slug: string;
    products: Product[];
};
