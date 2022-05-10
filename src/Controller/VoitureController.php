<?php

namespace App\Controller;

use App\api\MailerApi;
use App\api\TwilioApi;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Mailer\MailerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/voiture")
 */
class VoitureController extends AbstractController
{
    /**
     * @Route("/", name="app_voiture_index", methods={"GET"})
     */
    public function index(VoitureRepository $voitureRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Voiture::class)->findBy([],['prix' => 'asc']);

        $voiture = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page

        );

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voiture
        ]);
    }


    /**
     * @Route("/statistiques", name="statistiques")
     */
    public function stats(): Response
    {
        return $this->render('Voiture/Statistique.html.twig');

    }


    /**
     *
     * @Route("/statistiques/marque", name="type_statistiques")
     */
    public function type_stats(VoitureRepository $VoitureRepos): JsonResponse
    {
        $clio = 0;
        $citroen = 0;
        $audi = 0;
        $voiture = $VoitureRepos->findAll();
        foreach ($voiture as $item) {
            if (strcmp(strtolower($item->getMarque()), "clio") == 0) $clio++;
            if (strcmp(strtolower($item->getMarque()), "citroen") == 0) $citroen++;
            if (strcmp(strtolower($item->getMarque()), "audi") == 0) $citroen++;
        }
        $data = array("clio" => $clio, "citroen" => $citroen, "audi" => $citroen);
        return new JsonResponse($data);
    }




    /**
     * @Route("/new", name="app_voiture_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VoitureRepository $voitureRepository,MailerInterface $mailer,FlashyNotifier $flashy): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voitureRepository->add($voiture);

            $email = new MailerApi();
            $twilio = new TwilioApi('ACb2983d38243faf53a2feff8577791bb6','cf7eb799bc39d4083eedd7cd80931e75','+12393635138');
            $twilio->sendSMS('+21653763599','Voiture Créer avec success');
            $email->sendEmail( $mailer,'testapimail63@gmail.com','abir.benkhalifa@esprit.tn','testing email','Voiture Créer avec success');
            $this->addFlash(
                'info' ,' Moyen de Transport ajoute !');

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="app_voiture_show", methods={"GET"})
     */
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_voiture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voiture $voiture, VoitureRepository $voitureRepository): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voitureRepository->add($voiture);
            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_voiture_delete", methods={"POST"})
     */
    public function delete(Request $request, Voiture $voiture, VoitureRepository $voitureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $voitureRepository->remove($voiture);
        }

        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }

}
