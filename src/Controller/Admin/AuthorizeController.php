<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Action\Admin\AdminLoginAction;
use App\Action\Admin\AdminLogoutAction;
use App\Dto\Admin\Request\AdminLoginRequestDto;
use App\Dto\Admin\Response\AdminLoginResponseDto;
use App\Dto\Admin\Response\AdminRoleResponseDto;
use App\Dto\Transformer\SuccessResponseDto;
use App\Entity\AdminRole;
use App\Entity\AdminUser;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 管理系统授权认证控制器
 * @Route("/admin",defaults={"anonymous":true})
 */
class AuthorizeController extends AbstractController
{
    /**
     * 管理登陆
     * @Route("/login",methods={"POST"})
     *
     * @param AdminLoginRequestDto $dto
     * @param AdminLoginAction $action
     * @return Response
     * @throws ReflectionException
     */
    public function login(AdminLoginRequestDto $dto, AdminLoginAction $action): Response
    {
        /**
         * @var AdminUser $admin
         * @var string $token
         * @var AdminRole[] $roles
         */
        ['userInfo' => $admin, 'token' => $token, 'roles'=>$roles] = $action->run($dto);
        $response = new AdminLoginResponseDto();
        $response->id = $admin->getId();
        $response->userName = $admin->getUserName();
        $response->realName = $admin->getRealName();
        $response->phone = $admin->getPhone();
        $response->token = $token;
        $response->roles =(array) $response->transArrayObjects($roles, function (AdminRole $role) {
            $o = new AdminRoleResponseDto();
            $o->name = $role->getName();
            $o->value = $role->getId();
            $o->level = $role->getLevel();
            $o->dataScope = $role->getDataScope();
            $o->description = $role->getDescription();
            return $o;
        });


        $response->loginTime = date('Y-m-d H:i:s', time());

        return $response->transformerResponse();
    }

    /**
     * 管理登出
     * @Route("/logout",methods={"GET"},defaults={"anonymous":false})
     * @param AdminLogoutAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ReflectionException
     */
    public function logout(AdminLogoutAction $action, SuccessResponseDto $responseDto): Response
    {
        $action->run();
        return $responseDto->transformerResponse();
    }
}
