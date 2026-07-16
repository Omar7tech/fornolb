export type MenuProduct = {
    id: string;
    name: string;
    description: string;
    price: string;
};

export type MenuCategory = {
    id: string;
    label: string;
    products: MenuProduct[];
};

/** Static placeholder menu until this comes from the backend. */
export const menuCategories: MenuCategory[] = [
    {
        id: 'manakish',
        label: 'Manakish',
        products: [
            { id: 'zaatar', name: 'Zaatar', description: 'Thyme, sumac, sesame, olive oil', price: '$4.00' },
            { id: 'cheese', name: 'Cheese', description: 'Akkawi and mozzarella blend', price: '$5.50' },
            { id: 'zaatar-cheese', name: 'Zaatar & Cheese', description: 'Half and half, folded', price: '$6.00' },
            { id: 'kishk', name: 'Kishk', description: 'Fermented wheat and yogurt, walnuts', price: '$5.75' },
        ],
    },
    {
        id: 'pizza',
        label: 'Pizza',
        products: [
            { id: 'margherita', name: 'Margherita', description: 'Tomato, mozzarella, basil', price: '$9.00' },
            { id: 'sujuk', name: 'Sujuk', description: 'Spiced beef sausage, peppers', price: '$11.00' },
            { id: 'veggie', name: 'Veggie', description: 'Olives, onion, mushroom, corn', price: '$10.00' },
        ],
    },
    {
        id: 'pies',
        label: 'Pies',
        products: [
            { id: 'spinach', name: 'Spinach Fatayer', description: 'Lemon, onion, sumac', price: '$3.50' },
            { id: 'meat', name: 'Lahm Bi Ajeen', description: 'Minced beef, tomato, pine nuts', price: '$4.50' },
            { id: 'labneh', name: 'Labneh Pie', description: 'Strained yogurt, mint, cucumber', price: '$4.00' },
        ],
    },
    {
        id: 'sandwiches',
        label: 'Sandwiches',
        products: [
            { id: 'halloumi', name: 'Halloumi Wrap', description: 'Grilled halloumi, tomato, mint', price: '$7.50' },
            { id: 'chicken', name: 'Chicken Taouk', description: 'Garlic sauce, pickles, fries', price: '$8.50' },
            { id: 'falafel', name: 'Falafel', description: 'Tarator, parsley, tomato', price: '$6.50' },
        ],
    },
    {
        id: 'sweets',
        label: 'Sweets',
        products: [
            { id: 'knafeh', name: 'Knafeh', description: 'Semolina, ashta, orange blossom', price: '$6.00' },
            { id: 'chocolate', name: 'Chocolate Manoushe', description: 'Warm spread, banana', price: '$5.50' },
        ],
    },
    {
        id: 'drinks',
        label: 'Drinks',
        products: [
            { id: 'ayran', name: 'Ayran', description: 'Salted yogurt drink', price: '$2.50' },
            { id: 'jallab', name: 'Jallab', description: 'Date molasses, rose water, pine nuts', price: '$3.50' },
            { id: 'tea', name: 'Mint Tea', description: 'Fresh mint, pot for two', price: '$3.00' },
        ],
    },
];
