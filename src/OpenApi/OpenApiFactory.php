<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model;

class OpenApiFactory implements OpenApiFactoryInterface
{
  public function __construct(private OpenApiFactoryInterface $decorated) {}

  /**
   * 
   * @param array<string, object> $context
   * @return \ApiPlatform\OpenApi\OpenApi
   */
  public function __invoke(array $context = []): OpenApi
  {
    $openApi = $this->decorated->__invoke($context);

    /** @var \ApiPlatform\OpenApi\Model\PathItem $path */

    foreach ($openApi->getPaths()->getPaths() as $key => $path) {
      if ($path->getGet() && $path->getGet()->getSummary() === 'hidden') {
        $openApi->getPaths()->addPath($key, $path->withGet(null));
      }
    }

    $schemas = $openApi->getComponents()->getSecuritySchemes();

    // $schemas['bearerAuth'] = new \ArrayObject([
    //   'type' => 'http',
    //   'scheme' => 'bearer',
    //   'bearerFormat' => 'JWT'
    // ]);

    // $pathItem = $openApi->getPaths()->getPath('/api/grumpy_pizzas/{id}');
    // $operation = $pathItem->getGet();

    // $openApi->getPaths()->addPath('/auth/login', $pathItem->withGet(
    //   $operation->withParameters(array_merge(
    //     $operation->getParameters(),
    //     [new Model\Parameter('fields', 'query', 'Fields to remove of the output')]
    //   ))
    // ));

    // $openApi = $openApi->withInfo((new Model\Info('New Title', 'v2', 'Description of my custom API'))->withExtensionProperty('info-key', 'Info value'));
    // $openApi = $openApi->withExtensionProperty('key', 'Custom x-key value');
    // $openApi = $openApi->withExtensionProperty('x-value', 'Custom x-value value');

    return $openApi;
  }
}
