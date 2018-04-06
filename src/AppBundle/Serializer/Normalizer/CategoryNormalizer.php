<?php

namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Category;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CategoryNormalizer implements NormalizerInterface
{
    protected $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return is_object($data) && !$data instanceof Category;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $this->normalizer->setIgnoredAttributes(['articles']);
        return $this->normalizer->normalize($object, $format, $context);
    }
}
