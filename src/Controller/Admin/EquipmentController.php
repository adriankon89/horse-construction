<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/equipment')]
#[IsGranted('ROLE_USER')]
final class EquipmentController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
    ) {

    }

    #[Route('/', name: 'admin_equipment_index', methods: ['GET'])]
    public function index(Request $request)
    {
        $repository = $this->manager->getRepository(Equipment::class);
        $equipment = $repository->findAll();

        return $this->render('admin/equipment/index.html.twig', ['elements' => $equipment]);
    }

    #[Route('/create', name:'admin_equipment_create', methods: ['GET', 'POST'])]
    public function create(Request $request, FileUploader $fileUploader): Response
    {
        $equipment = new Equipment();

        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->remove('status');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('img')->getData();
            if ($image) {
                $brochureFileName = $fileUploader->upload($image);
                $equipment->setImg($brochureFileName);
            }

            $equipment = $form->getData();
            $this->manager->persist($equipment);
            $this->manager->flush();
            $this->addFlash('notice', 'New equipment was added');
            return $this->redirectToRoute('admin_equipment_index');
        }

        return $this->render('admin/equipment/new.html.twig', [
            'form' => $form
        ]);

    }

    #[Route('/show/{equipment}', name: 'admin_equipment_show', methods:['GET'])]
    public function show(Equipment $equipment): Response
    {
        return $this->render('admin/equipment/show.html.twig', [
            'equipment' => $equipment
        ]);
    }

    #[Route('/edit/{equipment}', name: 'admin_equipment_edit', methods:['GET', 'POST'])]
    public function edit(Equipment $equipment, Request $request): Response
    {
        $directory = $this->getParameter('equipment_directory');
        $img = new File($directory.DIRECTORY_SEPARATOR.$equipment->getImg());
        $equipment->setImg(
            $img
        );

        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $equipment = $form->getData();
            $this->manager->flush();
            $this->addFlash('notice', 'Equipment was edited');
            return $this->redirectToRoute('admin_equipment_show', ['equipment' => $equipment->getId()]);
        }

        return $this->render('admin/equipment/new.html.twig', [
            'form' => $form,
            'img' => $img
        ]);
    }




}
