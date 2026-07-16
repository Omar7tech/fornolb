/**
 * Build the `https://wa.me` link that opens WhatsApp pre-filled with a message.
 * The number is reduced to digits as required by the wa.me format.
 */
export function buildWhatsAppUrl(number: string, message: string): string {
    const digits = number.replace(/\D/g, '');

    return `https://wa.me/${digits}?text=${encodeURIComponent(message)}`;
}
