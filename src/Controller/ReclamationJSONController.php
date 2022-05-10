<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Reclamation;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/reclamationn")
 */

class ReclamationJSONController extends AbstractController
{
    /**
     * @Route("/allReclamations", name="app_reclamation_allReclamations")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $reclamations = $this->getDoctrine()->getManager()
            ->getRepository(Reclamation::class)
            ->findAll();

       // dd($reclamations);
        $jsonContent=$normalizer->normalize($reclamations,'json',['groups'=>'reclamation']);
        //$jsonc=json_encode($jsonContent);
        return new JsonResponse($jsonContent);

    }

    /**
     * @Route("/ReclamationOne", name="app_reclamation_oneReclamations")
     */
    public function indexOne(NormalizerInterface $normalizer,Request $request): Response
    {

        $user=$this->getDoctrine()->getManager()
            ->getRepository(Client::class)->find($request->get('iduser'));

        $reclamations = $this->getDoctrine()->getManager()
            ->getRepository(Reclamation::class)
            ->findBy([
                'Client' => $user,
            ]);

        // dd($reclamations);
        $jsonContent=$normalizer->normalize($reclamations,'json',['groups'=>'reclamation']);
        //$jsonc=json_encode($jsonContent);
        return new JsonResponse($jsonContent);

    }
    /**
     * @Route("/detailReclamation", name="detail_reclamation")
     */

    public function detailReclamation(Request $request)
    {
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $encoder= new JsonEncoder();
        $normalizer=new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object){
            return $object->getDescription;
        });
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);

        return new JsonResponse($formatted);


    }

    /**
     * @Route("/addReclamationn", name="add_reclamation")
     */

    public function ajouterReclamationAction(Request $request){

        $reclamation = new Reclamation();


        //$x = $jsonContent->getContent();


        $em = $this->getDoctrine()->getManager();
        $reclamation->setDateReclamation(new \DateTime('now'));
        $reclamation->setEmailReclamation($request->get("email"));
        $reclamation->setDesriptionReclamation($request->get("description"));
        $reclamation->setEtatReclamation('non traite');
        $reclamation->setNomuser($request->get("nomuser"));

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation,"json",['groups'=>'reclamation']);
        return new JsonResponse($formatted);
    }



    /**
     * @Route("/deleteReclamation", name="delete_reclamation", methods={"DELETE"})
     */

    public function deleteReclamationAction(Request $request){

        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);

        if ($reclamation != null) {
            $em->remove($reclamation);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formated = $serializer->normalize("Reclamation  supprimee avec succees ");
            return new JsonResponse($formated);
        }
        return new JsonResponse("id Reclamation est invalide !");
    }


    /**
     * @Route("/updateReclamation", name="update_reclamation")
     */

    public function modifierReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(Reclamation::class)
            ->find($request->get("id"));


        $rest=substr($request->get('daterec'), 0, 20);
        $rest1=substr($request->get('daterec'), 30, 34);
        $res=$rest.$rest1;
        try {
            $date = new \DateTime($res);
            $reclamation->setDateReclamation($date);
        } catch (\Exception $e) {

        }
        $reclamation->setEmailReclamation($request->get("email"));
        $reclamation->setDesriptionReclamation($request->get("description"));
        $reclamation->setEtatReclamation($request->get("etat"));
        $reclamation->setNomUser($request->get("nom"));

        $em->persist($reclamation);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse("Reclamation a ete modifiee avec success.");

    }
    /**
     * @Route("/del", name="delmoboffre")
     */
    public function delmoboffre(Request $request,NormalizerInterface $normalizer)
    {           $em=$this->getDoctrine()->getManager();
        $rec=$this->getDoctrine()->getRepository(Reclamation::class)
            ->find($request->get('id'));
        $em->remove($rec);
        $em->flush();
        $jsonContent = $normalizer->normalize($rec,'json',['reclamation'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

}
