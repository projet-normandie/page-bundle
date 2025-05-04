<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\EventListener\Entity;

use Datetime;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use ProjetNormandie\PageBundle\Entity\PageTranslation;

class PageTranslationListener
{
    public function postUpdate(PageTranslation $translation, PostUpdateEventArgs $event): void
    {
        $page = $translation->getTranslatable();

        if ($page !== null) {
            $em = $event->getObjectManager();

            $page->setUpdatedAt(new DateTime());

            $em->persist($page);
            $em->flush();
        }
    }
}
