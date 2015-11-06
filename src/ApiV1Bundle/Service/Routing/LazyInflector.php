<?php

namespace ApiV1Bundle\Service\Routing;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

/**
 * This inflector does nothing.
 * This behaviour is intended to enable properly route generation.
 */
class LazyInflector implements InflectorInterface
{
    /**
     * Returns provided string without any modification.
     *
     * @param string $word
     * @return string
     */
    public function pluralize($word)
    {
        return $word;
    }
}
