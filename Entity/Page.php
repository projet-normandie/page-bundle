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

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;


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
    public function getDefaultText()
    {
        return $this->translate('en', false)->getText();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return string
     */
    public function setName(string $name)
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
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->translate(null, false)->setText($title);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->translate(null, false)->getTitle();
    }

     /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text)
    {
        $this->translate(null, false)->setText($text);

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
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
}
