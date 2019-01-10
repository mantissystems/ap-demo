<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use symfony\component\validator\Constraints as Assert;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Finder\Finder;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Mapping;
use App\Entity\Inloadfiles;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Players;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Controller\UtilitiesController;

// TODO
// 1. check table exists
// 2. check import columns with table columns per uploaded line; for next loop should be in sinc
//3. show imorted data after import; show in form or show in tekst pop up .
class ImportController extends AbstractController {

    /**
     * @Route("Import", name="import_index")
     */
    public function index(Request $request) {
        $dir = __DIR__ . '/';
        $em = $this->getDoctrine()->getManager();
        $finder = new Finder();
        $finder->files()->in(__DIR__);
        $finder->name('*.csv');
//        dump($finder);
//$finder->in('src/Symfony/*/*/Resources');
        $entityprefix = 'App\Entity\\';

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        $name = 'inloadfiles';
        $connection->executeUpdate($platform->getTruncateTableSQL($name, $cascade));
        $i = 1;
        foreach ($finder as $file) {
            $destination = $file->getRelativePathname();
            $reader = Reader::createFromPath('%kernel.root_dir%/../../data/' . $destination);
            $csvColumns = $reader->fetchOne();
            $csvrows = count($reader->fetchAll());
//                            dump($csvrows);die();
            $destination = str_replace('.csv', '', $destination);
            $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();

            $files = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
            $destination_table = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
            $rows = $destination_table->findAll();

            $loaded = $files->findAll();
            if (count($csvColumns) < 1) {
//                throw $this->createNotFoundException(count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir);
                echo '<p>**' . count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir . '</p>';
//                die();
            }
            if (count($collumns) < count($csvColumns) - 1) {
//                throw $this->createNotFoundException('  ' . count($collumns) . 'table columns for ' . count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir);
//                echo '<p>**' . count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir . '</p>';
//                die();
            }
//            if (count($collumns) > count($csvColumns) - 1 | count($collumns) == count($csvColumns) - 1) {
            if (count($collumns) > count($csvColumns) - 1) {
//                throw $this->createNotFoundException('  ' . count($collumns) . 'data columns needed ' . count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir);
//                echo '<p class=text-success > wb </p>';
                echo '<p class=text-success > OK ' . count($csvColumns) . ' present; ' . (count($collumns) - 1) . 'datacolumns needed in upload file <p class=text-success >' . $file->getRelativePathname() . ' <p <p class=text-success > in directory ' . $dir . '</p>';

            }
            // dumps the relative path to the file
            dump($file->getRelativePathname());
            $files = $this->getDoctrine()->getRepository(Inloadfiles::class);
            $inload = new Inloadfiles();
//            $inload->MapId='0' . $i;
            $inload->sourcefile = $file->getRelativePathname();
            $inload->destination = $destination;
            $inload->sourcecolumn = count($csvColumns) - 1;
            $inload->destinationfield = count($collumns);
            $inload->datalines = $csvrows;
            $inload->randomizeable = FALSE;
            if (array_search('lottery', $collumns, true)) {
                $inload->randomizeable = TRUE;
            }
            $inload->loadedat = new \DateTime('now + ' . $i . 'seconds');
            $i++;
            $em->persist($inload);
            $em->flush();
        }
        $files = $this->getDoctrine()->getRepository(Inloadfiles::class);
        $loaded = $files->findAll();
        $headers = array(
            'Id', 'Source ', 'Table', 'SourceColumns', 'Sourcelines','|', 'Loaded','Action');
//        dump($loaded);
        $dir='%kernel.root_dir%/../../data/';
        return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'dir'));
    }

    /**
     * @Route("/uploads/ {id} {dest} {cols} {source} ", name="uploads")
     */
    public function upload($id, $dest, $cols, $source, Request $request) {
        $files = $this->getDoctrine()->getRepository(Inloadfiles::class);
        $loaded = $files->findAll();
        $headers = array(
            'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');
        $entityprefix = 'App\Entity\\';
        $dir = __DIR__ . '/';
        $em = $this->getDoctrine()->getManager();
        $collumns = $em->getClassMetadata($entityprefix . ucwords($dest))->getColumnNames();
//        $cols = count($collumns);
        $reader = Reader::createFromPath('%kernel.root_dir%/../../data/' . $source . '');
        $filecontent = $reader->fetchall();
        date_default_timezone_set('UTC');
        //=====================================;
        $this->loadPosts($filecontent, $entityprefix, $dest);
//==========================================

                                                          $entitytable = $entityprefix . ucwords('symfonyDemoUser');
//                    if (preg_match(' /^(\d{4}) - (\d{2}) - (\d{2}) \d{2}:\d{2}:\d{2}/', $row[$c], $matches)) {
////                        $target->$field->setPublishedAt(new \DateTime('now + ' . $i . 'seconds'));

        return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'id', 'dir'));
    }

    /**
     * @Route("/remove/{twigtable}", name="remove")
     */
    public function Removal($twigtable, Request $request) {

        $dir = __DIR__ . '/';
        $maps = $this->getDoctrine()->getRepository(Mapping::class);
        $files = $this->getDoctrine()->getRepository(Inloadfiles::class);
        $mapping = $maps->findAll();
        $loaded = $files->findAll();

//        dump($request);
        $entityprefix = 'AppBundle\Entity\\';
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();


        $cascade = false;
        $distinct = $request->query;
        $platform = $connection->getDatabasePlatform();
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');


        $name = $twigtable;
        $upper = preg_match_all('/[A-Z]/', $name, $matches, PREG_OFFSET_CAPTURE);

        if ($matches) {
            $i = 0;
            foreach ($matches as $value) {

//                dump($value[$i],count($value[$i]));
                if (count($value[$i]) > 0) {
                    $what = $value[0][$i]; //0 = character
//                    $where=$value[$i][1]+1; //1= position
                    $inwhat = '_';                    // replace underscore for capital position
                    $where = $value[$i][1] + strlen($inwhat); //1= position
                    if ($where > 0) {
                        $replace = substr_replace($name, $inwhat, $where, 1);
//                                        dump($replace);
                    }
                }
                $i++;
            }
        }

        $lowercasefilename = $this->Camelcase($name);
        dump($lowercasefilename);

//        exit();
        $connection->executeUpdate($platform->getTruncateTableSQL($lowercasefilename, $cascade));
        $headers = array(
            'Id', 'Source file', 'Destination table', 'Source Column', 'Datalines');
        return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'id', 'dir'));
    }

    function Camelcase($subject) {
        $l = strlen($subject);
        $s = null;
        $capital = FALSE;
        for ($i = 0; $i < $l; $i++) {
            $s = substr($subject, $i, 1);
            $capital = strpbrk($s, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            if (!$capital) {
                
            }
            if ($capital) {
                $p = null;
                if ($i > 0) {
                    $left = substr($subject, -$l, $i);
                    $right = substr($subject, $l, $i);
                    $p = preg_replace('/\\B([A-Z])/', '_$1', $subject);
//                    dump($p);
                }
            }
        }

        return strtolower($p);
    }

    public function loadPosts($filecontent, $entityprefix, $destination) {
        $table = $entityprefix . ucwords($destination);
        $entitytable = $entityprefix . ucwords('symfonyDemoUser');
        $em = $this->getDoctrine()->getManager();
        $aa = $em->getRepository($entitytable)->findOneBy(['username' => 'mantis']);
        $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
        $files = $this->getDoctrine()->getRepository($entityprefix . ucwords('inloadfiles'));
        $dir = '';

        $loaded = $files->findAll();

        foreach ($filecontent as $rowkey => $rowvalue) {
            $target = new $table();
            foreach ($collumns as $colkey => $colvalue) {
                $field = $colvalue;
                                                dump($colkey);
                dump($rowvalue[$colkey]);

                $target->$field =  'de titel van wim';                                        
//                $aa = $em->getRepository($entitytable)->findOneBy(['username' =>$this->getuser()]);
//                        $authorPosts = $posts->findBy(['author' => $this->getUser()], ['publishedAt' => 'DESC']);

                $aa = $em->getRepository($entitytable)->findOneBy(['username' => 'mantis']);
                            $target->author = $aa;
//                    dump($aa);
if($colkey>0){
            $target->slug = $rowvalue[$colkey];
                $target->summary = $rowvalue[$colkey];
                $target->content = 'content of the post. and can contain more than one line. sometimes a complete story';
                $target->content =$rowvalue[$colkey];
                $target->setPublishedAt(new \DateTime('now +  100 seconds'));
//                                $target->setPublishedAt(new \DateTime($rowvalue[$colkey]));
    
}
    

//                                            $target->setPublishedAt(new \DateTime('now + ' . $c . 'seconds'));
                $em->persist($target);
            }

            $em->flush();
            $headers = array(
                'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');

            return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'id', 'dir'));
        }
    }

}
