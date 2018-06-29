<?php

namespace App\Presenters;

use App\Components\Ratio;
use App\Forms\StudentFormFactory;
use App\Managers\StudentManager;
use App\Orm;
use App\Orm\Student;
use Nette;
use Nette\Application\UI\Form;
use Nextras\Orm\Entity\ToArrayConverter;

class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var Orm @inject */
    public $orm;

    /** @var StudentFormFactory @inject */
    public $studentFormFactory;

    /** @var StudentManager @inject */
    public $studentManager;

    /**
     * @param int|null $classroomId
     */
    public function actionDefault(?int $classroomId = null, ?int $gender = null): void
    {
        if ($gender) {
            $students = $this->orm->students->findByGender($gender);
        } else {
            $students = $this->orm->students->findAll();

            if ($classroomId) {
                $students = $students->findBy(['classroom' => $classroomId]);
            }
        }

        $this->template->students = $students;
    }

    /**
     * @return void
     */
    public function renderDefault(): void
    {
        $this->template->classrooms = $this->orm->classrooms->findAll();
    }

    /**
     * @param int $studentId
     * @throws \InvalidArgumentException
     */
    public function actionEdit(int $studentId): void
    {
        /** @var Student $student */
        $student = $this->orm->students->getById($studentId);

        if (!$student) {
            throw new \InvalidArgumentException('Student not found.');
        }

        $this['studentForm']->setDefaults($student->toArray(ToArrayConverter::RELATIONSHIP_AS_ID));
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function handleDelete(int $studentId): void
    {
        /** @var Student $student */
        $student = $this->orm->students->getById($studentId);

        if (!$student) {
            throw new \InvalidArgumentException('Student not found.');
        }

        $this->studentManager->deleteStudent($student);

        $this->redrawControl('table');
    }

    /**
     * @return void
     */
    public function afterSubmit(): void
    {
        $this->redirect('Homepage:default');
    }

    /**
     * @return Form
     */
    protected function createComponentStudentForm(): Form
    {
        $form = $this->studentFormFactory->create($this, $this->orm, 'studentForm');

        $form->onSuccess[] = [$this->studentManager, 'submitStudentForm'];
        $form->onSuccess[] = [$this, 'afterSubmit'];

        return $form;
    }

    /**
     * @return Ratio
     */
    protected function createComponentRatio(): Ratio
    {
        return new Ratio($this->orm);
    }
}
