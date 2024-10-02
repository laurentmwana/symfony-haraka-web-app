<?php

namespace App\Twig\Runtime;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class NavigationActiveRuntime implements RuntimeExtensionInterface
{
    public function __construct(private RequestStack $request) {}

    /**
     * @param string $link
     * @param array<int, string> $indexers
     * @return bool
     */
    public function isActiveNavlink(string $link, array $indexers = []): bool
    {
        $url = $this->request->getCurrentRequest()->getPathInfo();

        if (!empty($indexers)) {
            $matches = array_map(fn($indexer) => str_contains($url, $indexer), $indexers);

            return in_array(true, $matches);
        }

        return $url === $link;
    }
}
