<?php

namespace App\Entity;

use App\Repository\AdminLogRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=AdminLogRepository::class)
 * @ORM\Table(options={"comment"="日志表"},indexes={@ORM\Index(name="user_idx",columns={"uid"})})
 */
class AdminLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private string $id;

    /**
     * @ORM\Column(type="integer",options={"comment"="用户Id"})
     */
    private int $uid;

    /**
     * @ORM\Column(type="string",options={"comment"="描述","default"=""})
     */
    private string $descript = '';

    /**
     * @ORM\Column(type="string",length=15,options={"comment"="请求方式","default"=""})
     */
    private string $method = '';

    /**
     * @ORM\Column(type="string",options={"comment"="请求控制器","default"=""})
     */
    private string $controller = '';

    /**
     * @ORM\Column(type="string",options={"comment"="请求ip","default"=""})
     */
    private string $requestIp = '';

    /**
     * @ORM\Column(type="string",options={"comment"="ip地址","default"=""})
     */
    private string $ipAddr = '';

    /**
     * @ORM\Column(type="string",options={"comment"="浏览器","default"=""})
     */
    private string $brower = '';

    /**
     * @ORM\Column(type="text",options={"comment"="请求参数","default"=""})
     */
    private string $request = '';

    /**
     * @ORM\Column(type="text",options={"comment"="请求参数","default"=""})
     */
    private string $response = '';

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="创建时间"})
     * @Gedmo\Timestampable(on ="create")
     */
    private ?DateTimeInterface $createdTime;

    public function getId(): string
    {
        return $this->id;
    }

    public function getUid(): int
    {
        return $this->uid;
    }

    public function setUid(int $uid): self
    {
        $this->uid = $uid;
        return $this;
    }

    public function getDescript(): string
    {
        return $this->descript;
    }

    public function setDescript(string $descript): self
    {
        $this->descript = $descript;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }

    public function getRequestIp(): string
    {
        return $this->requestIp;
    }

    public function setRequestIp(string $requestIp): self
    {
        $this->requestIp = $requestIp;
        return $this;
    }

    public function getIpAddr(): string
    {
        return $this->ipAddr;
    }

    public function setIpAddr(string $ipAddr): self
    {
        $this->ipAddr = $ipAddr;
        return $this;
    }

    public function getBrower(): string
    {
        return $this->brower;
    }

    public function setBrower(string $brower): self
    {
        $this->brower = $brower;
        return $this;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function setRequest(string $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function setResponse(string $response): self
    {
        $this->response = $response;
        return $this;
    }

    public function getCreatedTime(): ?DateTimeInterface
    {
        return $this->createdTime;
    }
}
