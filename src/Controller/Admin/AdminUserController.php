<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Action\Admin\AddUserAction;
use App\Action\Admin\ChargePwdAction;
use App\Action\Admin\DeleteUserAction;
use App\Action\Admin\GetActionLogAction;
use App\Action\Admin\GetAdminUserInfoAction;
use App\Action\Admin\GetMenusAction;
use App\Action\Admin\GetUserDetailAction;
use App\Action\Admin\GetUserPermCodesAction;
use App\Action\Admin\GetUserTableListAction;
use App\Action\Admin\UpdateUserAction;
use App\Annotation\LogAction;
use App\Dto\Admin\Request\ChargePwdRequestDto;
use App\Dto\Admin\Request\CommonQueryDto;
use App\Dto\Admin\Request\UserTableStructRequestDto;
use App\Dto\Admin\Response\AdminActionLogDto;
use App\Dto\Admin\Response\AdminPermCodesResponseDto;
use App\Dto\Admin\Response\AdminRoleResponseDto;
use App\Dto\Admin\Response\AdminUserResponseDto;
use App\Dto\Admin\Response\Menus\AdminMenuListResponseDto;
use App\Dto\Admin\Response\TableListDataResponseDto;
use App\Dto\Admin\Response\UserInfoItemResponseDto;
use App\Dto\Transformer\SuccessResponseDto;
use App\Dto\Transformer\ValidatorGroup;
use App\Entity\AdminDept;
use App\Entity\AdminLog;
use App\Entity\AdminRole;
use App\Entity\AdminUser;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 管理系统授权认证控制器
 * @Route("/admin")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/get-user-info")
     */
    public function getUserInfo(GetAdminUserInfoAction $action, AdminUserResponseDto $responseDto): Response
    {
        $info = $action->run();
        $responseDto->userName = $info->userName;
        $responseDto->id = $info->id;
        $responseDto->phone = $info->phone;
        $responseDto->realName = $info->realName;
        $responseDto->homePath = empty($info->homePath) ? null : $info->homePath;
        $responseDto->roles = (array)$responseDto->transArrayObjects($info->roles, function (AdminRole $role) {
            $o = new AdminRoleResponseDto();
            $o->name = $role->getName();
            $o->value = $role->getId();
            $o->level = $role->getLevel();
            $o->dataScope = $role->getDataScope();
            $o->description = $role->getDescription();
            return $o;
        });
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/get-prem-code")
     */
    public function getPermCode(GetUserPermCodesAction $action, AdminPermCodesResponseDto $responseDto): Response
    {
        $responseDto->permCode = $action->run();
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/get-menus")
     * @param GetMenusAction $action
     * @param AdminMenuListResponseDto $responseDto
     * @return Response
     * @throws Exception
     */
    public function getMenus(GetMenusAction $action, AdminMenuListResponseDto $responseDto): Response
    {
        $responseDto->items = $action->run();
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/get-user-table-list")
     */
    public function getUserTableList(CommonQueryDto $dto, GetUserTableListAction $action): Response
    {
        ['result' => $result, 'count' => $count] =
            $action->run($dto);
        $responser = new TableListDataResponseDto();
        $responser->total = $count;
        $responser->items = (array)$responser->transArrayObjects($result, function (AdminUser $adminUser) {
            $o = new UserInfoItemResponseDto();
            $o->id = $adminUser->getId();
            $o->deptPath = $adminUser->getDeptPath();
            $o->userName = $adminUser->getUserName();
            $o->realName = $adminUser->getRealName();
            $o->phone = $adminUser->getPhone();
            $o->isAdmin = $adminUser->isAdmin();
            $o->state = $adminUser->getState();
            $o->roleIds = $adminUser->getRoleIds();
            $o->createdTime = $adminUser->getCreatedTime()->format('Y-m-d H:i:s');
            $o->homePath = $adminUser->getHomePath();
            return $o;
        });
        return $responser->transformerResponse();
    }

    /**
     * @Route("/delete-user",methods={"POST"})
     * @LogAction(name="删除用户")
     * @IsGranted("roles(user:delete)")
     * @ValidatorGroup(groups={"delete"})
     *
     * @param UserTableStructRequestDto $dto
     * @param DeleteUserAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     */
    public function deleteUser(
        UserTableStructRequestDto $dto,
        DeleteUserAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/add-user",methods={"POST"})
     * @LogAction(name="增加用户")
     * @IsGranted("roles(user:add)")
     * @ValidatorGroup(groups={"add"})
     *
     * @param UserTableStructRequestDto $dto
     * @param AddUserAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addUser(
        UserTableStructRequestDto $dto,
        AddUserAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/update-user",methods={"POST"})
     * @LogAction(name="更新用户")
     * @IsGranted("roles(user:update)")
     * @ValidatorGroup(groups={"update"})
     *
     * @param UserTableStructRequestDto $dto
     * @param UpdateUserAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateUser(
        UserTableStructRequestDto $dto,
        UpdateUserAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/get-user-detail-info", methods={"POST"})
     * @ValidatorGroup(groups={"detail"})
     *
     * @param UserTableStructRequestDto $dto
     * @param GetUserDetailAction $action
     * @param UserInfoItemResponseDto $responseDto
     * @return Response
     * @throws Exception
     */
    public function userDetail(
        UserTableStructRequestDto $dto,
        GetUserDetailAction $action,
        UserInfoItemResponseDto $responseDto
    ): Response {
        /**
         * @var AdminUser $user
         * @var AdminRole[] $roles
         * @var AdminDept $dept
         * @var string[] $permCode
         */
        [
            'user'     => $user,
            'roles'    => $roles,
            'dept'     => $dept,
            'permCode' => $permCode,
            'menus'    => $menus
        ] = $action->run($dto);
        $responseDto->deptPath = $user->getDeptPath();
        $responseDto->id = $user->getId();
        $responseDto->userName = $user->getUserName();
        $responseDto->realName = $user->getRealName();
        $responseDto->phone = $user->getPhone();
        $responseDto->isAdmin = $user->isAdmin();
        $responseDto->state = $user->getState();
        $responseDto->createdTime = $user->getCreatedTime()->format('Y-m-d H:i:s');
        $responseDto->homePath = $user->getHomePath();
        $responseDto->rolesName = array_column($roles, 'name');
        $responseDto->deptName = $dept->getName();
        $responseDto->permCode = $permCode;
        $responseDto->menuList = $menus;

        return $responseDto->transformerResponse();
    }

    /**
     * 操作日志
     * @Route("/get-action-log")
     */
    public function actionLog(
        CommonQueryDto $dto,
        GetActionLogAction $action,
        TableListDataResponseDto $responseDto
    ): Response {
        $paginator = $action->run($dto);

        $items = $paginator->getQuery()->getResult();

        $responseDto->items = (array)$responseDto->transArrayObjects($items, function (AdminLog $adminLog) {
            $item = new AdminActionLogDto();
            $item->id = $adminLog->getId();
            $item->descript = $adminLog->getDescript();
            $item->method = $adminLog->getMethod();
            $item->controller = $adminLog->getController();
            $item->requestIp = $adminLog->getRequestIp();
            $item->ipAddr = $adminLog->getIpAddr();
            $item->brower = $adminLog->getBrower();
            $item->request = $adminLog->getRequest();
            $item->response = $adminLog->getResponse();
            $item->createdTime = $adminLog->getCreatedTime()->format('Y-m-d H:i:s');
            return $item;
        });
        $responseDto->total = $paginator->count();
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/charge-pwd",methods={"POST"})
     *
     * @param ChargePwdRequestDto $dto
     * @param ChargePwdAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function chargePwd(
        ChargePwdRequestDto $dto,
        ChargePwdAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }
}
