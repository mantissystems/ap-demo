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

class ImportController_old extends AbstractController {

/**
 * @Route("Import_old", name="import_index_old")
 */
public function index(Request $request) {
$localdir = __DIR__ . '/';
//        $fileSystem = new Filesystem();
//try {
//    $fileSystem->mkdir(sys_get_temp_dir().'/'.random_int(0, 1000));
//} catch (IOExceptionInterface $exception) {
//    echo "An error occurred while creating your directory at ".$exception->getPath();
//}
//$fileSystem->mkdir('/ftpuploads', 0700);
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
$name = 'inloadfiles';
$connection->executeUpdate($platform->getTruncateTableSQL($name, $cascade));
$i = 1;
$error = '';
foreach ($finder as $file) {
$destination = $file->getRelativePathname();
$reader = Reader::createFromPath($dir . $destination);
$csvColumns = $reader->fetchOne();
$csvrows = count($reader->fetchAll());
$destination = str_replace('.csv', '', $destination);

try {
$collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
} catch (\Exception $e) { // \Exception  is the global scope exception
if ($e instanceof MappingException || $e instanceof ORMException || $e instanceof EntityNotFoundException) {

}
if ($e instanceof EntityNotFoundException) {
throw $e; //Rethrow it if you can't handle it here.
}
}
try {
//do stuff here
$collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();
} catch (\Exception $e) {
//    if ($e instanceof MappingException || $e instanceof ORMException|| $e instanceof EntityNotFoundException) {
//    dump($e);     
//                    echo ' <font color="red">table-> '.$destination.' does not exist! Import will not be possible </font> ' ;
$error = $e->getMessage();
echo ' <font color="red">' . $error . '</font>';
//    exit();
//        }
error_log($e->getMessage());
}
if (!$error) {

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
}
$files = $this->getDoctrine()->getRepository(Inloadfiles::class);
$inload = new Inloadfiles();
//            $inload->sourcefile = $dir . $file->getRelativePathname();
$inload->sourcefile = $file->getRelativePathname();
$inload->destination = 'NOT EXISTS';
$inload->sourcecolumn = count($csvColumns) - 1;
$inload->destinationfield = count($collumns);
$inload->datalines = $csvrows;
$inload->randomizeable = FALSE;
$inload->tableexist = FALSE;
if (!$error) {
$inload->tableexist = TRUE;
$inload->destination = $destination;
}
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
'Id', 'Source ', 'Table', 'SourceColumns', 'Sourcelines', 'Loaded');
return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'dir'));
}

/**
 * @Route("/adapterimport_old", name="adapter_index_old")
 */
public function adapterindex() {
$localdir = __DIR__ . '/';
$dir = $this->rootdir($localdir);
$em = $this->getDoctrine()->getManager();
$finder = new Finder();
dump($dir);
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

foreach ($finder as $found) {
//            $reader = Reader::createFromPath('%kernel.root_dir%/../../data/' . $destination);
$source=$found->getRelativePathname();
//                                dump($source);exit();
$destination = str_replace('.csv', '', $source);    
$reader = Reader::createFromPath($dir . $source);
$csvColumns = $reader->fetchOne();
$csvrows = count($reader->fetchAll());

//$destination = str_replace('.csv', '', $source);
$collumns = $em->getClassMetadata($entityprefix . ucwords($destination))->getColumnNames();

$files = $this->getDoctrine()->getRepository($entityprefix . ucwords($name));
//            $destination_table = $this->getDoctrine()->getRepository($entityprefix . ucwords($destination));
//            $rows = $destination_table->findAll();
$loaded = $files->findAll();


$inload = new Inloadfiles();
$inload->MapId = '';
$inload->sourcefile = $source;
$inload->destination = $destination;
$inload->sourcecolumn = count($collumns) - 1;
if (array_search('id', $collumns, true)) {
$inload->sourcecolumn = count($collumns) - 2;}
$inload->destinationfield = count($collumns);
$inload->datalines = $csvrows;
$inload->randomizeable = FALSE;
if (array_search('lottery', $collumns, true)) {
$inload->randomizeable = TRUE;
//dump($loaded);
}
$em->persist($inload);
$em->flush();
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
 * @Route("/uploads_old/ {id} {dest} {cols} {source} ", name="uploads_old")
 */
public function upload($id, $dest, $cols, $source, Request $request) {
$files = $this->getDoctrine()->getRepository(Inloadfiles::class);
$loaded = $files->findAll();
$em = $this->getDoctrine()->getManager();
$GLOBALS['entitymanager'] = $em;
$connection = $em->getConnection();
$cascade = false;
$platform = $connection->getDatabasePlatform();
$platformname = strtolower(get_class($platform));

$headers = array(
'Id', 'Source file', 'Destination table', 'Source Columns', 'Datalines', 'Loaded at');
$entityprefix = 'App\Entity\\';
$localdir = __DIR__ . '/';
$dir = $this->rootdir($localdir);
$connection->executeUpdate($platform->getTruncateTableSQL($dest, $cascade));
$collumns = $em->getClassMetadata($entityprefix . ucwords($dest))->getColumnNames();
$cols = count($collumns);
dump($collumns);
//$eachcolumns = $collumns;
$reader = Reader::createFromPath('' . $dir . $source);
$filecontent = $reader->fetchall();
$x = count($filecontent);
date_default_timezone_set('UTC');
$numberoflines = $x;
$entitytable = $entityprefix . $dest;
switch ($dest) {
    case 'actionpost':
        $this->loadactionpost($filecontent,$entitytable,$GLOBALS['entitymanager']);

        break;

    default:
        break;
}
//        foreach ($filecontent as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]){
if($cols==2){
    $k1 = $collumns[1];
foreach ($filecontent as [$kk1]){

$newline = new $entitytable();
$newline->$k1 = $kk1;

if ($newline != null) {
$em->persist($newline);
dump($newline);
}
}    
$em->flush();
}
if($cols>2){
foreach (range(0, $cols-1) as $i) {
//    dump($i);exit();
$k1 = $collumns[$i];dump($i);
$k2 = $collumns[$i];dump($i);
$k3 = $collumns[$i];dump($i);
$k4 = $collumns[$i];dump($i);
$k5 = $collumns[$i];dump($i);
$k6 = $collumns[$i];dump($i);
$k7 = $collumns[$i];dump($i);
$k8 = $collumns[$i];dump($i);    
$k9 = $collumns[$i];dump($i);    
}
$i=1;
//foreach ($filecontent as [$k1, $k2, $k3, $k4, $k5, $k6, $k7,$collumns[8]]){    
//foreach ($filecontent as [$kk1, $kk2, $kk3, $kk4, $kk5, $kk6, $kk7, $kk8,$kk9]){
foreach ($filecontent as [$kk1, $kk2, $kk3, $kk4, $kk5, $kk6, $kk7]){
if ($i>$cols){exit();}//break;}
    
$newline = new $entitytable();
$newline->$k1 = $kk1;
$newline->$k2 = $kk2;
$newline->$k3 = $kk3;
$newline->$k4 = $kk4;
$newline->$k5 = $kk5;
$newline->$k6 = $kk6;
$newline->$k7 = $kk7;
//$newline->$k8 = $kk8;
//$newline->$k8 = $kk9;
$i++;
if ($newline != null) {
$em->persist($newline);
dump($newline);
}
}
}


$em->flush();

//        $wb = $this->addline($filecontent, $x, $entityprefix, $em, $dest);
return $this->render('import/candidatefiles.html.twig', compact('loaded', 'filelist', 'headers', 'id', 'dir'));
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

public function addline($filecontent, $Lines, $entityprefix, $em, $table) {
$r = $Lines;
$rgl = 0;
$entitytable = $entityprefix . $table;
$metadata = $em->getClassMetadata($entitytable);
$fieldNames = $metadata->getFieldNames();
$x = count($fieldNames);
dump($fieldNames, $filecontent, $x, $r);
for ($c = 0;
$c <= $x - 1;
$c++) {
$field = $fieldNames[$c];
switch ($field) {
case 'id':
$newline = new $entitytable();
//                        break;
case 'author':
$newline->$field = 1; //$filecontent[$x][0];
$em->persist($newline);
default:
//                        dump($field);
$newline->$field = $c . '|';
$newline->$field = $filecontent[$rgl][$c];
$em->persist($newline);
//                         dump($field);
//                        exit();
//                    $isadate = strtotime($filecontent[$x][0]);
}
//            $isadate = strtotime($filecontent[$x][$j]);
//            switch ($isadate) {
//                case TRUE:
//                    if (is_a($desttable->$field, 'DateTime')) {
//                        $desttable->$d0 = new \DateTime(date("Y-m-d H:i:s", $isadate));
//                    }
//            $isadate = strtotime($filecontent[$j][0]);
//                    break;
//            }
//            $em->persist($newline);
//                        exit();
if ($newline != null) {
$em->persist($newline);
$em->flush();
}
}
//        }
dump('einde addine');
return;
}

public function changeline($data, $col, $entitytable, $em, $target) {
$InSchedule = $em->getRepository($entitytable)->findAll([]);
$dd = $InSchedule[key($InSchedule)]->id;
dump('changeline' . $dd);
$numberoflines = count($data);
for ($j = 0;
$j <= $numberoflines - 1;
$j++) {
$et = $em->find($entitytable, $dd + $j);
$i = $dd + $numberoflines - 1;
if ($et) {
$isaDate = strtotime($data[$j][$col]);
dump($col . '|' . $et->id . '|' . $j . '|' . $isaDate);
if ($isaDate) {
if (is_a($et->datum, 'DateTime')) {
$dt = clone $et->datum;
//                $dt= $data[$j][$col];
//                $dt->setDate($dt->format("Y"), $dt->format("m"), $dt->format("d"));
//                $dt->setTime($endTime->format("H"), $endTime->format("i"));                
$et->datum = $isaDate;
}
}//new \DateTime(date("Y-m-d H:i:s", $data[$j][$col]));}}
if (!$isaDate) {
$et->$target = $data[$j][$col];
}
//                dump($et);
$em->persist($et);
}
}
return $j;
}
public function loadActionpost($filecontent,$entityable, ObjectManager $manager) {
        foreach ($filecontent as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $id=63;
//            $author = $em->getRepository(SymfonyDemoUser::class)->FindAll();
            
$author= $manager->getRepository(User::class)->findOneBy(['id' => $id,]);
//dump($author[0]->id);exit();
            $post = new $entityable();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setPublishedAt(new \DateTime('now + ' . 1 . 'seconds'));
            $post->setPublishedAt=$publishedAt;
            $post->author = $author; //author is hier een object; zou var moeten zijn
//            $post->setAuthor($author[0]->id); //author is hier een object; zou var moeten zijn
     

            $manager->persist($post);
        }

        $manager->flush();
    }
}
