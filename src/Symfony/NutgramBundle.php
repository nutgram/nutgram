<?php

namespace SergiX44\Nutgram\Symfony;

use SergiX44\Nutgram\Symfony\DependencyInjection\NutgramExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NutgramBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new NutgramExtension();
    }
}
