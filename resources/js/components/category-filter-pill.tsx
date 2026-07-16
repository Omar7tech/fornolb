import { cn } from '@/lib/utils';

export function CategoryFilterPill({
    label,
    isActive = false,
    onClick,
    className,
}: {
    label: string;
    isActive?: boolean;
    onClick?: () => void;
    className?: string;
}) {
    return (
        <button
            type="button"
            onClick={onClick}
            aria-pressed={isActive}
            className={cn(
                'rounded-full border px-4 py-2 text-sm font-medium whitespace-nowrap transition-colors',
                'focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none',
                isActive
                    ? 'border-transparent bg-primary text-primary-foreground'
                    : 'border-border bg-background text-foreground hover:bg-muted',
                className,
            )}
        >
            {label}
        </button>
    );
}
