<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Middleware;

/**
 * Class Middleware
 *
 * @package FastD\Middleware
 */
abstract class Middleware
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = [];

    /**
     * @param ProviderInterface $provider
     * @return $this
     */
    public function append(ProviderInterface $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    protected function resetProviders()
    {
        $dataOriginal = $this->dataOriginal();

        foreach ($this->providers as $provider) {
            if (!$provider->isHit()) {
                $provider->set($provider->name(), $dataOriginal);
            }
        }

        return $dataOriginal;
    }

    protected function getProviders()
    {
        foreach ($this->providers as $provider) {
            if ($provider->isHit()) {
                return $provider->get();
            }
        }

        return false;
    }

    /**
     * @return mixed|bool
     */
    public function invoke()
    {
        return ($data = $this->getProviders()) ? $data : $this->resetProviders();
    }

    /**
     * @return mixed
     */
    abstract public function dataOriginal();
}