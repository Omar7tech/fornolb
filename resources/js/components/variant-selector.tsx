import { Layers } from 'lucide-react';

import { cn } from '@/lib/utils';
import type { ProductVariant } from '@/types';

/** Joined segmented control for picking a product variant, with a clear hint. */
export function VariantSelector({
    variants,
    selectedIndex,
    onSelect,
}: {
    variants: ProductVariant[];
    selectedIndex: number;
    onSelect: (index: number) => void;
}) {
    return (
        <div className="flex flex-col gap-1.5">
            <span className="inline-flex items-center gap-1 text-[10px] font-medium tracking-wider text-muted-foreground uppercase">
                <Layers className="size-3" />
                Choose an option
            </span>

            <div
                role="group"
                aria-label="Choose a variant"
                className="flex w-full overflow-hidden rounded-md border border-border"
            >
                {variants.map((variant, index) => {
                    const selected = index === selectedIndex;

                    return (
                        <button
                            key={index}
                            type="button"
                            aria-pressed={selected}
                            onClick={() => onSelect(index)}
                            className={cn(
                                'min-w-0 flex-1 truncate px-2 py-1.5 text-xs font-medium transition-colors not-first:border-l not-first:border-border focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none focus-visible:-outline-offset-2',
                                selected
                                    ? 'bg-brand-teal text-white'
                                    : 'bg-card text-card-foreground hover:bg-muted',
                            )}
                        >
                            {variant.name}
                        </button>
                    );
                })}
            </div>
        </div>
    );
}
