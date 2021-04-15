<?php

namespace Tests\Unit;

use Tests\TestCase;

class TodoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateNewTodoMissingDescriptionTest()
    {
        $result = $this->post('/create', [
            'description' => null // is required so will produce a redirect for validation error message from laravel for default rule
        ]);
        $this->assertEquals(302, $result->getStatusCode());
    }

    public function testCreateNewTodoSuccess()
    {
        $result = $this->post('/create', [
            'description' => 'Go shopping' // required value
            // 'checked' => '1' // additional value
        ]);

        $this->assertEquals(200, $result->getStatusCode());
    }
}
