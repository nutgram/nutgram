<?php

dataset('patterns_sensitive', [
    'latin-lower-lower' => ['foo', 'foo', true],
    'latin-lower-upper' => ['foo', 'FOO', false],
    'latin-upper-lower' => ['FOO', 'foo', false],
    'latin-upper-upper' => ['FOO', 'FOO', true],
    'cyrillic-lower-lower' => ['пример', 'пример', true],
    'cyrillic-lower-upper' => ['пример', 'ПРИМЕР', false],
    'cyrillic-upper-lower' => ['ПРИМЕР', 'пример', false],
    'cyrillic-upper-upper' => ['ПРИМЕР', 'ПРИМЕР', true],
]);
