<?php declare(strict_types=1);

namespace App\Forms;

use App\Orm;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nextras\Orm\Collection\Collection;

class StudentFormFactory
{
    /**
     * @param IContainer  $parent
     * @param Orm         $orm
     * @param null|string $name
     * @return Form
     */
    public function create(IContainer $parent, Orm $orm, ?string $name): Form
    {
        $form = new Form($parent, $name);

        $form->addHidden('id');

        $classrooms = $orm->classrooms->findAll()->orderBy('name', Collection::ASC)->fetchPairs('id', 'name');
        $form->addSelect('classroom', 'Classroom', $classrooms)
            ->setRequired('Classroom is required value.');

        $form->addText('name', 'Student name')
            ->setRequired('Student name is required value.')
            ->setMaxLength(50);

        $form->addSelect('gender', 'Gender', [
            Orm\Student::GENDER_MALE => 'Male',
            Orm\Student::GENDER_FEMALE => 'Female',
        ])->setRequired('Gender is required value.');

        $form->addSubmit('send', 'Save')
            ->setHtmlAttribute('class', 'btn btn-primary');

        return $form;
    }
}
