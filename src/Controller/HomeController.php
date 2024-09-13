<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\RentAddOnsDto;
use App\Entity\Rent;
use App\Factory\Rent\FinalPriceDecoratorFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private FinalPriceDecoratorFactory $rentFactory)
    {
    }


    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('base.html.twig');

    }
}
