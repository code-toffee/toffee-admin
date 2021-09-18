<?php

namespace App\Message;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ServerBag;

final class AdminLogMessage implements AsyncMessageInterface
{
    private string $logName;

    private Response $response;

    private ParameterBag $parameterBag;

    private InputBag $inputBag;

    private HeaderBag $headerBag;

    private ServerBag $serverBag;

    private ?string $content = null;

    private string $method;

    private int $userId;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return AdminLogMessage
     */
    public function setUserId(int $userId): AdminLogMessage
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogName(): string
    {
        return $this->logName;
    }

    /**
     * @param string $logName
     * @return AdminLogMessage
     */
    public function setLogName(string $logName): self
    {
        $this->logName = $logName;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     * @return AdminLogMessage
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return ParameterBag
     */
    public function getParameterBag(): ParameterBag
    {
        return $this->parameterBag;
    }

    /**
     * @param ParameterBag $parameterBag
     * @return AdminLogMessage
     */
    public function setParameterBag(ParameterBag $parameterBag): self
    {
        $this->parameterBag = $parameterBag;
        return $this;
    }

    /**
     * @return InputBag
     */
    public function getInputBag(): InputBag
    {
        return $this->inputBag;
    }

    /**
     * @param InputBag $inputBag
     * @return AdminLogMessage
     */
    public function setInputBag(InputBag $inputBag): self
    {
        $this->inputBag = $inputBag;
        return $this;
    }

    /**
     * @return HeaderBag
     */
    public function getHeaderBag(): HeaderBag
    {
        return $this->headerBag;
    }

    /**
     * @param HeaderBag $headerBag
     * @return AdminLogMessage
     */
    public function setHeaderBag(HeaderBag $headerBag): self
    {
        $this->headerBag = $headerBag;
        return $this;
    }

    /**
     * @return ServerBag
     */
    public function getServerBag(): ServerBag
    {
        return $this->serverBag;
    }

    /**
     * @param ServerBag $serverBag
     * @return AdminLogMessage
     */
    public function setServerBag(ServerBag $serverBag): self
    {
        $this->serverBag = $serverBag;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return AdminLogMessage
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return AdminLogMessage
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }
}
