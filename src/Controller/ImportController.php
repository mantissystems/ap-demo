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

class ImportController extends AbstractController {

    /**
     * @Route("Import", name="import_index")
     */
    public function index(Request $request) {
        $localdir = __DIR__ . '/';
        $dir = $this->rootdir($localdir);
        $em = $this->getDoctrine()->getManager();
        $finder = new Finder();
        $finder->files()->in($dir);
        $finder->name('*.csv');
        $entityprefix = 'App\Entity\\';
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $name = 'inloadfiles';
        $connection->executeUpdate($platform->getTruncateTableSQL($name, $cascade));
        $i = 1;
        foreach ($finder as $file) {
            $destination = $file->getRelativePathname();
            $reader = Reader::createFromPath($dir . $destination);
            $csvColumns = $reader->fetchOne();
            $csvrows = count($reader->fetchAll());
            $destination = str_replace('.csv', '', $destination);
            $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
            $files = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
            $destination_table = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
            $rows = $destination_table->findAll();
            $loaded = $files->findAll();
            if (count($csvColumns) < 1) {
                echo '<p>**' . count($csvColumns) . ' in upload file  ' . $file->getRelativePathname() . ' in directory ' . $dir . '</p>';
            }
            if (count($collumns) > count($csvColumns) - 1) {
                echo '<p class=text-success > OK ' . count($csvColumns) . ' present; ' . (count($collumns) - 1) . 'datacolumns needed in upload file <p class=text-success >' . $file->getRelativePathname() . ' <p <p class=text-success > in directory ' . $dir . '</p>';
            }
            dump($file->getRelativePathname());
            $files = $this->getDoctrine()->getRepository(Inloadfiles::class);
            $inload = new Inloadfiles();
            $inload->sourcefile = $file->getRelativePathname();
//            $inload->sourcefile = $dir.$file->getRelativePathname();
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
            'Id', 'Source ', 'Table', 'SourceColumns', 'Sourcelines', '|', 'Loaded', 'Action');
        return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'dir'));
    }

    /**
     * @Route("/adapterimport", name="adapter_index")
     */
    public function adapterindex() {
        $localdir = __DIR__ . '/';
        $dir = $this->rootdir($localdir);
        $em = $this->getDoctrine()->getManager();
        $finder = new Finder();
        $finder->files()->in($dir);
        $finder->name('*.csv');
        foreach ($finder as $file) {
            $inload = new Inloadfiles();
            $inload->stream_id = '0';
            $inload->sourcefile = $file->getRelativePathname();
//            dump($inload);
            $em->persist($inload);
        }
        $em->flush();

        $entityprefix = 'App\Entity\\';
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $cascade = false;
        $platform = $connection->getDatabasePlatform();
        $platformname = strtolower(get_class($platform));
//        dump($platformname);
        $name = 'inloadfiles';
        $files = $this->getDoctrine()->getRepository($entityprefix . ucwords($name));
        $loaded = $files->findAll();

        $i = 1;
        if (strpos($platformname, 'sqlite', 0) > 0) {
            echo '<p>SQLITE </p>';
            // dit moet beter af te handelen zijn met standaard ORM
            $name = 'inloadfiles';
//            $files = $this->getDoctrine()->getRepository($entityprefix . ucwords($name));
//            $loaded = $files->findAll();
            $headers = array(
                'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');
//        }                                                
            $connection->executeUpdate($platform->getTruncateTableSQL($name, $cascade));

            foreach ($finder as $file) {
//            $reader = Reader::createFromPath('%kernel.root_dir%/../../data/' . $destination);
                $destination = 'teams.csv';
                $reader = Reader::createFromPath($dir . $destination);
                $csvColumns = $reader->fetchOne();
                $csvrows = count($reader->fetchAll());
//                            dump($csvrows);exit();
                $destination = str_replace('.csv', '', $destination);
                $collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();

                $files = $this->getDoctrine()->getRepository($entityprefix . ucwords($name));
//            $destination_table = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
//            $rows = $destination_table->findAll();
                $loaded = $files->findAll();


                $inload = new Inloadfiles();
                $inload->MapId = '';
                $inload->sourcefile = $file->getRelativePathname();
                $inload->destination = $destination;
                $inload->sourcecolumn = count($csvColumns) - 1;
                $inload->destinationfield = count($collumns);
                $inload->datalines = $csvrows;
                $inload->randomizeable = FALSE;
                if (array_search('lottery', $collumns, true)) {
                    $inload->randomizeable = TRUE;
                    dump($loaded);
                }
                $em->persist($inload);
            }
            $em->flush();

            $headers = array(
                'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');
        }

        return $this->render('import/adapterindex.html.twig', compact('loaded', 'filelist', 'headers', 'dir'));
//        return $this->render('import/adapterindex.html.twig', [
//            'controller_name' => 'ImportController',
//        ]);
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
        $localdir = __DIR__ . '/';
        $dir = $this->rootdir($localdir);

        $em = $this->getDoctrine()->getManager();
        $collumns = $em->getClassMetadata($entityprefix . ucwords($dest))->getColumnNames();
        $cols = count($collumns);
        $reader = Reader::createFromPath('%kernel.root_dir%/../../data/' . $source . '');
        $filecontent = $reader->fetchall();
        date_default_timezone_set('UTC');
//        $this->loadPosts($filecontent, $entityprefix, $dest);

        $entitytable = $entityprefix . ucwords('symfonyDemoUser');
        return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'id', 'dir'));
    }

    public function rootdir($localdir) {
        $localdir = str_replace('src/Controller/', '', $localdir);
//        $localdir=str_replace('src//Controller//', '', $localdir);

        return $localdir;// . 'data/';
    }

}
