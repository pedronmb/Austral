<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Turno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;



class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request)
    {
        $cantidad = 0;
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://api.weatherstack.com/current?access_key=f688668c996b9e789f9956eb70499d3f&query=Buenos Aires');
        
        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        if (200 !== $response->getStatusCode()) {
        // handle the HTTP request error (e.g. retry the request)
        } else {
            $content = $response->toArray();
            $current = $content['current'];
            $location = $content['location'];
        }
        
        
        
        $response = new Response();
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $turno_repo = $em->getRepository(turno::class);
        
        //busqueda en la base de datos de los diferetes turnos
        $turnosTotales = $turno_repo->findAll();
        
        $turnosNoAtendidos = $turno_repo->findBy([
            'estado' => 1
        ]);
        
        $turnosAtendidos = $turno_repo->findBy([
            'estado' => 0
        ]);
        
        //obtencion de la cantidad de turnos por cada categoria
        $cTurnosTotales = count($turnosTotales);
        $cTurnosNoAtendidos = count($turnosNoAtendidos);
        $cTurnosAtendidos = count($turnosAtendidos);
        
        //request de ajax async para mostrar los datos
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {    
        
            $jsonData = array(
               'turnos_totales' => $cTurnosTotales,
               'turnos_no_atendidos' => $cTurnosNoAtendidos,
               'turnos_atendidos' => $cTurnosAtendidos, 
            );   
 
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($jsonData, 'json');
            
            $response->setContent($jsonContent);
            return $response;
        } else { 
            return $this->render('home/index.html.twig', [
                'temperatura' => $current['temperature'],
                'ciudad' => $location['name'],
                'humedad' => $current['humidity'],
                'presion' => $current['pressure']
                    
            ]); 
        } 
    }
    
    
   
    
}
