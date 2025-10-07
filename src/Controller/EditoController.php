<?php

namespace App\Controller;

use App\Entity\Edito;
use App\Entity\EditoImage;
use App\Form\EditoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/edito')]
class EditoController extends AbstractController
{
    #[Route('/', name: 'edito_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $editos = $em->getRepository(Edito::class)->findBy([], ['id' => 'DESC']);

        return $this->render('edito/index.html.twig', [
            'editos' => $editos,
        ]);
    }

    #[Route('/new', name: 'edito_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $edito = new Edito();
        $form = $this->createForm(EditoType::class, $edito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 🔹 Photo principale
            $photoFile = $form->get('photoPrincipale')->getData();
            if ($photoFile) {
                $nouveauNom = uniqid('edito_') . '.' . $photoFile->guessExtension();
                $photoFile->move($this->getParameter('edito_directory'), $nouveauNom);
                $edito->setPhotoPrincipale($nouveauNom);
            }

            // 🔹 Images associées
            foreach ($form->get('images') as $imageForm) {
                /** @var UploadedFile|null $imageFile */
                $imageFile = $imageForm->get('fichier')->getData();
                if ($imageFile) {
                    $nouveauNom = uniqid('galerie_') . '.' . $imageFile->guessExtension();
                    $imageFile->move($this->getParameter('edito_directory'), $nouveauNom);

                    /** @var \App\Entity\EditoImage $image */
                    $image = $imageForm->getData();
                    $image->setFichier($nouveauNom);
                    $image->setEdito($edito); // sécurité

                    $em->persist($image);
                }
            }

            $em->persist($edito);
            $em->flush();

            $this->addFlash('success', 'Édito créé avec succès !');

            return $this->redirectToRoute('edito_show', ['id' => $edito->getId()]);
        }


        return $this->render('edito/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'edito_show')]
    public function show(Edito $edito): Response
    {
        return $this->render('edito/show.html.twig', [
            'edito' => $edito,
        ]);
    }

}
