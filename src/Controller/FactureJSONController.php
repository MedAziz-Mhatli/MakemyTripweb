<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/facture")
 */

class FactureJSONController extends AbstractController
{
    /**
     * @Route("/allFactures", name="app_facture_json")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $factures = $this->getDoctrine()->getManager()
            ->getRepository(Facture::class)
            ->findAll();

        // dd($reclamations);
        $jsonContent=$normalizer->normalize($factures,'json',['groups'=>'facture']);

        return new JsonResponse($jsonContent);

    }

    /**
     * @Route("/detailFacture", name="detail_facture")
     */

    public function detailFacture(Request $request)
    {
        $id=$request->get("idf");
        $em=$this->getDoctrine()->getManager();
        $facture=$em->getRepository(Facture::class)->find($id);
        $encoder= new JsonEncoder();
        $normalizer=new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object){
            return $object->getDescription;
        });
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($facture);

        return new JsonResponse($formatted);


    }


    /**
     * @Route("/addFacture", name="add_facture", methods={"POST"})
     */

    public function ajouterFactureAction(Request $request){

        $facture = new Facture();
        $dateFacture = new \DateTime($request->get("date"));
        $remiseFacture= $request->get("remise");
        $totalFacture = $request->get("total");
        $typeFature = $request->query->get("type");



        $em = $this->getDoctrine()->getManager();
        $facture->setDateFacture($dateFacture);
        $facture->setRemiseFacture($remiseFacture);
        $facture->setTotalFacture($totalFacture);
        $facture->setTypeFature($typeFature);

        $em->persist($facture);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($facture,"json",['groups'=>'facture']);
        return new JsonResponse($formatted);
    }



    /**
     * @Route("/updateFacture", name="update_facture")
     */

    public function modifierFactureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $this->getDoctrine()->getManager()
            ->getRepository(Facture::class)
            ->find($request->get("id"));
        $rest=substr($request->get('datefac'), 0, 20);
        $rest1=substr($request->get('datefac'), 30, 34);
        $res=$rest.$rest1;
        try {
            $date = new \DateTime($res);
            $facture->setDateFacture($date);
        } catch (\Exception $e) {

        }



        //$facture->setDateFacture($request->get("date"));
        $facture->setRemiseFacture($request->get("remise"));
        $facture->setTotalFacture($request->get("total"));
        $facture->setTypeFature($request->get("type"));

        $em->persist($facture);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($facture);
        return new JsonResponse("Facture a ete modifiee avec success.");

    }



    /**
     * @Route("/delFacture", name="del_facture")
     */
    public function delFacture(Request $request,NormalizerInterface $normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $facture=$this->getDoctrine()->getRepository(Facture::class)
            ->find($request->get('idF'));
        $em->remove($facture);
        $em->flush();
        $jsonContent = $normalizer->normalize($facture,'json',['facture'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }
}
