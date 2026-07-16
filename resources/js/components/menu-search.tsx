import { Search, X } from 'lucide-react';

export function MenuSearch({
    value,
    onChange,
}: {
    value: string;
    onChange: (value: string) => void;
}) {
    return (
        <div className="relative">
            <Search
                aria-hidden
                className="pointer-events-none absolute top-1/2 left-3.5 size-4 -translate-y-1/2 text-muted-foreground"
            />

            <input
                type="text"
                inputMode="search"
                value={value}
                onChange={(event) => onChange(event.target.value)}
                placeholder="Search the menu…"
                aria-label="Search the menu"
                autoComplete="off"
                // text-base on mobile: anything smaller and iOS zooms the page in
                // when the field takes focus.
                className="h-11 w-full rounded-full border border-border bg-background/60 pr-11 pl-10 text-base transition-colors placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:outline-none sm:text-sm"
            />

            {value !== '' && (
                <button
                    type="button"
                    onClick={() => onChange('')}
                    aria-label="Clear search"
                    className="absolute top-1/2 right-1 flex size-9 -translate-y-1/2 items-center justify-center rounded-full text-muted-foreground transition-colors hover:text-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none"
                >
                    <X className="size-4" />
                </button>
            )}
        </div>
    );
}
