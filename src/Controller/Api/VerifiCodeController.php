<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Action\Api\GenerateImgCodeAction;
use App\Action\Api\GetSmsCodeAction;
use App\Dto\Api\Request\GetSmsDto;
use App\Dto\Api\Response\ImgCodeResponseDto;
use App\Dto\Transformer\SuccessResponseDto;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 验证码接口
 * @package App\Controller\Api
 *
 * @Route("/api/verify",defaults={"anonymous":true})
 */
class VerifiCodeController extends AbstractController
{
    /**
     * 短信验证码
     * @Route("/sms-code",methods={"POST"})
     * @param GetSmsDto $smsDto
     * @param GetSmsCodeAction $action
     * @param SuccessResponseDto $successResponseDto
     * @return Response
     * @throws ReflectionException
     */
    public function smsCode(GetSmsDto $smsDto,GetSmsCodeAction $action,SuccessResponseDto $successResponseDto): Response
    {
        $action->run($smsDto);
        return $successResponseDto->transformerResponse();
    }

    /**
     * 图形验证码
     * @Route("/img-code",methods={"GET"})
     * @param GenerateImgCodeAction $action
     * @param ImgCodeResponseDto $imgCodeResponseDto
     * @return Response
     */
    public function imgCode(GenerateImgCodeAction $action, ImgCodeResponseDto $imgCodeResponseDto): Response
    {
        $captcha = $action->run();

        $imgCodeResponseDto->key = $captcha->getKey();
        $imgCodeResponseDto->imgData = $captcha->getImgData();
        return $imgCodeResponseDto->transformerResponse();

    }
}
