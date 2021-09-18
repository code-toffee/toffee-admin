<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Action\Admin\AddDeptAction;
use App\Action\Admin\DeleteDeptAction;
use App\Action\Admin\GetAdminDeptsAction;
use App\Action\Admin\UpdateDeptAction;
use App\Annotation\LogAction;
use App\Dto\Admin\Request\DeptStructRequstDto;
use App\Dto\Admin\Response\Dept\AdminDeptListResponseDto;
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
 * 部门证控制器
 * @Route("/admin")
 */
class AdminDeptController extends AbstractController
{
    /**
     * @Route("/get-dept-list",methods={"GET"})
     * @param GetAdminDeptsAction $action
     * @return Response
     * @throws Exception
     */
    public function getDeptList(GetAdminDeptsAction $action): Response
    {
        $depts = $action->run();
        $response = new AdminDeptListResponseDto();
        $response->items = $depts;
        return $response->transformerResponse();
    }

    /**
     * @Route("/add-dept",methods={"POST"})
     * @IsGranted("roles(dept:add)")
     * @LogAction(name="增加部门")
     * @ValidatorGroup(groups={"add"})
     *
     * @param DeptStructRequstDto $dto
     * @param AddDeptAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addDept(DeptStructRequstDto $dto, AddDeptAction $action, SuccessResponseDto $responseDto): Response
    {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/update-dept",methods={"POST"})
     * @LogAction(name="更新部门")
     * @IsGranted("roles(dept:update)")
     * @ValidatorGroup(groups={"update"})
     *
     * @param DeptStructRequstDto $dto
     * @param UpdateDeptAction $action
     * @param SuccessResponseDto $responseDto
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateDeptlist(
        DeptStructRequstDto $dto,
        UpdateDeptAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }

    /**
     * @Route("/delete-dept",methods={"POST"})
     * @LogAction(name="删除部门")
     * @IsGranted("roles(dept:delete)")
     * @ValidatorGroup(groups={"delete"})
     */
    public function deleteDeptlist(
        DeptStructRequstDto $dto,
        DeleteDeptAction $action,
        SuccessResponseDto $responseDto
    ): Response {
        $action->run($dto);
        return $responseDto->transformerResponse();
    }
}
