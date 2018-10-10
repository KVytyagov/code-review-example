<?php
declare(strict_types=1);


namespace src\DataProvider;

use Psr\Cache\CacheItemPoolInterface;

class CachedDataProvider implements DataProviderInterface
{
    /**
     * @var DataProviderInterface
     */
    private $dataProvider;

    /**
     * @var CacheItemPoolInterface
     */
    private $cachePool;
    /**
     * @var string
     */
    private $cacheExpiryModifier;

    /**
     * CachedDataProvider constructor.
     *
     * @param DataProviderInterface  $dataProvider
     * @param CacheItemPoolInterface $cachePool
     * @param string                 $cacheExpiryModifier
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cachePool, string $cacheExpiryModifier = '+1 day')
    {
        $this->dataProvider = $dataProvider;
        $this->cachePool = $cachePool;
        $this->cacheExpiryModifier = $cacheExpiryModifier;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        $cacheKey = $this->getCacheKey($request);
        $cacheItem = $this->cache->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $result = $this->dataProvider->get($request);

        $cacheItem
            ->set($result)
            ->expiresAt(
                (new \DateTime())->modify($this->cacheExpiryModifier)
            );

        return $result;
    }

    /**
     * @param array $request
     *
     * @return string
     */
    private function getCacheKey(array $request): string
    {
        $request = $this->sortArrayByKeys($request);

        return \json_encode($request);
    }

    /**
     * @param array $arr
     *
     * @return array
     */
    private function sortArrayByKeys(array $arr): array
    {
        \ksort($arr);
        foreach ($arr as $key => $item) {
            if (\is_array($item)) {
                $arr[$key] = $this->sortArrayByKeys($item);
            }
        }

        return $arr;
    }
}
