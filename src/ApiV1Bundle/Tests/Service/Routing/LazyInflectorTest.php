<?php

namespace ApiV1Bundle\Tests\Controller;

use PHPUnit_Framework_TestCase;
use ApiV1Bundle\Service\Routing\LazyInflector;

/**
 * Unit tests covering service.
 */
class LazyInflectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Checks lazy pluralization method.
     */
    public function testPluralize()
    {
        $word = 'ticket';
        $inflector = new LazyInflector();

        $this->assertEquals($word, $inflector->pluralize($word));
    }
}
