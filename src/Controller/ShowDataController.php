<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Signature;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class ShowDataController extends AbstractController
{
    public function __invoke(ManagerRegistry $doctrine): Response
    {
        $signatureRepository = $doctrine->getRepository(Signature::class);
        $signatures = $signatureRepository->findAll();

        return $this->render('dataPage.html.twig',[
            'signatures' => $signatures
        ]);
    }
}
