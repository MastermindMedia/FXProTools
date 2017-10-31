<?php
namespace Hyperwallet\Tests\Response;

use Hyperwallet\Model\Error;
use Hyperwallet\Response\ErrorResponse;

class ErrorResponseTest extends \PHPUnit_Framework_TestCase {

    public function testBodyParsing() {
        $errorResponse = new ErrorResponse(200, array(
            'errors' => array(
                array(
                    'fieldName' => 'test',
                    'message' => 'Test message',
                    'code' => 'TEST'
                ),
                array(
                    'message' => 'Test message2',
                    'code' => 'TEST'
                )
            )
        ));

        $this->assertEquals(200, $errorResponse->getStatusCode());
        $this->assertCount(2, $errorResponse->getErrors());

        $this->assertEquals('test', $errorResponse->getErrors()[0]->getFieldName());
        $this->assertEquals('Test message', $errorResponse->getErrors()[0]->getMessage());
        $this->assertEquals('TEST', $errorResponse->getErrors()[0]->getCode());

        $this->assertNull($errorResponse->getErrors()[1]->getFieldName());
        $this->assertEquals('Test message2', $errorResponse->getErrors()[1]->getMessage());
        $this->assertEquals('TEST', $errorResponse->getErrors()[1]->getCode());
    }

    public function testMagicErrorAccessor() {
        $errorResponse = new ErrorResponse(200, array(
            'errors' => array(
                array(
                    'fieldName' => 'test',
                    'message' => 'Test message',
                    'code' => 'TEST'
                ),
                array(
                    'message' => 'Test message2',
                    'code' => 'TEST'
                )
            )
        ));

        $this->assertCount(2, $errorResponse);

        $this->assertEquals('test', $errorResponse[0]->getFieldName());
        $this->assertEquals('Test message', $errorResponse[0]->getMessage());
        $this->assertEquals('TEST', $errorResponse[0]->getCode());

        $this->assertNull($errorResponse[1]->getFieldName());
        $this->assertEquals('Test message2', $errorResponse[1]->getMessage());
        $this->assertEquals('TEST', $errorResponse[1]->getCode());

        $this->assertTrue(isset($errorResponse[0]));
        $this->assertFalse(isset($errorResponse[3]));

        $errorResponse[0] = new Error(array(
            'fieldName' => 'test3',
            'message' => 'Test message3',
            'code' => 'TEST3'
        ));

        $this->assertEquals('test3', $errorResponse[0]->getFieldName());
        $this->assertEquals('Test message3', $errorResponse[0]->getMessage());
        $this->assertEquals('TEST3', $errorResponse[0]->getCode());

        unset($errorResponse[0]);

        $this->assertCount(1, $errorResponse);

        $this->assertNull($errorResponse[1]->getFieldName());
        $this->assertEquals('Test message2', $errorResponse[1]->getMessage());
        $this->assertEquals('TEST', $errorResponse[1]->getCode());
    }

}
