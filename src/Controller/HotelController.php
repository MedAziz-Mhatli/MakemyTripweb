<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\ReadType;
use App\Repository\HotelRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="app_hotel")
     */
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }

    /**
     * @Route("/read", name="read")
     */
    public function read(){
        $liste=$this->getDoctrine()
            ->getRepository(Hotel::class)->findAll();
        return $this->render('hotel/read.html.twig',['tab'=>$liste]);

    }

    /**
     * @Route("/readfront", name="readfront")
     */
    public function readfront(){
        $liste=$this->getDoctrine()
            ->getRepository(Hotel::class)->findAll();
        return $this->render('frontapp/readf.html.twig', ['ta'=>$liste]);

    }
    /**
     * @Route("/delete/{id}",name="delete")
     */
    public function delete($id){
        $objSupp=$this->getDoctrine()->getRepository(Hotel::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($objSupp);
        $em->flush();
        return $this->redirectToRoute('read');
    }
    /**
     * @param Request $request
     * @Route("/create",name="create")
     * @return Response
     */
    public function create(Request $request)
    {
        $hotel=new Hotel();

        $form=$this->
        createForm(ReadType::class,$hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& ($form->isValid()))
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();
            return $this->redirectToRoute('read');}
        else
        {
            return
            $this->render('hotel/create.html.twig', ['f'=>$form->createView()]);
        }

    }
    /**
     * @Route("/update/{id}",name="modifier")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function update($id, Request $request)
    {$objModif=$this->getDoctrine()
        ->getRepository(Hotel::class)
        ->find($id);
        $form=$this->createForm
        (ReadType::class,$objModif);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid())
        {$em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('read');}
        else
        { return
            $this->render
            ('hotel/update.html.twig',
                ['f'=>$form->createView()]);}


    }

    /**
     * @Route("/stat",name="stat")
     */
    public function statistique(HotelRepository $hotelRepo){
        $hotels=$hotelRepo->findAll();
         $hotelNom = [];
         $hotelNbCh = [];

         foreach ($hotels as $hotel)
         {
             $hotelNom[]= $hotel->getNom();
             $hotelNbCh[]= $hotel->getNbChdispo();
         }
      return  $this->render('hotel/stat.html.twig',
      [
          'hotelNom' => json_encode($hotelNom),
          'hotelNbCh' => json_encode($hotelNbCh)

      ]);
    }

    /**
     * @Route("/chat", name="chat")
     */
    public function chat(): Response
    {
        return $this->render('frontapp/chatbot.html.twig', [
            'chatb' => 'HotelController',
        ]);
    }

    /**
     * @param HotelRepository $repository
     * @param Request $request
     * @return JsonResponse
     *  @Route ("/rating",name="rating")
     */
    public function rating(HotelRepository $repository, Request $request)
    {

        $id=$request->request->get('idd');
        // $rating=$_GET['note'];
        $classroomm = new Hotel();
        $classroom = $repository->find($id);



        $rating =$request->request->get('notee');

        $classroom->setRate($rating);
        $em = $this->getDoctrine()->getManager();
        $em->persist($classroom);
        $em->flush();


        return new JsonResponse(array('operation'=>'success'));


    }


    /**
     * @Route("/affEvenement", name="affEvenement")
     */
    public function afftEvenement(Request $request, PaginatorInterface $paginator)
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees= $this->getDoctrine()->getRepository(Hotel::class)->findAll();
        $liste= $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('frontapp/readf.html.twig', ["ta"=>$liste]);
    }
    /**
     * @Route("/listH", name="listH", methods={"GET"})
     */
    public function listH(HotelRepository $res) :Response
    {


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $reader=$res->findAll();


        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('frontapp/pdf.html.twig', array(
            'reader'=>$reader
        ));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste Des Hoteles.pdf", [
            "Attachment" => true
        ]);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");

    }


}
