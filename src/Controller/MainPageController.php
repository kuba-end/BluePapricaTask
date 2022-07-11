<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Signature;
use App\Form\Type\SignatureFormType;
use App\Message\SignatureMessage;
use App\Uploader\ImageUploaderInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class MainPageController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private ImageUploaderInterface $fileUploader;

    private MessageBusInterface $bus;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImageUploaderInterface $fileUploader,
        MessageBusInterface $bus
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        $signature = new Signature();
        $form = $this->createForm(SignatureFormType::class, $signature);
        $form->handleRequest($request);
        $context = [
            'user_ip' => $request->getClientIp(),
            'referrer' => $request->headers->get('referer'),
            'permalink' => $request->getUri(),
        ];

        if ($form->isSubmitted() && $form->isValid()) {
            $signature->setName($form->get('name')->getData());
            $signature->setSurname($form->get('surname')->getData());
            $attachment = $form->get('attachment')->getData();

            if ($attachment) {
                $fileName = $this->fileUploader->upload($attachment);
                $signature->setAttachment($fileName);
            }

            try {
                $this->entityManager->persist($signature);
                $this->entityManager->flush();
            } catch (Exception $e) {
                $this->addFlash('error', 'Something went wrong. Try again.');
            }
            $this->bus->dispatch(new SignatureMessage($signature->getId(), $context));

            $this->addFlash('success', 'Your data has been successfully saved');

            return $this->redirectToRoute('app_main_page');
        }

        return $this->renderForm('mainPage.html.twig', [
            'signature' => $form,
        ]);
    }
}
