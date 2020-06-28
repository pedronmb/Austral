<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Turno;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ApiController extends AbstractController
{
        
    public function sacar_turno($id_cola){
        $response = new Response();

        
        
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $turno_repo = $em->getRepository(turno::class);
        
        
        //busca la cantidad de registros para entregarle el numero en la cola
        $turno = $turno_repo->findBy([
            'idCola' => $id_cola
        ]);
        
        $cantidad = count($turno);
        if($cantidad == 0){
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }else{
            //Guarda registro
            $entityManager = $this->getDoctrine()->getManager();
        
            $turno = new Turno();
            $turno->setIdCola($id_cola);
            $turno->setEstado(true);
            $turno->setNumero($cantidad+1);
            //$jsonTurno = json_encode($turno);
            $entityManager->persist($turno);
        
            $entityManager->flush();
            
            //encondeado a json de la respuesta
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($turno, 'json');

            
            $response->setContent($jsonContent);
        }
        
        
        
        
        
        
        return $response;
    }
    
    public function atender_proximo(){
        $response = new Response();

        $doctrine = $this->getDoctrine();
        
        $em = $doctrine->getManager();
        
        $turno_repo = $em->getRepository(turno::class);
        
        $turno = $turno_repo->findOneBy([
            'estado' => true
        ],[
             'id' => 'ASC'
        ]);
        
        if(!$turno){
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }else{
            $turno->setEstado(false);
            
            $em->persist($turno);
            
            $em->flush();
            
            //$message = 'se actualizo correctamente'.$turno->getId();
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($turno, 'json');

            $response->setContent($jsonContent);
        }
        return $response;
        //return new Response($message);
    }
}
