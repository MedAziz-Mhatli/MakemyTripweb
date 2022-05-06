<?php

namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Serializer;
use PHPUnit\Util\Json;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Entity\Facture;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use App\Entity\RatingRec;
use App\Entity\Reclamation;
use App\Form\RatingrecType;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
//use \Statickidz\GoogleTranslate;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Translation\TranslatorInterface;


/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{

    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
        $ratings = $this->getDoctrine()->getRepository(RatingRec::class)->findAll();
        $nt=0;
        $t=0;
        $count = count($reclamations);
        foreach ($reclamations as $r)
        {
            if($r->getEtatReclamation()=="non traite")
                $nt+=1;
            if($r->getEtatReclamation()=="traite")
                $t+=1;
        }

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'ratings' => $ratings,
            'count'=>$count,
            'nt'=>$nt,
            't'=>$t,


        ]);
    }







    /**
     * @Route("/new", name="reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $rating = new RatingRec();
        $form = $this->createForm(ReclamationType::class, $reclamation);

        $form->handleRequest($request);

        if ( $form->isSubmitted()  && $form->isValid()) {
            $tr = new GoogleTranslate('fr');
            $text = $tr->translate($reclamation->getDesriptionReclamation());
            echo $tr->getLastDetectedSource();
            $reclamation->setDateReclamation(new \DateTime('now'));
            $reclamation->setEtatReclamation(('non traite'));
            $reclamation->setDesriptionReclamation($this->filterwords($text));
            //$reclamation->setDesriptionReclamation($text);
            //$reclamation->setNomUser("aziz");

            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/contact-us.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),

        ]);
    }



    /**
     * @Route("/newR/{id}", name="reclamation_new_rating", methods={"GET", "POST"})
     */
    public function newR(Request $request,$id, EntityManagerInterface $entityManager): Response
    {

        $rating = new RatingRec();
        $form = $this->createForm(RatingrecType::class, $rating);

        $form->handleRequest($request);

        if ( $form->isSubmitted()  && $form->isValid()) {
            $reclamation = $entityManager
                ->getRepository(Reclamation::class)
                ->find($id);
            $rating->setIdrec($reclamation);

            $entityManager->persist($rating);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/rate-us.html.twig', [
            'rating' => $rating,
            'form' => $form->createView(),

        ]);
    }

    function traduction($text) {
        $source = 'fr';
        $target= 'en';
        $trans= new GoogleTranslate();
        $result = $trans->translate($source,$target,$text);
        echo $result;
        return $result;


    }
    function filterwords($text)
    {
        $filterWords = array('fuck', 'pute', 'bitch','hate','haine','putain');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function ($matches) {
                return str_repeat('*', strlen($matches[0]));
            }, $text);
        }
        return $text;
    }

    /**
     * @Route("/{idReclamation}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {

        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,

        ]);
    }

    /**
     * @Route("/{idReclamation}/edit", name="reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idReclamation}/traite", name="reclamation_traite", methods={"GET", "POST"})
     */
    public function traiteReclam(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $reclamation->setEtatReclamation(('traite'));
        $entityManager->flush();

        return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/{idReclamation}", name="reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getIdReclamation(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
    }





    /**
     * @Route("/r/search_rec", name="search_rec", methods={"GET"})
     */
    public function search_rec(Request $request, NormalizerInterface $Normalizer, ReclamationRepository $reclamationRepository): Response
    {

        $requestString = $request->get('searchValue');
        $requestString2 =$request->get('searchValue2');
        $requestString3 = $request->get('orderid');

        $reclamations = $reclamationRepository->findReclamations($requestString,$requestString2 , $requestString3);
        $jsoncontentc = $Normalizer->normalize($reclamations, 'json', ['groups' => 'posts:read']);
        $jsonc = json_encode($jsoncontentc);
        if ($jsonc == "[]") {
            return new Response(null);
        } else {
            return new Response($jsonc);
        }
    }

    /**
     * @Route("/r/reclamation_stat", name="reclamation_stat")
     */
    public function reclamation_stat(): Response
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $data= array();
        $stat=['Les Reclamations', '%'];
        array_push($data,$stat);

        $e1 = $em->getRepository(Reclamation::class)->findBy(array('etatReclamation'=>"traite"));
        $total=count($e1);
        $stat=["traite",$total];
        array_push($data,$stat);
        $stat=array();
        $e2 = $em->getRepository(Reclamation::class)->findBy(array('etatReclamation'=>"non traite"));
        $total=count($e2);
        $stat=["non traite",$total];
        array_push($data,$stat);
        $pieChart->getData()->setArrayToDataTable(
            $data
        );

        $pieChart->getOptions()->setTitle('Les Reclamations');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        /*
        $e2 = $reclamationRepository->find_Nb_Rec_Par_Status("non traite");

        $nbrs[] = array();

        $e1 = $reclamationRepository->find_Nb_Rec_Par_Status("traite");
        dump($e1);
        $nbrs[] = $e1[0][1];
        $e2 = $reclamationRepository->find_Nb_Rec_Par_Status("non traite");
        dump($e2);
        $nbrs[] = $e2[0][1];

        dump($nbrs);
        reset($nbrs);
       // dump(reset($nbrs));
        $key = key($nbrs);
        dump($key);
        dump($nbrs[$key]);

        unset($nbrs[$key]);

        $nbrss = array_values($nbrs);
        dump(json_encode($nbrss));
        */
        return $this->render('reclamation/stat.html.twig', [
            'piechart' => $pieChart
        ]);
    }


    /**
     * @Route("/reclamation/pdf", name="pdf0",methods={"GET"} )
     */
    public function pdf(Request $request)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $repository = $this->getdoctrine()->getrepository(Reclamation::class);
        $allCoch = $repository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reclamation/pdf.html.twig', [
            'title' => "Welcome to our PDF Test", 'Reclamation' => $allCoch,
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();

     //   $writer->save('Reclam' . date('m-d-Y_his') . '.xlsx');
        // Output the generated PDF to Browser (force download)
        $dompdf->stream("reclamationpdf.pdf", [
            "Attachment" => true
        ]);
    }







    public function findAction($idReclamation){
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($idReclamation);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);

    }






}
