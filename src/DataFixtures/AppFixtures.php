<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\Actiontag;
use App\Entity\Actionpost;
use App\Entity\User;
//use App\Entity\Teams;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//=== added
//use App\Entity\Inloadfiles;
class AppFixtures extends Fixture {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {
        $this->loadUsers($manager);
        $this->loadTags($manager);
        $this->loadPosts($manager);
        $this->loadactiontag($manager);
        $this->loadActionpost($manager);

//        for ($i = 0; $i < 8; $i++) {
//            $inload->MapId='0' . $i;
//            if (array_search('lottery', $collumns, true)) {
//                $inload->randomizeable = TRUE;
//            }
//            $inload->loadedat = new \DateTime('now + ' . 10 . 'seconds');
//           $manager->persist($inload);
//        }
        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager) {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function loadTags(ObjectManager $manager) {
        foreach ($this->getTagData() as $index => $name) {
            $tag = new Tag();
            $tag->setName($name);

            $manager->persist($tag);
            $this->addReference('tag-' . $name, $tag);
        }

        $manager->flush();
    }

    public function loadPosts(ObjectManager $manager) {
        foreach ($this->getPostData() as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $post = new Post();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            $post->addTag(...$tags);

            foreach (range(1, 5) as $i) {
                $comment = new Comment();
                $comment->setAuthor($this->getReference('john_user'));
                $comment->setContent($this->getRandomText(random_int(255, 512)));
                $comment->setPublishedAt(new \DateTime('now + ' . $i . 'seconds'));

                $post->addComment($comment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    private function getUserData(): array {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['Jane Doe', 'jane_admin', 'kitten', 'jane_admin@symfony.com', ['ROLE_ADMIN']],
            ['Mantis', 'mantis', 'mantis', 'infor@mantisbv.nl', ['ROLE_ADMIN']],
            ['John Doe', 'john_user', 'kitten', 'john_user@symfony.com', ['ROLE_USER']],
        ];
    }

    private function getTagData(): array {
        return [
            'BARDIENST',
            'BeatrixWinterRace',
            'CommCie',
            'INSTRUCTIE',
            'IT BEHEER',
            'JEUGD <18',
            'JEUGD <15',
            'JEUGD <20',
            'REPARATIE',
            'Schoonmaak',
            'CoachWEDSTRIJD',
            'Instructeurjeugd <14',
            'Jeugdcoach',
            'Junioren hulpinstructeurs',
            'Advertentie redactie',
            'Foto redactie',
            'schoonmaakteam',
            'Webredactie',
            'Organisatie BTC',
            'Coach 2km ploeg',
            'Coach wedststrijdploegen',
        ];
    }

    private function getPostData() {
        $posts = [];
        foreach ($this->getPhrases() as $i => $title) {
            // $postData = [$title, $slug, $summary, $content, $publishedAt, $author, $tags, $comments];
            $posts[] = [
                $title,
                Slugger::slugify($title),
                $this->getRandomText(),
                $this->getPostContent(),
                new \DateTime('now - ' . $i . 'days'),
                // Ensure that the first post is written by Jane Doe to simplify tests
                $this->getReference(['jane_admin', 'mantis'][0 === $i ? 0 : random_int(0, 1)]),
                $this->getRandomTags(),
            ];
        }

        return $posts;
    }

    private function getPhrases(): array {
        return [
            'Societeitsbeheer',
            'Barmedewerker',
            'ERV Beatrix',
            'Wedstrijdleiding',
            'Secretariaat',
            'Coordinator vervolginstructie tm S2',
            'Communicatiecommissie',
            'Helpers activiteiten en evenementen',
            'Begeleiding instructeurs  roeien instructiecommissie',
            'ERV Beatrix',
            'Coordinator werving en scholing',
            'Instructeur aspiranten cursus',
            'Instructeur beginners (S1)',
            'Instructeur gevorderde roeiers (S2 S3)',
            'Instructeur skiff',
            'Begeleiding instructeurs',
            'Helpers activiteiten en evenementen',
            'IT beheer',
            'Instructeur jongens <18',
            'Instructeur meisjes <18',
            'Instructeur jeugd <14',
            'Jeugdcoach',
            'Junioren hulpinstructeurs',
            'Roeipraet, redactie advertenties',
            'Roeipraet,  fotoredactie',
            'Schoonmaakteam',
            'Webredactie',
            'Organisatie BTC',
            'Coach 2km wedststrijdploeg',
            'Coach wedststrijdploegen',
        ];
    }

    private function getRandomText(int $maxLength = 255): string {
        $phrases = $this->getPhrases();
        shuffle($phrases);

        while (mb_strlen($text = implode('. ', $phrases) . '.') > $maxLength) {
            array_pop($phrases);
        }

        return $text;
    }

    private function getPostContent(): string {
        return <<<'MARKDOWN'
Materiaal verzamelen.
 - Verpakken buitenzijde
   produktsticker 
 - Inhoud controleren 
   aftekenen 
 - Opslaan
   (First-in/first-out).
 - uitwendig schuren en inwendig reinigen
MARKDOWN;
    }

    private function getRandomTags(): array {
        $tagNames = $this->getTagData();
        shuffle($tagNames);
        $selectedTags = \array_slice($tagNames, 0, random_int(2, 4));

        return array_map(function ($tagName) {
            return $this->getReference('tag-' . $tagName);
        }, $selectedTags);
    }

    private function loadactiontag(ObjectManager $manager) {
        foreach ($this->getTagData() as $index => $name) {
            $tag = new Actiontag();
            $tag->setName($name);

            $manager->persist($tag);
//            $this->addReference('tag-' . $name, $tag);
        }
// $tag = new Actiontag();
//            $tag->setName('wb'.$i);
////            }
        $manager->persist($tag);
        $manager->flush();
    }
    public function loadActionpost(ObjectManager $manager) {
        foreach ($this->getPostData() as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $post = new Actionpost();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author); //author is hier een object; zou var moeten zijn
//            $post->addTag(...$tags);

            foreach (range(1, 5) as $i) {
                $comment = new Comment();
                $comment->setAuthor($this->getReference('john_user'));
                $comment->setContent($this->getRandomText(random_int(255, 512)));
                $comment->setPublishedAt(new \DateTime('now + ' . $i . 'seconds'));

//                $post->addComment($comment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }


}
