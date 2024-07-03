<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableMethodsTrait;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatablePropertiesTrait;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;
use ProjetNormandie\PageBundle\Contracts\PageInterface;
use ProjetNormandie\PageBundle\Repository\PageRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name:'pnp_page')]
#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    normalizationContext: ['groups' => ['page:read']]
)]
#[ApiFilter(SearchFilter::class, properties: ['slug' => 'exact'])]

class Page implements TimestampableInterface, TranslatableInterface, SluggableInterface, PageInterface
{
    use TimestampableTrait;
    use TranslatablePropertiesTrait;
    use TranslatableMethodsTrait;
    use SluggableTrait;

    #[Groups(['page:read'])]
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Groups(['user:read'])]
    #[ORM\Column(length: 255, nullable: false)]
    private string $name = '';

    #[ORM\Column(length: 255, nullable: false)]
    private string $status = self::STATUS_PUBLIC;

    #[ORM\Column(length: 255, nullable: false, options: ['default' => true])]
    private bool $enabled = true;

    public function __toString()
    {
        return sprintf('%s [%s]', $this->getName(), $this->id);
    }

    public function getDefaultText(): string
    {
        return $this->translate('en', false)->getText();
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setTitle(string $title): void
    {
        $this->translate(null, false)->setText($title);
    }

    #[Groups(['page:read'])]
    public function getTitle(): string
    {
        return $this->translate(null, false)->getTitle();
    }

    public function setText(string $text): void
    {
        $this->translate(null, false)->setText($text);
    }

    #[Groups(['page:read'])]
    public function getText(): string
    {
        return $this->translate(null, false)->getText();
    }

    public function getSluggableFields(): array
    {
        return ['name'];
    }

    public static function getStatusChoices(): array
    {
        return [
            self::STATUS_PUBLIC => self::STATUS_PUBLIC,
            self::STATUS_PRIVATE => self::STATUS_PRIVATE,
        ];
    }
}
