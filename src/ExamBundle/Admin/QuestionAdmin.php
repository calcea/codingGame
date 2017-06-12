<?php

namespace ExamBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class QuestionAdmin extends Admin
{
    protected $parentAssociationMapping = 'lesson';

    protected $correctAnswerOptions = array(
        1 => 'Option 1',
        2 => 'Option 2',
        3 => 'Option 3',
        4 => 'Option 4'
    );

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('question')
            ->add('score')
            ->add('option1')
            ->add('option2')
            ->add('option3')
            ->add('option4');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Question details')
            ->add('question')
            ->add('option1')
            ->add('option2')
            ->add('option3')
            ->add('option4')
            ->add('answer','choice', array('choices' => $this->correctAnswerOptions))
            ->add('score')
        ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('question');
    }

}