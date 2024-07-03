<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

#[ORM\Table(name:'pnp_page_translation')]
#[ORM\Entity]
class PageTranslation implements TranslationInterface
{
    use TranslationTrait;

    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private string $title = '';

    #[ORM\Column(type: 'text', nullable: false)]
    private string $text = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}
