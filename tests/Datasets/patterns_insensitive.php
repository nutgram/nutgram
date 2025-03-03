<?php

dataset('patterns_insensitive', [
    'latin-lower-lower' => ['foo', 'foo', true],
    'latin-lower-upper' => ['foo', 'FOO', true],
    'latin-upper-lower' => ['FOO', 'foo', true],
    'latin-upper-upper' => ['FOO', 'FOO', true],
    'cyrillic-lower-lower' => ['пример', 'пример', true],
    'cyrillic-lower-upper' => ['пример', 'ПРИМЕР', true],
    'cyrillic-upper-lower' => ['ПРИМЕР', 'пример', true],
    'cyrillic-upper-upper' => ['ПРИМЕР', 'ПРИМЕР', true],
]);
