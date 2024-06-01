<?php
namespace App\Service;

use App\Service\Shortcodes\ShortcodesInterface;
use Psr\Container\ContainerInterface;

class ShortcodesFactory
{
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function get(string $name): ShortcodesInterface
    {
        $ShortcodeName = sprintf('App\\Service\\Shortcodes\\%s', $name);

        if (class_exists($ShortcodeName) && $this->locator->has($ShortcodeName)) {
            return $this->locator->get($ShortcodeName);
        } else {
            throw new \InvalidArgumentException("Shortcodes service {$name} does not exist.");
        }

        throw new \InvalidArgumentException("Shortcodes service {$name} does not exist.");
    }
}