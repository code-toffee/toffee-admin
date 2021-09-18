<?php
declare(strict_types=1);

namespace App\Dto\Admin\Response;

class AdminActionLogDto
{
    public string $id;

    public string $descript;

    public string $method;

    public string $controller;

    public string $requestIp;

    public string $ipAddr;

    public string $brower;

    public string $request;

    public string $response;

    public string $createdTime;
}
