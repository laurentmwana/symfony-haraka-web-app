<?php

namespace App\Twig\Runtime;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class NavigationActiveRuntime implements RuntimeExtensionInterface
{
    public function __construct(private RequestStack $request) {}


    /**
     * @param mixed $link
     * @param array<int, string> $indexers
     * @param array<string, string|int|bool> $options
     * @return string
     */
    public function isActiveNavlink(mixed $link, array $indexers = [], array $options = []): string
    {
        $active = $this->isActive($link, $indexers);

        if (isset($options['dropdown']) && $options['dropdown'] === true) {
            return $active
                ? "block px-4 py-2 text-sm text-gray-700 bg-gray-100"
                : "block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100";
        }

        return $active
            ? "cursor-pointer flex items-center gap-3 rounded-lg px-3 py-2 text-indigo-300"
            : "cursor-pointer flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all hover:text-gray-900";
    }

    /**
     * @param mixed $link
     * @param array<int, string> $indexers
     * @return bool
     */
    private function isActive(mixed $link, array $indexers = []): bool
    {
        $url = $this->request->getCurrentRequest()->getPathInfo();


        if (!empty($indexers)) {
            return in_array(true, array_map(
                fn(string $indexer): bool => str_contains(
                    $indexer,
                    $url
                ),
                $indexers
            ));
        }

        return $url === $link;
    }
}
