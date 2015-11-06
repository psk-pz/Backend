<?php

namespace ApiV1Bundle\Service;

use FOS\RestBundle\Util\Inflector\InflectorInterface;

/**
 * Description.
 */
class LazyInflector implements InflectorInterface
{
    /**
     * Description.
     *
     * @param string $word
     * @return string
     */
    public function pluralize($word)
    {
        return $word;
    }
}
