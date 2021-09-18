<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Action\Admin\AddMenuAction;
use App\Action\Admin\DeleteMenuAction;
use App\Action\Admin\GetAdminMenuListAction;
use App\Action\Admin\UpdateMenuAction;
use App\Annotation\LogAction;
use App\Dto\Admin\Request\MenuStructRequstDto;
use App\Dto\Admin\Response\Menus\AdminMenuListResponseDto;
use App\Dto\Transformer\SuccessResponseDto;
use App\Dto\Transformer\ValidatorGroup;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 菜单控制器
 * @Route("/admin")
 */
class AdminMenuController extends AbstractController
{
    /**
     * @Route("/get-menu-list")
     * @param GetAdminMenuListAction $action
     * @param AdminMenuListResponseDto $responseDto
     * @return Response
     * @throws Exception
     */
    public function getMenuList(GetAdminMenuListAction $action, AdminMenuListResponseDto $responseDto): Response
    {
        $responseDto->items = $action->run();
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/delete-menu")
     * @LogAction(name="删除菜单")
     * @IsGranted("roles(menu:delete)")
     * @ValidatorGroup(groups={"delete"})
     */
    public function deleteMenu(
        MenuStructRequstDto $dto,
        DeleteMenuAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/update-menu")
     * @LogAction(name="更新菜单")
     * @IsGranted("roles(menu:update)")
     * @ValidatorGroup(groups={"update"})
     *
     * @param MenuStructRequstDto $dto
     * @param UpdateMenuAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateMenu(
        MenuStructRequstDto $dto,
        UpdateMenuAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/add-menu")
     * @LogAction(name="增加菜单")
     * @IsGranted("roles(menu:add)")
     * @ValidatorGroup(groups={"add"})
     *
     * @param MenuStructRequstDto $dto
     * @param AddMenuAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     */
    public function addMenu(
        MenuStructRequstDto $dto,
        AddMenuAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }
}
