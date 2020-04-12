<?php

namespace ProjetNormandie\PageBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Administration manager for the Page Bundle.
 */
class PageAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'pnforumbundle_admin_page';

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id', TextType::class, ['label' => 'id', 'attr' => ['readonly' => true]])
            ->add('name', TextType::class)
            ->add('translations', TranslationsType::class, [
                'required' => true,
                'fields' => [
                    'text' => [
                        'field_type' => CKEditorType::class,
                        'label' => TextType::class,
                    ]
                ]
            ]);
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

    }

    /**
     * @inheritdoc
     * @throws \RuntimeException When defining wrong or duplicate field names.
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('name', null, ['label' => 'Name'])
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
     * @inheritdoc
     * @throws \RuntimeException When defining wrong or duplicate field names.
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('createdAt', null, ['label' => 'Created At'])
            ->add('updatedAt', null, ['label' => 'Updated At'])
            ->add('getDefaultText', null, ['label' => 'Text', 'safe' => true]);
    }
}
