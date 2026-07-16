import { SearchX } from 'lucide-react';

import { Button } from '@/components/ui/button';

/** Shown when a search matches nothing, in place of the menu. */
export function MenuEmpty({
    query,
    onClear,
}: {
    query: string;
    onClear: () => void;
}) {
    return (
        <div className="mx-auto flex w-full max-w-6xl flex-col items-center gap-3 px-4 py-20 text-center sm:px-6">
            <SearchX aria-hidden className="size-8 text-muted-foreground/60" />

            <p className="text-sm text-muted-foreground">
                Nothing on the menu matches{' '}
                <span className="font-medium text-foreground">“{query}”</span>.
            </p>

            <Button variant="outline" size="lg" onClick={onClear}>
                Show the whole menu
            </Button>
        </div>
    );
}
