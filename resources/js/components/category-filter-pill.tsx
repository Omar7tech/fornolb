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
                'inline-flex min-h-11 items-center rounded-full border px-3.5 text-sm font-medium whitespace-nowrap transition-colors',
                'focus-visible:ring-2 focus-visible:ring-ring focus-visible:outline-none',
                isActive
                    ? 'border-transparent bg-brand-teal text-white dark:bg-brand-teal-light dark:text-brand-ink'
                    : 'border-border bg-background text-foreground hover:bg-muted',
                className,
            )}
        >
            {label}
        </button>
    );
}
