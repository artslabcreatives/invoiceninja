<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka LLC (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */
namespace Tests\Integration\Validation;

use App\Http\ValidationRules\ValidAmount;
use Tests\TestCase;

/**
 * @test
 */
class AmountValidationRuleTest extends TestCase
{

    public function setUp() :void
    {
        parent::setUp();

    }

    public function testSimpleAmountValid()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => 1,
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }

    public function testInvalidAmountValid()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => "aa",
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertFalse($v->passes());
    }

    public function testIllegalChars()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => "5+5",
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertFalse($v->passes());
    }

    public function testIllegalCharsNaked()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => 5+5, //resolves as 10 - but in practice, i believe this amount is wrapped in quotes so interpreted as a string
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }


    public function testinValidScenario1()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => "-10x",
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertFalse($v->passes());
    }

    public function testValidScenario2()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => -10,
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }


    public function testValidScenario3()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => "-10",
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }

    public function testInValidScenario4()
    {
        $rules = [
            'amount' => [new ValidAmount()]
        ];
        
        $data = [
            'amount' => "-0 1",
        ];
        
        $v = $this->app['validator']->make($data, $rules);
        $this->assertFalse($v->passes());
    }    
}


