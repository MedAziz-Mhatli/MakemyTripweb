<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/facturetemplate")
 */
class FacturetemplateController extends AbstractController
{
    /**
     * @Route("/", name="facturetemplate_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $factures = $entityManager
            ->getRepository(Facture::class)
            ->findAll();

        return $this->render('facturetemplate/affichage.html.twig', [
            'factures' => $factures,
        ]);
    }

    /**
     * @Route("/new", name="facturetemplate_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facturetemplate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facturetemplate/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idFacture}", name="facturetemplate_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facturetemplate/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{idFacture}/edit", name="facturetemplate_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('facturetemplate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facturetemplate/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idFacture}", name="facturetemplate_delete", methods={"POST"})
     */
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $facture->getIdFacture(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facturetemplate_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/tri" , name="facture_tri" , methods={"GET"})
     *
     */
        public function Tri(Request $request,FactureRepository $repository):Response {

            // Retrieve the entity manager of Doctrine
            $order=$request->get('type');
            if($order== "Croissant"){
                $factures = $repository->tri_asc();
            }
            else {
                $factures = $repository->tri_desc();
            }
            // Render the twig view
            return $this->render('facturetemplate_index', [
                'factures' => $factures
            ]);

        }


        /**
        *@Route("/recherche", name="facture_search", methods={"GET"})

        */
        public function recherche(Request $request, FactureRepository $factureRepository){
            $data=$request->get('data');
            $facture=$factureRepository->recherche($data);
                return $this->render('facturetemplate/index.html.twig', [
                    'factures' =>  $facture,


    ]);


}








    /**
     * @Route("/hotel/pdf", name="pdf0",methods={"GET"} )
     */
    /*public function pdf(Request $request)
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $repository = $this->getdoctrine()->getrepository(Facture::class);
        $allCoch = $repository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facturetemplate/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'Facture' => $allCoch,
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A1', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }*/
}
