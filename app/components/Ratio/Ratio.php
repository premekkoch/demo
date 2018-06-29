<?php declare(strict_types=1);

namespace App\Components;

use App\Orm;
use Nette\Application\UI\Control;

class Ratio extends Control
{
    /** @var Orm */
    private $orm;

    /**
     * @param Orm $orm
     */
    public function __construct(Orm $orm)
    {
        parent::__construct();

        $this->orm = $orm;
    }

    /**
     * @return void
     */
    public function render(): void
    {
        $this->template->setFile(__DIR__.'/ratio.latte');
        $this->template->ratios = $this->orm->classrooms->getGenderRatios();

        $this->template->render();
    }
}
