<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Properties;

enum ParseMode: string
{
    case MARKDOWN = 'MarkdownV2';
    case MARKDOWN_LEGACY = 'Markdown';
    case HTML = 'HTML';
}
