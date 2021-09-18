<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Action\Admin\AddRoleAction;
use App\Action\Admin\DeleteRoleAction;
use App\Action\Admin\GetAllRoleListAction;
use App\Action\Admin\GetRolesListAction;
use App\Action\Admin\UpdateRoleAction;
use App\Annotation\LogAction;
use App\Dto\Admin\Request\CommonQueryDto;
use App\Dto\Admin\Request\RoleStructRequestDto;
use App\Dto\Admin\Response\Role\AdminRoleListItemDto;
use App\Dto\Admin\Response\Role\AdminRoleListResponseDto;
use App\Dto\Admin\Response\Role\RoleListItemDto;
use App\Dto\Admin\Response\TableListDataResponseDto;
use App\Dto\Transformer\SuccessResponseDto;
use App\Dto\Transformer\ValidatorGroup;
use App\Entity\AdminRole;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 角色控制器
 * @Route("/admin")
 */
class AdminRoleController extends AbstractController
{
    /**
     * @Route("/get-role-list",methods={"GET"})
     *
     * @param CommonQueryDto $dto
     * @param GetRolesListAction $action
     * @return Response
     * @throws Exception
     */
    public function getRoleList(CommonQueryDto $dto, GetRolesListAction $action): Response
    {
        ['result' => $result, 'count' => $count] = $action->run($dto);

        $response = new TableListDataResponseDto();
        $response->total = $count;
        $response->items = (array)$response->transArrayObjects($result, function (AdminRole $adminRole) {
            $obj = new AdminRoleListItemDto();
            $obj->id = $adminRole->getId();
            $obj->name = $adminRole->getName();
            $obj->description = $adminRole->getDescription();
            $obj->dataScope = $adminRole->getDataScope();
            $obj->level = $adminRole->getLevel();
            $obj->createdTime = $adminRole->getCreatedTime()->format('Y-m-d H:i:s');
            $obj->deptIds = $adminRole->getDeptIds() ?? [];
            $obj->menuIds = $adminRole->getMenuIds() ?? [];
            return $obj;
        });
        return $response->transformerResponse();
    }

    /**
     * @Route("/add-role",methods={"POST"})
     * @LogAction(name="增加角色")
     * @IsGranted("roles(role:add)")
     * @ValidatorGroup(groups={"add"})
     *
     * @param RoleStructRequestDto $dto
     * @param AddRoleAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addRole(RoleStructRequestDto $dto, AddRoleAction $action, SuccessResponseDto $responseDto): Response
    {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/update-role",methods={"POST"})
     * @LogAction(name="更新角色")
     * @IsGranted("roles(role:update)")
     * @ValidatorGroup(groups={"update"})
     */
    public function updateRole(
        RoleStructRequestDto $dto,
        UpdateRoleAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/delete-role",methods={"POST"})
     * @LogAction(name="删除角色")
     * @IsGranted("roles(role:delete)")
     * @ValidatorGroup(groups={"delete"})
     */
    public function deleteRole(
        RoleStructRequestDto $dto,
        DeleteRoleAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/get-all-role-list")
     */
    public function getAllRoleList(GetAllRoleListAction $action, AdminRoleListResponseDto $responseDto): Response
    {
        $roles = $action->run();

        $responseDto->items = (array)$responseDto->transArrayObjects($roles, function (AdminRole $role) {
            $o = new RoleListItemDto();
            $o->id = $role->getId();
            $o->name = $role->getName();
            return $o;
        });

        return $responseDto->transformerResponse();
    }
}
