<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Equipment;
use App\Entity\Repair;
use App\Form\RepairType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/repair')]
class RepairController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
    ) {

    }

    #[Route('/index', name: 'admin_repair_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $repository = $this->manager->getRepository(Repair::class);
        $repairs = $repository->findAll();

        return $this->render('admin/repair/index.html.twig', ['repairs' => $repairs]);

    }

    #[Route('/create/{equipment?}', name:'admin_repair_create', methods: ['GET', 'POST'])]
    public function create(Request $request, Equipment $equipment = null): Response
    {
        $repair = new Repair();
        if ($equipment) {
            $repair->setEquipment($equipment);
        }

        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $repair = $form->getData();
            $this->manager->persist($repair);
            $this->manager->flush();
            $this->addFlash('notice', 'New repair was added');
            return $this->redirectToRoute('admin_repair_index');
        }

        return $this->render('admin/repair/new.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/edit/{repair}', name: 'admin_repair_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Repair $repair): Response
    {
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $repair = $form->getData();
            $this->manager->flush();
            $this->addFlash('notice', 'Repair was updated');
            return $this->redirectToRoute('admin_repair_show', ['repair' => $repair->getId()]);
        }

        return $this->render('admin/repair/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/show/{repair}', name: 'admin_repair_show', methods: ['GET'])]
    public function show(Repair $repair): Response
    {
        return $this->render('admin/repair/show.html.twig', ['repair' => $repair]);
    }

    #[Route('/delete/{repair}', name: 'admin_repair_delete', methods: ['GET'])]
    public function delete(Repair $repair): Response
    {
        $this->manager->remove($repair);
        $this->manager->flush();
        $this->addFlash('notice', 'Repair was deleted');

        return $this->redirectToRoute('admin_repair_index');
    }
}
