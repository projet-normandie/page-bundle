<?php

namespace ProjetNormandie\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="page_translation")
 */
class PageTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private string $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private string $text = '';

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): Self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }
}
