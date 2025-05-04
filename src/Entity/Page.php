<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use ProjetNormandie\PageBundle\Repository\PageRepository;
use ProjetNormandie\PageBundle\ValueObject\PageStatus;
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
class Page
{
    use TimestampableEntity;

    #[Groups(['page:read'])]
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Groups(['user:read'])]
    #[ORM\Column(length: 255, nullable: false)]
    private string $name = '';

    #[ORM\Column(length: 255, nullable: false)]
    private string $status = PageStatus::PUBLIC;

    #[ORM\OneToMany(
        mappedBy: 'translatable',
        targetEntity: PageTranslation::class,
        cascade: ['persist', 'remove'],
        fetch: 'EAGER',
        orphanRemoval: true,
        indexBy: 'locale'
    )]
    private Collection $translations;

    #[ORM\Column(length: 255, nullable: false, options: ['default' => true])]
    private bool $enabled = true;

    #[ORM\Column(length: 255, unique: false)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    private ?string $currentLocale = null;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s [%s]', $this->getName(), $this->id);
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
        $value = new PageStatus($status);
        $this->status = $value->getValue();
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPageStatus(): PageStatus
    {
        return new PageStatus($this->status);
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    // Translation methods for A2lix compatibility
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function setTranslations(Collection $translations): self
    {
        $this->translations = $translations;
        return $this;
    }

    public function addTranslation(PageTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $translation->setTranslatable($this);
            $this->translations->set($translation->getLocale(), $translation);
        }

        return $this;
    }

    public function removeTranslation(PageTranslation $translation): self
    {
        if ($this->translations->removeElement($translation)) {
            $translation->setTranslatable(null);
        }

        return $this;
    }

    public function translate(?string $locale = null, bool $fallbackToDefault = true): PageTranslation
    {
        $locale = $locale ?: $this->currentLocale ?: 'en';

        if (!$this->translations->containsKey($locale)) {
            $translation = new PageTranslation();
            $translation->setTranslatable($this);
            $translation->setLocale($locale);
            $this->translations->set($locale, $translation);
        }

        return $this->translations->get($locale);
    }

    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    public function getCurrentLocale(): ?string
    {
        return $this->currentLocale;
    }

    public function setText(string $text, ?string $locale = null): void
    {
        $this->translate($locale)->setText($text);
    }

    #[Groups(['page:read'])]
    public function getText(?string $locale = null): ?string
    {
        return $this->translate($locale)->getText();
    }

    // Old methods for backward compatibility
    public function mergeNewTranslations(): void
    {
        // Not needed anymore
    }
}
