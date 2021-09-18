<?php
declare(strict_types=1);

namespace App\Utils;

use App\Entity\Cache\CacheDtoInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisUtils
{
    private Serializer $serializer;

    private array $redisConfig;

    private $client;

    public function __construct($redisConfig)
    {
        $this->redisConfig = $redisConfig;
        ['dsn' => $dsn, 'options' => $options] = $this->redisConfig;
        $this->client = RedisAdapter::createConnection($dsn, $options);
        $this->serializer = SerializerBuilder::create()
            ->build();
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $cacheEntityName
     * @param ...$keys
     * @return ?object
     *
     * @psalm-template  T of object
     * @psalm-param class-string<T> $cacheEntityName
     * @psalm-return ?T
     */
    public function getObject(string $cacheEntityName, ...$keys): ?object
    {
        $object = new $cacheEntityName(...$keys);
        if (!$object instanceof CacheDtoInterface) {
            return null;
        }
        $data = $this->client->get($object->getCacheKey());
        if (!$data) {
            return null;
        }
        $object = $this->serializer->deserialize($data, $cacheEntityName, 'json');
        $object->setCacheKey(...$keys);
        return $object;
    }

    /**
     * save object cache
     * @param CacheDtoInterface $cache
     * @param int $ttl
     * @return bool
     */
    public function setObject(CacheDtoInterface $cache, $ttl = 0): bool
    {
        $serializer = SerializerBuilder::create()->build();
        $data = $serializer->serialize($cache, 'json');
        $key = $cache->getCacheKey();

        if ($ttl > 0) {
            return $this->client->setex($key, $ttl, $data);
        }

        return $this->client->set($key, $data);
    }

    /**
     * @param CacheDtoInterface $cache
     * @return int
     */
    public function delObject(CacheDtoInterface $cache): int
    {
        $key = $cache->getCacheKey();
        return $this->client->del($key);
    }
}
