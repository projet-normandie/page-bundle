<?php

namespace ProjetNormandie\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;


/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="ProjetNormandie\PageBundle\Repository\PageRepository")
 * @method PageTranslation translate(string $locale, bool $fallbackToDefault)
 */
class Page
{
    use Timestampable;
    use Translatable;
    use Sluggable;

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
    public function setId($id)
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
    public function setName($name)
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
     * @param string $text
     * @return $this
     */
    public function setText($text)
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
     * @return array
     */
    public function getSluggableFields()
    {
        return ['name'];
    }
}
