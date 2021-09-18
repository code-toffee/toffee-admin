<?php
declare(strict_types=1);

namespace App\Task\Admin;

use App\Entity\AdminRole;
use App\Entity\AdminUser;
use App\Entity\Cache\AdminUserCache;
use App\Utils\RedisUtils;
use App\Utils\TokenUtils\TokenUtils;
use DateTime;

class UpdateAdminUserInfoCacheTask
{
    private RedisUtils $redisUtils;

    private TokenUtils $tokenUtils;

    private bool $removeToken = false;

    private string $token = '';

    private bool $flushToken = false;

    private bool $storeRole = false;

    /**
     * @var AdminRole[]
     */
    private array $roles = [];

    /**
     * UpdateUserInfoCacheTask constructor.
     * @param RedisUtils $redisUtils
     * @param TokenUtils $tokenUtils
     */
    public function __construct(RedisUtils $redisUtils, TokenUtils $tokenUtils)
    {
        $this->redisUtils = $redisUtils;
        $this->tokenUtils = $tokenUtils;
    }

    /**
     * @param AdminUser|AdminUserCache $user
     * @return bool
     */
    public function run($user): bool
    {
        $minute = 60;
        $hours = 60 * $minute;
        $day = 24 * $hours;
        // 生成用户缓存

        if ($user instanceof AdminUser) {
            //生成或者更新缓存
            $cache = $this->redisUtils->getObject(AdminUserCache::class, $user->getId());
            if (is_null($cache)) {
                $cache = new AdminUserCache($user->getId());
                $cache->tokens=[];
            } else {
                $cache->tokens = $this->checkToken($cache->tokens);
            }
            $cache->id = $user->getId();
            $cache->state = $user->getState();
            $cache->userName = $user->getUsername();
            $cache->realName = $user->getRealName();
            $cache->isAdmin = $user->isAdmin();
            $cache->phone = $user->getPhone();
            $cache->homePath = $user->getHomePath();
            $cache->loginDate = new DateTime();
        } else {
            //如果是缓存类型，就只检查token
            $cache = $user;
            $cache->tokens = $this->checkToken($cache->tokens);
        }

        if (!empty($this->token) && !$this->removeToken) {
            //设置token
            $cache->tokens[] = $this->token;
        }

        if ($this->removeToken && !empty($this->token)) {
            // 删除token
            $cache->tokens = $this->checkToken($cache->tokens,$this->token);
        }
        if ($this->flushToken) {
            // 刷新token
            $cache->tokens = [];
        }

        if ($this->storeRole) {
            $cache->roles = $this->roles;
        }

        return $this->redisUtils->setObject($cache, 30 * $day);
    }


    private function checkToken(array $tokens,?string $rmToken = null): array
    {
        foreach ($tokens as $key => $item) {
            // 检查失效token ，同时判断传入的token是否需要删除
            if (!$this->tokenUtils->validateToken($item) || (($rmToken === $item))) {
                array_splice($tokens, $key, 1);
            }
        }
        return $tokens;
    }

    public function preRemoveToken(string $token): self
    {
        $this->removeToken = true;
        $this->token = $token;
        return $this;
    }

    public function preFlushToken(): self
    {
        $this->flushToken = true;
        return $this;
    }

    public function preStoreToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param AdminRole[] $roles
     */
    public function preStoreUserRole(array $roles):self
    {
        $this->storeRole = true;
        $this->roles = $roles;
        return $this;
    }
}
