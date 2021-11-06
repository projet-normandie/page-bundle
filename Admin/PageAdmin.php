<?php

namespace ProjetNormandie\PageBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use ProjetNormandie\PageBundle\Entity\Page;

/**
 * Administration manager for the Page Bundle.
 */
class PageAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'pnforumbundle_admin_page';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('id', TextType::class, ['label' => 'id', 'attr' => ['readonly' => true]])
            ->add('name', TextType::class)
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'label.status',
                    'choices' => Page::getStatusChoices(),
                ]
            )
            ->add('translations', TranslationsType::class, [
                'required' => true,
                'fields' => [
                    'text' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Text',
                    ]
                ]
            ]);
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->add('name', null, ['label' => 'Name'])
            ->add(
                'status',
                'choice',
                [
                    'label' => 'label.status',
                    'choices' => Page::getStatusChoices(),
                ]
            )
            ->add('slug', null, ['label' => 'Slug'])
            ->add('createdAt', null, ['label' => 'Created At'])
            ->add('updatedAt', null, ['label' => 'Updated At'])
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
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('id')
            ->add('name')
            ->add('status', null, ['label' => 'label.status'])
            ->add('createdAt', null, ['label' => 'Created At'])
            ->add('updatedAt', null, ['label' => 'Updated At'])
            ->add('getText', null, ['label' => 'Text', 'safe' => true]);
    }
}
