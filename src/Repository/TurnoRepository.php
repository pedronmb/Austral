<?php

namespace App\Repository;

use App\Entity\Turno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TurnoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Turno::class);
    }
    
    
    public function obtener_turno($id_cola){
        
        //$doctrine = $this->getDoctrine();
        //$em = $doctrine->getManager();
        //$turno_repo = $em->getRepository(turno::class);
        
        
        //busca la cantidad de registros para entregarle el numero en la cola
        $turno = $this->findBy([
            'idCola' => $id_cola
        ]);
        
        $cantidad = count($turno);
        if($cantidad == 0){
            //$response->setStatusCode(Response::HTTP_NOT_FOUND);
        }else{
            //Guarda registro
            //$entityManager = $this->getDoctrine()->getManager();
        
            $turno = new Turno();
            $turno->setIdCola($id_cola);
            $turno->setEstado(true);
            $turno->setNumero($cantidad+1);
            //$jsonTurno = json_encode($turno);
            $this->persist($turno);
        
            $this->flush();
            
            //encondeado a json de la respuesta
            /*$encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($turno, 'json');*/

            
            //$response->setContent($jsonContent);
            return $turno;
        }
    }
   
}
