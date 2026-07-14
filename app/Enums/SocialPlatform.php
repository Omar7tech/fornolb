<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SocialPlatform: string implements HasLabel
{
    case WHATSAPP = 'whatsapp';
    case INSTAGRAM = 'instagram';
    case FACEBOOK = 'facebook';
    case TIKTOK = 'tiktok';
    case OTHER = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::WHATSAPP => 'WhatsApp',
            self::INSTAGRAM => 'Instagram',
            self::FACEBOOK => 'Facebook',
            self::TIKTOK => 'TikTok',
            self::OTHER => 'Other',
        };
    }
}
