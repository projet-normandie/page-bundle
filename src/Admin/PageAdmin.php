<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use ProjetNormandie\PageBundle\Form\Type\RichTextEditorType;
use ProjetNormandie\PageBundle\ValueObject\PageStatus;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Administration manager for the Page Bundle.
 */
class PageAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'pnforumbundle_admin_page';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('export');
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('id', TextType::class, ['label' => 'label.id', 'attr' => ['readonly' => true]])
            ->add('name', TextType::class, ['label' => 'label.name'])
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'label.status',
                    'choices' => PageStatus::getStatusChoices(),
                ]
            )
            ->add('enabled', CheckboxType::class, [
                'label' => 'label.enabled',
                'required' => false,
            ])
            ->add('translations', TranslationsType::class, [
                'label' => false,
                'required' => true,
                'fields' => [
                    'title' => [
                        'field_type' => TextType::class,
                        'label' => 'label.title',
                    ],
                    'text' => [
                        'field_type' => RichTextEditorType::class,
                        'label' => 'label.text',
                    ]
                ]
            ]);
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('id', null, ['label' => 'label.id'])
            ->add('name', null, ['label' => 'label.name'])
            ->add(
                'status',
                'choice',
                [
                    'label' => 'label.status',
                    'choices' => PageStatus::getStatusChoices(),
                ]
            )
            ->add('slug', null, ['label' => 'label.slug'])
            ->add('enabled', null, ['label' => 'label.enabled'])
            ->add('createdAt', null, ['label' => 'label.createdAt'])
            ->add('updatedAt', null, ['label' => 'label.updatedAt'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                ]
            ]);
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id', null, ['label' => 'label.id'])
            ->add('name', null, ['label' => 'label.name'])
            ->add('status', null, ['label' => 'label.status'])
            ->add('enabled', null, ['label' => 'label.enabled'])
            ->add('createdAt', null, ['label' => 'label.createdAt'])
            ->add('updatedAt', null, ['label' => 'label.updatedAt'])
            ->add('getText', null, ['label' => 'label.text', 'safe' => true]);
    }
}
