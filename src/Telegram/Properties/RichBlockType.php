<?php

namespace SergiX44\Nutgram\Telegram\Properties;

enum RichBlockType: string
{
    case PARAGRAPH = 'paragraph';
    case HEADING = 'heading';
    case PRE = 'pre';
    case FOOTER = 'footer';
    case DIVIDER = 'divider';
    case MATHEMATICAL_EXPRESSION = 'mathematical_expression';
    case ANCHOR = 'anchor';
    case LIST = 'list';
    case BLOCKQUOTE = 'blockquote';
    case PULLQUOTE = 'pullquote';
    case COLLAGE = 'collage';
    case SLIDESHOW = 'slideshow';
    case TABLE = 'table';
    case DETAILS = 'details';
    case MAP = 'map';
    case ANIMATION = 'animation';
    case AUDIO = 'audio';
    case PHOTO = 'photo';
    case VIDEO = 'video';
    case VOICE_NOTE = 'voice_note';
    case THINKING = 'thinking';
}
