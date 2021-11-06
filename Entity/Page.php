<?php

namespace ProjetNormandie\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="ProjetNormandie\PageBundle\Repository\PageRepository")
 * @method PageTranslation translate(string $locale, bool $fallbackToDefault)
 */
class Page implements TimestampableInterface, TranslatableInterface, SluggableInterface
{
    use TimestampableTrait;
    use TranslatableTrait;
    use SluggableTrait;

    const STATUS_PUBLIC = 'PUBLIC';
    const STATUS_PRIVATE = 'PRIVATE';

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;


    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private string $name = '';

     /**
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private string $status = 'PUBLIC';


    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s [%s]', $this->getName(), $this->id);
    }

    /**
     * @return string
     */
    public function getDefaultText(): string
    {
        return $this->translate('en', false)->getText();
    }

    /**
     * Set id
     * @param integer $id
     * @return $this
     */
    public function setId(int $id): Self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set name
     * @param string $name
     * @return string
     */
    public function setName(string $name): string
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): Self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Self
    {
        $this->translate(null, false)->setText($title);
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->translate(null, false)->getTitle();
    }

     /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): Self
    {
        $this->translate(null, false)->setText($text);

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->translate(null, false)->getText();
    }

    /**
     * Returns an array of the fields used to generate the slug.
     *
     * @return string[]
     */
    public function getSluggableFields(): array
    {
        return ['name'];
    }

     /**
     * @return array
     */
    public static function getStatusChoices(): array
    {
        return [
            self::STATUS_PUBLIC => self::STATUS_PUBLIC,
            self::STATUS_PRIVATE=> self::STATUS_PRIVATE,
        ];
    }

}
