<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Equipment;
use App\Exception\CannotPublishEquipmentException;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/equipment/publish/{equipment}', name: 'admin_equipment_publish')]
final class PublishEquipmentController extends AbstractController
{
    public function __invoke(Equipment $equipment, EquipmentRepository $equipmentRepository)
    {
        try {
            $equipment->publish();
            $equipmentRepository->save($equipment);
            $this->addFlash('notice', 'Equipment has been published');
        } catch(CannotPublishEquipmentException $e) {
            $this->addFlash('notice', $e->getMessage());
        }

        return $this->redirectToRoute('admin_equipment_show', ['equipment' => $equipment->getId()]);
    }
}
