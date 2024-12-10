<?php

namespace App\Serializer\Normalizer;

use App\Entity\Paid;
use App\Entity\User;
use App\Entity\Identificator;
use App\Entity\Student;
use Vich\UploaderBundle\Storage\StorageInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ContentUrlNormalizer implements NormalizerInterface
{
    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(#[Autowire(service: 'api_platform.jsonld.normalizer.item')]
    private readonly NormalizerInterface $normalizer, private readonly StorageInterface $storage) {}

    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        $context[self::ALREADY_CALLED] = true;
        if ($object instanceof Student) {
            $object->contentUrl = $this->storage->resolveUri($object, 'identificator');
        } else {
            $object->contentUrl = $this->storage->resolveUri($object, 'file');
        }
        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(
        mixed $data,
        ?string $format = null,
        array $context = []
    ): bool {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return ($data instanceof Paid)
            || ($data instanceof User)
            || ($data instanceof Student);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Paid::class => true,
            Student::class => true,
            User::class => true,
        ];
    }
}
