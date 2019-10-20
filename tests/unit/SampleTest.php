<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__.'/../../app/utils/Validator.php';

/**
 * Sample test class which showcases some basic aspects of PHPUnit.
 * This test file can be removed, or edited to suit your project needs.
 */
class SampleTest extends TestCase {
    private $test_var;

    /**
     * Set up a test case.
     * @return void
     */
    protected function setUp(): void {
        $this->test_var = 'This is a test variable.';
    }

    /**
     * A basic test case example (positive).
     * @return void
     */
    public function testTestSuiteIsWorkingForPositiveAssertions() {
        /* Sample model */
        $sample_model = [
            'sample_attribute_1' => 'The answer to life, the universe and everything?',
            'sample_attribute_2' => 42
        ];
        /* Assertions */
        $this->assertEquals('This is a test variable.', $this->test_var);
        $this->assertCount(2, $sample_model); 
        $this->assertNull(Validator::validate_model(SampleModel::class, $sample_model));
        $this->assertTrue(true);
    }

        /**
     * A basic test case example (negative).
     * @return void
     */
    public function testTestSuiteIsWorkingForNegativeAssertions() {
        /* Sample model */
        $sample_model = [
            'sample_attribute_1' => 'This sample model is invalid.'
        ];
        /* Assertions */
        $this->assertNotNull(Validator::validate_model(SampleModel::class, $sample_model));
        $this->assertNotTrue(false);
    }

    /**
     * Tear down a test case.
     * @return void
     */
    protected function tearDown(): void {
        $this->test_var = NULL;
    }
}