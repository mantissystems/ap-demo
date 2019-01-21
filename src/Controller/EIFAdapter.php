<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Entity\Mapping;
use AppBundle\Entity\Team;
//use AppBundle\Entity\Inloadfiles;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Finder\Finder;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\inloadmapping;

class EIFAdapter extends Controller {

    private $filelist;

    /**
     * @Route("/EIFAdapter", name="eifadapter")
     */
    public function sendSpoolAction($messages = 10, KernelInterface $kernel) {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $tableNames = array();
        $cascade = false;

$localdir = __DIR__ . '/';
$dir = $this->rootdir($localdir);
$em = $this->getDoctrine()->getManager();
$GLOBALS['entitymanager'] = $em;        
        $platform = $connection->getDatabasePlatform();
        $finder = new Finder();
        $finder->files()->in($dir);
        $finder->files()->contains('header');
        $finder->files()->notName('*.php');
        $finder->files()->name('*.csv');
        $filelist = array();
//        $b = 1;
//        dump($finder);
        $em = $this->getDoctrine()->getManager();
        $mapping = $em->getRepository(inloadmapping::class)->FindAll();
//        dump($mapping);
                //=====================================================
                //=====================================================        
        foreach ($finder as $file) {
                //=====================================================
                //=====================================================        
        foreach ($mapping as $map) {
                $filetoload = $file->getRelativePathname();
                dump($filetoload);
                $rmapped = $map->table_right;
                $stream = $map->stream_id;
                $source = $map->source;
                $colnr = $map->source_column;
//                $lfield = $map->field_left;
                $dest_field =$map->destination;
            dump($map);
                $id=$map->id;
                if ($filetoload === $source) {                    
                    

                }
            }
        }
        $headers = array(
        'Id', 'Source file', 'Destination table', 'Source Column', 'Destination field');
        $loaded = $em->getRepository(inloadmapping::class)->FindAll();
        //$dir = 'existing mappings for files: ';//$this->container->getParameter('ftp_path');
        return $this->render('import\candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'dir'));
        return new Response($content);
    }
    /**
     * @Route("/uploads/{id}", name="uploads")
     */
    public function testAction($id, Request $request ) {
        
       dump($request);
        $bestand = $request->get('test');
                $dir = $this->container->getParameter('ftp_path');
        dump($id,$bestand);
            $em = $this->getDoctrine()->getManager();
            $mapped = $em->getRepository(Aa_mapping::class)->findBy(['stream_id' => $id,]);
            $query = $em->createQuery("SELECT DISTINCT e.source, e.table_right,e.stream_id,e.source_column, e.destination FROM AppBundle:Aa_mapping e WHERE e.stream_id = :id ORDER BY e.source,e.table_right,e.source_column")->setParameter('id', $id);        

            $streamid = $em->getRepository(Aa_mapping::class)->findAll(['stream_id' => $id,
            'source','table_right','destination'=>'ASC']);
            $m=count($mapped);
            
            $conn = $em->getConnection();
            $sm = $conn->getSchemaManager();
            if (count($streamid)>=1){    
                    dump($streamid,count($streamid));

                    
            //===============================================================================================================
            //voor iedere m de waarde van de sourcekolom stoppen in de destination tabel en het destaination veld.
            //maak een switch van de combinaties tussen de vier variabelen en vul de entiteit ermee
            //de vier variabelen zijn 
            //source bestand
            //sourcekolom
            //destination tabel
            //destination veld
            //indien meerdere destination velden per destination tabel dan een switch voor deze velden maken
            // --------+-------------+
            //     SOURCE(1)         |
            // --------+-------------+
            // KOLOM (2) |           |
            // --------+-------------+
            // DESTINATION TABEL (3) |
            //--------+--------------+
            // KOLOM  |  VELD(4)     |
            // --------+-------------+ 
            // als de distinctive waardes van source, kolom, destination tabel, veld > 1 dan een switch voor destination veld
            //===============================================================================================================
                    
$entityprefix = 'App\Entity\\';
            
            $query = $em->createQuery("SELECT DISTINCT e.source, e.table_right,e.stream_id,e.source_column, e.destination FROM AppBundle:Aa_mapping e WHERE e.stream_id = :id ORDER BY e.source,e.table_right,e.source_column")->setParameter('id', $id);        
            
            $distinct= $query->getResult();      
            $s=count($distinct);
            for ($x = 0; $x <= $s-1;$x++)
            {
                $s4=$distinct[$x]["source"];                
                    if($s4){
                    $csvfile = Reader::createFromPath($dir.$s4, 'r');                                    
//                                    exit();        
                      
                    }else{
            throw $this->createNotFoundException(
            'No such file as  '.$s4.' in directory '.$dir);

                    }
                $csvfile = Reader::createFromPath($dir.$s4, 'r');
                if(!$csvfile){
                      throw $this->createNotFoundException(
            'No such file as  '.$s4.'in directory '.$dir);
        exit();}
                $filecontent = $csvfile->fetchall();
//                $csvfile=NULL;
                switch($x){
                    case 0:
                $s1=$distinct[$x]["table_right"];                
                $col0=$distinct[$x]["source_column"];                
                $s3=$distinct[$x]["destination"];                
                $r=count($filecontent);
                $entitytable=$entityprefix.ucwords($s1);                    
                
                

                $wb = $this->addline($filecontent,$col0,$entitytable,$em,$s3,$r);                          
                dump('0 '.$s3.$col0);
                        $em->flush();                    
                                    break;
                    case 1:
                $s5=$distinct[$x]["table_right"];                
                $col=$distinct[$x]["source_column"];                  
                $s7=$distinct[$x]["destination"];                
                dump('1 '.$s7.$col);
                        $wb = $this->changeline($filecontent,$col,$entitytable,$em,$s7,$r);
                        dump($wb);
                        $em->flush();
                                    break;
                    case 2:
                $s5=$distinct[$x]["table_right"];                
                $col=$distinct[$x]["source_column"];                  
                $s7=$distinct[$x]["destination"];                
                dump('2'.$s7.$col);
                        $wb = $this->changeline($filecontent,$col,$entitytable,$em,$s7,$r);
                        $em->flush();
                                    break;
                    case 3:
                $s5=$distinct[$x]["table_right"];                
                $col=$distinct[$x]["source_column"];                  
                $s7=$distinct[$x]["destination"];                
                dump('3 '.$s7.$col);
                        $wb = $this->changeline($filecontent,$col,$entitytable,$em,$s3,$r);
                        $em->flush();
                                    break;
                    default:
                $s5=$distinct[$x]["table_right"];                
                $s6=$distinct[$x]["source_column"];                  
                $s7=$distinct[$x]["destination"];                
                dump('default '.$s7);

                        $wb = $this->addline($filecontent,$s6,$entitytable,$em,$s7,$r);
                        $em->flush();
//                        $x++;                                

                        
                                    break;
                }

            }              
            //=======================

            $em->flush();
        
        return $this->render('events\mapping.html.twig', array(
                    'oneidTWIG' => count($streamid), 'test' => $dir));
                }

        }
                public function addline($data,$col,$et,$em,$target,$numberoflines){
                for($j=0 ; $j <=$numberoflines-1;$j++)
                {
                $desttable=new $et();
                    $desttable->$target= $data[$j][$col];
                    $em->persist($desttable);                                              
                    }                    
               
                return $data[$col];
            
        }
                public function changeline($data,$col,$entitytable,$em,$target,$numberoflines){
            for($j=0 ; $j <=$numberoflines-1;$j++){
            $et = $em->find($entitytable, $j+1);
                $et->$target= $data[$j][$col];
                    $em->persist($et);                          
        
        }
        return $data[$col];                    
        }
public function rootdir($localdir) {

$c = strlen('Controller');
$s = strlen('src');
$l = strlen($localdir);
$d = 3; //number of subdirlevel
$rest = substr($localdir, 0, 70 - $c - $s - $d); // returns "d"
$localdir = $rest . '/data/';

//        $webPath = $this->get('kernel')->getProjectDir() . '/public/';
//        $container->getParameter('kernel.project_dir') . '/public/';
//        $directoryPath = $this->container->getParameter('kernel.root_dir') . 'public';
//        $localdir = str_replace('Controller', '', $localdir);
//        $localdir = str_replace("\\", "", $localdir);
//        $localdir = str_replace('src', '', $localdir);
//        $localdir=str_replace('src//Controller//', '', $localdir);
return $localdir; // . '/';
}

}