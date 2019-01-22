<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//added=====
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inloadfiles;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Actionpost;
use App\Entity\User;
use App\Entity\inloadmapping;
use Doctrine\ORM\Query\ResultSetMapping;

class ImportController extends AbstractController {

    /**
     * @Route("Import", name="import_index")
     */
    public function index(Request $request) {
        $localdir = __DIR__ . '/';
        $dir = $this->rootdir($localdir);
        $em = $this->getDoctrine()->getManager();
        $GLOBALS['entitymanager'] = $em;

        $finder = new Finder();
        $finder->files()->in($dir);
        $finder->name('*.csv');
        $entityprefix = 'App\Entity\\';
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $platformname = strtolower(get_class($platform));
//dump($platformname);
//exit();
        if (strpos($platformname, 'sqlite', 0) > 0) {
            echo '<p>SQLITE </p>';
            $name = 'inloadmapping';
//        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
        }
        $connection->executeUpdate($platform->getTruncateTableSQL($name, $cascade));
        $i = 1;
        $error = '';
        $erroneous = 0;
//=====================================================
//=====================================================        
        foreach ($finder as $file) {
//=====================================================
//=====================================================        
            $source = $file->getRelativePathname();
            $reader = Reader::createFromPath($dir . $source);
            $csvColumns = $reader->fetchOne();
            $csvrows = count($reader->fetchAll());
            $destination = str_replace('.csv', '', $source);

            try {
                $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
            } catch (\Exception $e) {
                if ($e instanceof MappingException || $e instanceof ORMException || $e instanceof EntityNotFoundException) {
                    
                }
                if ($e instanceof EntityNotFoundException) {
                    throw $e;
                }
            }
            try {
                $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
//                dump($collumns);
            } catch (\Exception $e) {
                $erroneous++;
                echo ' <font color="red">table-> ' . $destination . ' does not exist! Import will not be possible </font> ';
//                $erroneous++;

                $error = $e->getMessage();
                $erroneous++;

                echo ' <font color="red">' . $error . '</font>';
//                $erroneous++;
                error_log($e->getMessage());
            }
            dump($erroneous);
            if (!$erroneous > 0) {
                $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
                $files = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
                $destination_table = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
                $rows = $destination_table->findAll();

                $loaded = $files->findAll();
                if (count($csvColumns) > 0) {
//echo '<p>' . count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir . '</p>';
                }
                if (count($collumns) > 0) {
//echo '<p class=text-success > OK ' . count($csvColumns) . ' present; ' . (count($collumns) - 1) . 'datacolumns needed in upload file <p class=text-success >' . $file->getRelativePathname() . ' <p <p class=text-success > in directory ' . $dir . '</p>';
                }
            }
            $i = 0;
//=====================================================
//=====================================================        
            if (!empty($collumns)) {
                foreach ($collumns as $value) {
                    $inloadmap = new inloadmapping();
                    $inloadmap->stream_id = '01';
                    $inloadmap->table_right = $destination;
                    $inloadmap->source = $source;
                    if ($erroneous > 0) {
                        $inloadmap->source = 'ERROR';
                    }
                    $inloadmap->status = $i;
                    $inloadmap->source_column = $i;
                    $inloadmap->destination = $value;
                    $i++;
                    $em->persist($inloadmap);
                }
            }
            $em->flush();
//=====================================================
//=====================================================        
            $erroneous = 0;
        }
        $em->flush();
        dump($name);
//            $name = 'inloadmapping';
//=====================================================
//=====================================================        
        $inloadmaping = $this->getDoctrine()->getRepository($entityprefix . $name);
        $mapped = $inloadmaping->findAll();
        $csvfile = array();
        foreach ($mapped as $p) {
            $a = $p->source;
            $b = $p->source_column;
            if ($b == '0') {
                $csvfile[] = ($p->source);
            }
        }
        dump($csvfile);
        $loaded = $mapped;
        $headers = array(
            'Source ', 'Table', 'SourceColumn', 'Destination', 'Loaded');
        return $this->render('import/mapping.html.twig', compact('csvfile', 'loaded', 'headers', 'dir'));
    }

    /**
     * @Route("/adapterimport", name="adapter_index")
     */
    //=======================================================
    //=======================================================
    //=======================================================

    public function adapterindex() {
        $entityprefix = 'App\Entity\\';
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $platformname = strtolower(get_class($platform));
        $name = 'inloadfiles';

        $mapped = $em->getRepository($entityprefix . ucwords($name))->findAll([]);
        $files = $this->getDoctrine()->getRepository(inloadmapping::class);
//        $wb = 0;
//        $txt = 'ERROR';
//        $mapped = $files->findBy(['source' => $txt,]);
//        echo $mapped;        exit();
//        $finder->files()->in($dir);
//        $finder->name('*.csv');
//        foreach ($finder as $file) {
        //=======================================================
//                    exit();
        foreach ($mapped as $file) {
            $inload = new Inloadfiles();
            $inload->stream_id = '0';
            $inload->loadable = FALSE;
//            if ($inload->sourcefile !== 'ERROR') {
            $inload->loadable = TRUE;
            $source = $file->sourcefile;
//            }
            $inload->source = $file->sourcefile;
            $em->persist($inload);
        }
        $em->flush();
//                    exit();
        $entityprefix = 'App\Entity\\';
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $platformname = strtolower(get_class($platform));
//        $name = 'inloadmapping';
//        $source = 'actionpost.csv';
//        $files = $this->getDoctrine()->getRepository($entityprefix .$name);// ucwords($name));
//        $mapping = $em->getRepository(inloadmapping::class)->findOneBy(['source' => $source,]);
        $mappings = $em->getRepository(inloadmapping::class)->findAll([]);
//            $mapping= $em->getRepository(inloadmapping::class)->findBy(['source' => $source,]);
//            $author = $manager->getRepository(User::class)->findOneBy(['id' => $id,]);
//        $mapping=null;
        $mapping = $mappings; //->findAll();
        $i = 1;
        if (strpos($platformname, 'sqlite', 0) > 0) {
            echo '<p>SQLITE </p>';
// dit moet beter af te handelen zijn met standaard ORM
            //=======================================================
            $name = 'inloadfiles';
            $headers = array(
                'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');
//        }                                                
            $connection->executeUpdate($platform->getTruncateTableSQL($name, $cascade));

            //=======================================================
            $localdir = __DIR__ . '/';
            $dir = $this->rootdir($localdir);
//        dump($mapping);exit();
            foreach ($mapping as $map) {
//        dump($map,$mapping);exit();

                $source = $map->source;
                if ($source != 'ERROR') {
//                break;


                    $destination = $map->table_right; //str_replace('.csv', '', $source);
                    $reader = Reader::createFromPath($dir . $source);
                    $csvColumns = $reader->fetchOne();
                    $csvrows = count($reader->fetchAll());
                    $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
//            dump($csvColumns);
                    $inload = new Inloadfiles();
                    $inload->MapId = '';
                    $inload->sourcefile = $source;
                    $inload->destination = $destination;
                    $inload->sourcecolumn = count($collumns) - 1;
//                if (array_search('id', $collumns, true)) {
//                    $inload->sourcecolumn = count($collumns) - 2;
//                }
                    $inload->destinationfield = count($collumns);
                    $inload->datalines = $csvrows;
                    $inload->randomizeable = FALSE;
                    if (array_search('lottery', $collumns, true)) {
                        $inload->randomizeable = TRUE;
                    }
                    $em->persist($inload);
                    $em->flush();
                }
//                                                                dump($inload);exit();
            }
            $em->flush();
            $loaded = $mappings;
            $headers = array(
                'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');
        }

        return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'dir'));
    }

    /**
     * @Route("/uploads/ {dest}  {source} ", name="uploads")
     */
    public function upload($dest, $source, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $wb = 'ERROR';
        $GLOBALS['destinationtable'] = $dest;
        $query = $em->createQuery("SELECT DISTINCT e.source, e.table_right,e.stream_id,e.source_column, e.destination FROM App:inloadmapping e WHERE e.source != :wb ORDER BY e.source,e.table_right,e.source_column")->setParameter('wb', $wb);
        $distinct = $query->getResult();
        $s = count($distinct);

//        $files = $this->getDoctrine()->getRepository(inloadmapping::class);
//        $loaded = $files->findBy(['table_right' => $dest,]);
        $loaded = $distinct;
//        dump($loaded);
        $filelist = $loaded;
        $GLOBALS['entitymanager'] = $em;
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $platformname = strtolower(get_class($platform));

        $headers = array(
            'Id', 'Source file', 'Destination table', 'Source Column', 'Field');
        $entityprefix = 'App\Entity\\';
        $localdir = __DIR__ . '/';
        $dir = $this->rootdir($localdir);
        $connection->executeUpdate($platform->getTruncateTableSQL($dest, $cascade));
        $collumns = $em->getClassMetadata($entityprefix . ucwords($dest))->getColumnNames();
//    $nameMetadata = $metadata->fieldMappings['author_id'];
//    echo $nameMetadata['type'];  //print "string"
//    echo $nameMetadata['length']; // print "150"

        $cols = count($collumns);
        $reader = Reader::createFromPath('' . $dir . $source);
        $filecontent = $reader->fetchall();
        $x = count($filecontent) - 1;
        $y = $x * $cols;
        date_default_timezone_set('UTC');
        $numberoflines = $x;
        $user = 'mantis';
        $author = $em->getRepository(User::class)->findOneBy(['username' => $user,]);
        $destwb = $em->getRepository(actionpost::class)->findAll([]);
        $key0 = array_search('id', $collumns); // $key = 0;
        $key1 = array_search('author', $collumns); // $key = 0;
        $key2 = array_search('comments', $collumns); // $key = 0;
                $rsm = new ResultSetMapping();

        foreach ($filecontent as $line) {

            $s5 = $GLOBALS['destinationtable'];
            $entitytable = $entityprefix . $s5;
            $desttable = new $entitytable();
            foreach ($loaded as $value) {
                $s6 = $value["source_column"]; //->source_column;
                $col = $value["source_column"]; //->source_column;
                $entitytable = $entityprefix . $s5;
                $destination = $value["destination"]; //->destination;
                $key20 = array_search($destination, $collumns); // $key = 0;
                if (!$line[$key20] instanceof DateTime) {
                    $field = $collumns[$key20];
                    if (!empty($field) && !empty($line[$key20])) {
                        $desttable->$field = $line[$key20];
                    }
                }
            }
        $title=$line[2];
        $author=$line[3];
        $title=$line[4];
        $summary=$line[5];
        $content=$line[6];
        $publishedat=$line[7];
        $comments=$line[8];        
            $query = $em->createNativeQuery("INSERT INTO actionpost  (author,title,slug) VALUES (? ,? , ?) ",$rsm);
        $query->setParameter(1, $author);
        $query->setParameter(2, $title);
//        $query->setParameter(3, $slug);        
                $query->setParameter(4, $summary);
                $result = $query->getResult();

                }
//        $items='64';
//        $rsm = new ResultSetMapping();
//        $query = $em->createNativeQuery('INSERT INTO actionpost SET title = ?', $rsm);
//$query = $em->createNativeQuery("INSERT INTO actionpost  (author,title) VALUES ('mantis','title') ",$rsm);
//$query = $em->createNativeQuery("INSERT INTO actionpost  (author,title,slug) VALUES (? ,? , ?) ",$rsm);
//        $query->setParameter(1, $author);
//        $query->setParameter(2, $title);
//        $query->setParameter(3, $slug);        
//$rsm = new ResultSetMapping();
//$query = $this->_em->createNativeQuery('INSERT INTO Invoiceshasitems SET Invoiceitemsid = ?', $rsm);
//$query->setParameter(1, $items);
//
//$result = $query->getResult();

//        $result = $query->getResult();



        return $this->render('import/mapping.html.twig', compact('loaded', 'headers', 'dir'));
    }

    public function datumcheck($test) {
        if ($test instanceof DateTime) {
            return true;
            exit();
            // true
//            return false;
        } else {
            return false;
        }
        return false;
//         $a = new DateTime();
//    if (get_class($a) == 'DateTime') {
//        echo "Datetime";
//    }
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
//        $localdir=str_replace('src//Controller//', '', $localdir);
        return $localdir; // . '/';
    }

    public function getnoerror() {
        $qb = $this->createQueryBuilder('u');
        $qb->where('u.id != :identifier')
                ->setParameter('identifier', 1);

        return $qb->getQuery()
                        ->getResult();
    }

}
