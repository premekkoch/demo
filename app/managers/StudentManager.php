<?php declare(strict_types=1);

namespace App\Managers;

use App\Orm;
use App\Orm\Student;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class StudentManager
{
    /** @var Orm */
    private $orm;

    /**
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param Form      $studentForm
     * @param ArrayHash $values
     * @throws \InvalidArgumentException
     */
    public function submitStudentForm(Form $studentForm, ArrayHash $values): void
    {
        if ($values->id) {
            $student = $this->orm->students->getById($values->id);

            if (!$student) {
                throw new \InvalidArgumentException('Student not found.');
            }
        } else {
            $student = new Student();
        }

        $classroom = $this->orm->classrooms->getById($values->classroom);

        if (!$classroom) {
            throw new \InvalidArgumentException('Invalid classroom.');
        }

        $student->classroom = $classroom;
        $student->name = $values->name;
        $student->gender = $values->gender;

        $this->orm->persistAndFlush($student);
    }

    /**
     * @param Student $student
     */
    public function deleteStudent(Student $student): void
    {
        $this->orm->students->removeAndFlush($student);
    }
}
