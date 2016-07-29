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
     * @var array
     */
    protected $providers = [];

    /**
     * @var ProviderInterface[]
     */
    protected $notHitProviders = [];

    /**
     * @param ProviderInterface $provider
     * @return $this
     */
    public function append(ProviderInterface $provider)
    {
        $this->providers[] = [
            'provider' => $provider,
            'weight' => (int) $provider->weight(),
        ];

        return $this;
    }

    /**
     * @return mixed
     */
    protected function resetProviders()
    {
        $dataOriginal = $this->dataOriginal();

        foreach ($this->notHitProviders as $provider) {
            $provider->set($dataOriginal);
        }

        return $dataOriginal;
    }

    /**
     * @return bool|mixed
     */
    protected function getProviders()
    {
        uasort($this->providers, function ($a, $b) {
            return $b['weight'] - $a['weight'];
        });

        foreach ($this->providers as $provider) {
            if ($provider['provider']->isHit()) {
                return $provider['provider']->get();
            } else {
                $this->notHitProviders[] = $provider['provider'];
            }
        }

        return false;
    }

    /**
     * @return mixed|bool
     */
    public function resolve()
    {
        return ($data = $this->getProviders()) ? $data : $this->resetProviders();
    }

    /**
     * 数据源, 所有缓存数据最终来源。
     *
     * @return mixed
     */
    abstract public function dataOriginal();
}