<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionpostRepository")
 */
class Actionpost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;
/**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
/**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    public $author;
/**
     * @var string
     *
     * 
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
 */
    
        public $title;

/**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
        
    public $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string", length=255, nullable=true)
     */
    public $summary;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=true)
     */
    public $content;
        /**
     * @var datetime
     *
     * @ORM\Column(name="publishedAt", type="datetime", length=255, nullable=true)
     */
    public $publishedAt;
    
   /**
     * @var string
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
 
    
    public $comments;
//    public $tags;
 
    public function getId(): ?int
    {
        return $this->id;
    }
     public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        //voor actionpost moet object user in appfixtures worden opgezet
        $this->author = $author;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }
        public function setComments(?string $comment): void
    {
        $this->comments = $comment;
    }
//    public function addComment(){
//        $this->comments->$comment;
//        return;}
    
//    public function addComment(?Comment $comment): void
//    {
//        $comment->setPost($this);
////        $comment->setPost(null);
//        if (!$this->comments->contains($comment)) {
//            $this->comments->add($comment);
//        }
//    }

    public function removeComment(Comment $comment): void
    {
        $comment->setPost(null);
        $this->comments->removeElement($comment);
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): void
    {
        $this->summary = $summary;
    }

    public function addTag(?Tag ...$tags): void
    {
//        foreach ($tags as $tag) {
//            if (!$this->tags->contains($tag)) {
                $this->tags->add($tag);
//            }
//        }
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
