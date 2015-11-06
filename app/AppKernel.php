<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Handles all requests forwarded from front controller.
 */
class AppKernel extends Kernel
{
    /** @var string */
    private $cacheDir = null;

    /** @var string */
    private $logDir = null;

    /**
     * Returns all bundles, that must be enabled.
     *
     * @return Bundle[]
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

            new ApiBundle\ApiBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * Loads application's configuration for specific environment.
     *
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * Sets alternative cache directory location.
     *
     * @param string $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * Sets alternative log directory location.
     *
     * @param string $logDir
     */
    public function setLogDir($logDir)
    {
        $this->logDir = $logDir;
    }

    /**
     * Return cache directory location.
     * If alternative location wasn't set returns default location.
     * Default location is always returned in production environment.
     *
     * @return string
     */
    public function getCacheDir()
    {
        if (in_array($this->environment, ['dev', 'test']) && $this->cacheDir) {
            return $this->cacheDir;
        }

        return parent::getCacheDir();
    }

    /**
     * Return log directory location.
     * If alternative location wasn't set returns default location.
     * Default location is always returned in production environment.
     *
     * @return string
     */
    public function getLogDir()
    {
        if (in_array($this->environment, ['dev', 'test']) && $this->logDir) {
            return $this->logDir;
        }

        return parent::getLogDir();
    }
}
