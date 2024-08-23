<?php

namespace App\Controller\Admin;

use App\Entity\Rent;
use App\Form\RentType;
use App\Service\DiscountRentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/rent')]
class RentController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {

    }

    #[Route('/', name: 'admin_rent_index', methods: ['GET'])]
    public function index(): Response
    {
        $repository = $this->manager->getRepository(Rent::class);

        return $this->render('admin/rent/index.html.twig', [
            'rents' =>  $repository->findAll(),
        ]);
    }


    #[Route('/create', name:'admin_rent_create', methods: ['GET', 'POST'])]
    public function create(Request $request, DiscountRentService $discountRentService): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            try {
                $rent = $form->getData();
                $discountRentService->calculateDiscount($rent);
                //TODO REPOSITORY
                $this->manager->persist($rent);
                $this->manager->flush();
                $this->addFlash('notice', 'New rent was added');

                return $this->redirectToRoute('admin_rent_index');
            } catch (\Exception $e) {
                $this->addFlash('error', "An error occurred while creating the rent: {$e->getMessage()}");
            }
        }

        return $this->render('admin/rent/new.html.twig', [
            'form' => $form
        ]);

    }
}
