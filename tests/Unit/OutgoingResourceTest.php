<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;
use SergiX44\Nutgram\Testing\OutgoingResource;

beforeEach(function () {
    $resource = fopen('php://memory', 'rwb+');
    fwrite($resource, 'bar');

    $this->outgoingResource = new OutgoingResource(
        name: 'foo.txt',
        type: 'text/plain',
        size: 3,
        error: 0,
        stream: Utils::streamFor($resource),
    );
});

it('returns serialized json', function ($name, $output) {
    $resource = fopen('php://memory', 'rwb+');
    fwrite($resource, 'bar');

    $outgoingResource = new OutgoingResource(
        name: $name,
        type: 'text/plain',
        size: 3,
        error: 0,
        stream: Utils::streamFor($resource),
    );

    expect(json_encode($outgoingResource))->toContain($output);
})->with([
    'filled name' => ['foo.txt', 'OutgoingResource{foo.txt}'],
    'empty name' => [null, 'OutgoingResource'],
]);

it('returns name', function () {
    expect($this->outgoingResource->getName())->toBe('foo.txt');
});

it('returns type', function () {
    expect($this->outgoingResource->getType())->toBe('text/plain');
});

it('returns size', function () {
    expect($this->outgoingResource->getSize())->toBe(3);
});

it('returns error', function () {
    expect($this->outgoingResource->getError())->toBe(0);
});

it('returns stream', function () {
    expect($this->outgoingResource->getStream())->toBeInstanceOf(StreamInterface::class);
});
