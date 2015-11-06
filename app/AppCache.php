<?php

require_once __DIR__ . '/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

/**
 * Acts as a reverse proxy - caches responses from application.
 */
class AppCache extends HttpCache
{
}
