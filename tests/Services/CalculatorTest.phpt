<?php declare(strict_types=1);

namespace App\Tests;

use App\Services\Calculator;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__.'/../bootstrap.php';
require_once __DIR__.'/../../app/services/Calculator.php';

class CalculatorTest extends TestCase
{
    /** @var Calculator */
    private $calculator;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @return void
     */
    public function testZero1(): void
    {
        $result = $this->calculator->calculateRatio(0, 0);
        Assert::same(0.0, $result);
    }

    /**
     * @return void
     */
    public function testZero2(): void
    {
        $result = $this->calculator->calculateRatio(5, 0);
        Assert::same(0.0, $result);
    }

    /**
     * @return void
     */
    public function testZero3(): void
    {
        $result = $this->calculator->calculateRatio(0, 5);
        Assert::same(0.0, $result);
    }

    /**
     * @return void
     */
    public function testWhole(): void
    {
        $result = $this->calculator->calculateRatio(256, 256);
        Assert::same(100.0, $result);
    }

    /**
     * @return void
     */
    public function testHalf(): void
    {
        $result = $this->calculator->calculateRatio(15, 30);
        Assert::same(50.0, $result);
    }

    /**
     * @return void
     */
    public function testQuater(): void
    {
        $result = $this->calculator->calculateRatio(3, 12);
        Assert::same(25.0, $result, 2);
    }

    /**
     * @return void
     */
    public function testThird(): void
    {
        $result = $this->calculator->calculateRatio(3, 9);
        Assert::same(33.33, round($result, 2));
    }

    /**
     * @return void
     */
    public function testEight(): void
    {
        $result = $this->calculator->calculateRatio(1, 8);
        Assert::same(12.5, $result);
    }

    /**
     * @return void
     */
    public function testTenth(): void
    {
        $result = $this->calculator->calculateRatio(258, 2580);
        Assert::same(10.0, $result);
    }

}

(new CalculatorTest)->run();
