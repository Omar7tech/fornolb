<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Business identity
    |--------------------------------------------------------------------------
    |
    | The name search engines index. `name` matches the previous site so any
    | existing ranking carries over.
    |
    | The alternates matter more than they look: "Forno Flatbread" is how the
    | Google Business Profile spells it, and listing it here is what tells Google
    | the map pin and this site are the same business.
    |
    */

    'name' => 'Forno Flat Bread',

    'alternate_name' => ['Forno Flatbread', 'Forno Flat Bread Co.'],

    /*
    |--------------------------------------------------------------------------
    | Page copy
    |--------------------------------------------------------------------------
    |
    | Keep `title` under ~60 characters and `description` under ~155, or Google
    | truncates them in the results page.
    |
    */

    'title' => 'Forno Flat Bread — Manakish, Pizza & Wraps in Aley, Lebanon',

    'description' => 'Forno Flat Bread in Aley, Lebanon. Manakish, pizza, wraps, pasta, salads and sweets, baked fresh to order.',

    /*
    |--------------------------------------------------------------------------
    | Sharing preview
    |--------------------------------------------------------------------------
    |
    | Path under `public/`, plus the image's real dimensions. WhatsApp and
    | Facebook need the dimensions to reserve space before the image loads.
    |
    */

    'og_image' => 'og/main.jpg',

    'og_image_width' => 1200,

    'og_image_height' => 630,

    'og_image_alt' => 'Forno Flat Bread — manakish and pizza on a stone slab',

    /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    |
    | The coordinates are the shop's pin on Google Maps, and are what tie this
    | site to that listing for "near me" searches.
    |
    | `display` is the line the footer shows; the rest is the structured address
    | for search engines. Both come from here so they can't drift apart.
    |
    | TODO: `street` is still unset. It's optional — it's left out of the
    | structured data while empty — but it should match the Google Business
    | Profile exactly, character for character, when you add it.
    |
    */

    'address' => [
        'display' => 'Aley, Lebanon',
        'street' => null,
        'locality' => 'Aley',
        'region' => 'Mount Lebanon',
        'country' => 'LB',
    ],

    'geo' => [
        'latitude' => 33.8057643,
        'longitude' => 35.5941857,
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Maps listing
    |--------------------------------------------------------------------------
    |
    | The canonical link to the Google Business Profile, by its permanent CID.
    | Unlike a copied maps.google.com URL it carries no session tracking and
    | won't rot. Used for the footer address link and the structured data's
    | `hasMap`.
    |
    */

    'map_url' => 'https://maps.google.com/?cid=18164454290555967058',

    /*
    |--------------------------------------------------------------------------
    | Restaurant details
    |--------------------------------------------------------------------------
    */

    'cuisines' => ['Lebanese', 'Mediterranean', 'Italian', 'Pizza'],

    'price_range' => '$',

    'currency' => 'USD',

];
