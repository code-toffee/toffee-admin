<?php
declare(strict_types=1);

namespace App\Service\Pay\Dto;

class PayTradeDto
{
    private bool $outputResponse;

    private string $body;

    /**
     * @return bool
     */
    public function isOutputResponse(): bool
    {
        return $this->outputResponse;
    }

    /**
     * @param bool $outputResponse
     */
    public function setOutputResponse(bool $outputResponse): void
    {
        $this->outputResponse = $outputResponse;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }



}
