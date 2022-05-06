<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;

/**
 * @Route("/facturetemplate")
 */
class FacturetemplateController extends AbstractController
{

    public function __construct(BuilderInterface $customQrCodeBuilder)
    {
        $result = $customQrCodeBuilder
            ->size(400)
            ->margin(20)
            ->build();
    }

    /**
     * @Route("/", name="facturetemplate_index", methods={"GET"})
     */

    public function index(EntityManagerInterface $entityManager,Request $request, PaginatorInterface $paginator,FlashyNotifier $flashy): Response
    {

            $flashy->success('Event created!', 'http://your-awesome-link.com');
        $factures = $entityManager
            ->getRepository(Facture::class)
            ->findAll();

        $factures = $paginator->paginate(
            $factures,
            $request->query->getInt('page',1),
            6
        );

        /*
        $user = $this->getDoctrine()->getManager()->getRepository(Client::class)->find(1);
        $factures = $entityManager
            ->getRepository(Facture::class)
            ->findBy([
                'Client'=> $user
            ]);
    */
        $totalVol =0;
        $totalChambre =0;
        $totatVehicule =0;
        foreach($factures as $facture){
            if($facture->getTypeFature()=="Vol")
            {
                $totalVol=$totalVol+$facture->getTotalFacture();
            }
            elseif ($facture->getTypeFature()=="Chambre")
            {
                $totalChambre=$totalChambre+$facture->getTotalFacture();
            }
            elseif ($facture->getTypeFature()=="vehicule")
            {
                $totatVehicule=$totatVehicule+$facture->getTotalFacture();

            }

            //$response = new QrCodeResponse($result);

        }

        return $this->render('facturetemplate/affichage.html.twig', [
            'factures' => $factures,
            'totalVol' => $totalVol,
            'totalChambre' => $totalChambre,
            'totatVehicule' => $totatVehicule,
        ]);
    }



    /**
     * @Route("/new", name="facturetemplate_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FlashyNotifier $flashy,EntityManagerInterface $entityManager,FactureRepository $repository): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $res = $facture->getRemiseFacture()/100;
            $y = $facture->getTotalFacture() * $res ;
            $facture->setTotalFacture($facture->getTotalFacture()-$y);

            $entityManager->persist($facture);
            $entityManager->flush();
            $this->addFlash('success', 'Article Created! Knowledge is power!');
           // $flashy->success('Event created!', 'http://your-awesome-link.com');

            return $this->redirectToRoute('facturetemplate_index', ['notif' => true], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Facture $facture,TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $message= $translator->trans('Reclamation modified succes');
            $this->addFlash('message',$message);
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
    public function Tri(Request $request, FactureRepository $repository): Response
    {

        // Retrieve the entity manager of Doctrine
        $order = $request->get('type');
        if ($order == "Croissant") {
            $factures = $repository->tri_asc();
        } else {
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
    public function recherche(Request $request, FactureRepository $factureRepository)
    {
        $data = $request->get('data');
        $facture = $factureRepository->recherche($data);
        return $this->render('facturetemplate/calendar.html.twig', [
            'factures' =>  $facture,


        ]);
    }




    /**
     * @Route("/r/search_recc", name="search_recc", methods={"GET"})
     */
    public function search_rec(Request $request, NormalizerInterface $Normalizer, FactureRepository $FactureRepository): Response
    {

        $requestString = $request->get('searchValue');
        $requestString2 =$request->get('searchValue2');
        $requestString3 = $request->get('orderid');


        $reclamations = $FactureRepository->findFacture($requestString,$requestString2, $requestString3);
        $jsoncontentc = $Normalizer->normalize($reclamations, 'json', ['groups' => 'posts:read']);
        $jsonc = json_encode($jsoncontentc);
        if ($jsonc == "[]") {
            return new Response(null);
        } else {
            return new Response($jsonc);
        }
    }




    public function getData()
    {
        /**
         * @var $Reclamation rec[]
         */
        $list = [];
        // $reclam = $this->entityManager->getRepository(Reclamation::class)->findAll();
        $reclam = $this->getDoctrine()->getRepository(Facture::class)->findAll();

        foreach ($reclam as $rec) {
            $list[] = [
                $rec->getDateFacture(),
                $rec->getRemiseFacture(),
                $rec->getTotalFacture(),
                $rec->getTypeFature(),

            ];
        }
        return $list;
    }




    /**
     * @Route("/excel/export",  name="export")
     */
    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Reclamation List');

        $sheet->getCell('A1')->setValue('dateFacture');
        $sheet->getCell('B1')->setValue('remiseFacture');
        $sheet->getCell('C1')->setValue('totalFacture');
        $sheet->getCell('D1')->setValue('typeFature');

        // Increase row cursor after header write
        $sheet->fromArray($this->getData(), null, 'A2', true);
        $writer = new Xlsx($spreadsheet);
        // $writer->save('ss.xlsx');
        $writer->save('Reclam' . date('m-d-Y_his') . '.xlsx');
        return $this->redirectToRoute('facturetemplate_index');
    }


    /**
     * @Route("/pdf/{idFacture}", name="facturetemplate_pdf")
     */
    public function PDF(int $idFacture, FactureRepository $f)
    {
        //on definit les option du pdf
        $pdfOptions = new Options();
        //police par defaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $facture =$f->findFacture1($idFacture);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facturetemplate/pdf.html.twig', [

            'facture' => $facture
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);



        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'paysage');

        // Render the HTML as PDF
        $dompdf->render();



        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("facture.pdf", [
            "Attachment" => false
        ]);
        return new Response();
    }
}
