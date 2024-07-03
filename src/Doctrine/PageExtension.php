<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use ProjetNormandie\PageBundle\Contracts\PageInterface;
use Symfony\Component\Intl\Locale;
use ProjetNormandie\PageBundle\Entity\Page;

final class PageExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface, PageInterface
{
    /**
     * @param QueryBuilder                $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string                      $resourceClass
     * @param Operation|null              $operation
     * @param array                       $context
     * @return void
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param QueryBuilder                $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string                      $resourceClass
     * @param array                       $identifiers
     * @param Operation|null              $operation
     * @param array                       $context
     * @return void
     */
    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $resourceClass
     */
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if ($resourceClass != Page::class) {
            return;
        }
        $locale = Locale::getDefault();
        if (!in_array($locale, array('en', 'fr'))) {
            $locale = 'en';
        }
        $queryBuilder->leftJoin('o.translations', 't', 'WITH', "t.locale='$locale'")
            ->addSelect('t')
            ->andWhere('o.status = :status')
            ->setParameter('status', self::STATUS_PUBLIC);
    }
}
