<?php

namespace App\Controller;

use App\Entity\CGU;
use App\Entity\Edito;
use App\Entity\Utilisateur;
use App\Form\ParametreType;
use App\Repository\CGURepository;
use App\Repository\DetailConversationRepository;
use App\Repository\EditoRepository;
use App\Repository\ParametreRepository;

//use App\Repository\SliderRepository;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(EditoRepository $editoRepository,SliderRepository $sliderRepository): Response
    {
        $edito=new Edito();
        $editos=$editoRepository->findPublishedTodayOrLater();
        $sliders=$sliderRepository->findAll();


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'editos' => $editos,
            'sliders' => $sliders,
        ]);
    }

    /*#[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, ParametreRepository $parametreRepository, MailerInterface $mailer, RateLimiterFactory $registrationLimiter): Response
    {

        $param = $parametreRepository->findOneBy(['id' => 1]);
        $contact = $param?->getContactEmail();

        if (!$contact) {
            throw $this->createNotFoundException('Paramètre non trouvé');
        }

        $formData = []; // Stockage des données saisies

        if ($request->isMethod('POST')) {
            // Récupération des données du formulaire
            $formData = [
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'subject' => $request->request->get('subject'),
                'message' => $request->request->get('message'),
            ];

            // Gestion du CAPTCHA
            $recaptchaResponse = $request->request->get('g-recaptcha-response');
            if (!$recaptchaResponse) {
                $this->addFlash('danger', 'Veuillez cocher le CAPTCHA.');
                return $this->render('main/contact.html.twig', [
                    'parametre' => $param,
                    'formData' => $formData, // On renvoie les valeurs déjà saisies
                    'recaptcha_site_key' => $_ENV['RECAPTCHA_SITE_KEY'],
                ]);
            }
            // vérif
            $client = HttpClient::create();
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'body' => [
                    'secret' => '6Ld_o_kqAAAAADgPstM6fO18dWyGNP2pwYpNoQnW',
                    'response' => $recaptchaResponse,

                ]
            ]);
            $data = $response->toArray();

            if (!$data['success']) {
                throw new \Exception('Vérification du CAPTCHA échouée.');
            }

            // Logique d'envoi d'email
            $emailMessage = (new Email())
                ->from($formData['email'])
                ->to($contact)
                ->subject($formData['subject'])
                ->text("Nom: {$formData['name']}\nEmail: {$formData['email']}\n\nMessage:\n{$formData['message']}");

            try {
                $mailer->send($emailMessage);
                $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de votre message.');
            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('main/contact.html.twig', [
            'parametre' => $param,
            'formData' => $formData, // On envoie les valeurs, même vides au premier affichage
            'recaptcha_site_key' => $_ENV['RECAPTCHA_SITE_KEY'],
        ]);
    }

*/

}
