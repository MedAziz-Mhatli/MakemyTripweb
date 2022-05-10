<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Form\VolType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/admin/Vol")
 */
class AdminVolController extends AbstractController

{
    /**
     * @Route("/", name="admin_Vol")
     */
    public function index(VolRepository $repository): Response
    {
        return $this->render('adminVol/index.html.twig', [
            'Vols' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="admin_Vol_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em, Vol $Vol = null): Response
    {
        if (!$Vol) {
            $Vol = new Vol();
        }
        $form = $this->createForm(VolType::class, $Vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($Vol);
            $em->flush();
            return $this->redirectToRoute('admin_Vol');
        }
        return $this->render('adminVol/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/edit/{id}", name="admin_Vol_edit", methods={"GET", "POST"})
     */
    public function edit(VolRepository $VolRepository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $Vol = $VolRepository->find($id);
        $form = $this->createForm(VolType::class, $Vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Vol);
            $em->flush();
            return $this->redirectToRoute('admin_Vol');
        }
        return $this->render('adminVol/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_Vol_delete")
     */
    public function delete(VolRepository $VolRepository, $id, Request $request, EntityManagerInterface $em): Response
    {
        $VolRepository = $VolRepository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($VolRepository);
        $em->flush();
        return $this->redirectToRoute('admin_Vol', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/mypdf", name="app_mypdf", methods={"GET"})
     */
    public function mypdf(VolRepository $VolRepository): Response
    {


        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $Vols = $VolRepository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('adminVol/mypdf.html.twig', [
            'Vols' => $Vols,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Vol.pdf", [
            "Attachment" => true
            //false in case t7eb t7elha al browser
        ]);


    }


}