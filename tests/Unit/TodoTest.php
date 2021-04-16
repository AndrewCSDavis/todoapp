<?php

namespace Tests\Unit;

use App\Models\Todo;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoTest extends TestCase
{
    /**
     * Testing the creation of new Todos with Missing description
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

    /**
     * Testing the creation of new Todos successfully
     */
    public function testCreateNewTodoSuccess()
    {
        $result = $this->post('/create', [
            'description' => 'Test 1' // required value
            // 'checked' => '1' // additional value
        ]);
        $this->assertTrue(Session::has('success'));
        $this->assertEquals(302, $result->getStatusCode());
        $todo = Todo::first();
        $this->assertEquals('Test 1', $todo->description);
    }

    /**
     * Testing the update of an existing todos with missing description
     */
    public function testUpdateTodoMissingDescriptionTest()
    {
        // need to create the dummy data first
        $todo = Todo::create([
            'description' => 'Test 1',
            'checked' => false
        ]);
        $result = $this->post('/edit/'. $todo->id, [
            'description' => null // is required so will produce a redirect for validation error message from laravel for default rule
        ]);
        $this->assertEquals(302, $result->getStatusCode());
    }

    /**
     * Testing the update of an existing todos
     */
    public function testUpdateTodoTest()
    {
        // need to create the dummy data first
        $todo = Todo::create([
            'description' => 'Test 1',
            'checked' => false
        ]);
        $result = $this->post('/edit/'. $todo->id, [
            'description' => 'Test 2' // is required so will produce a redirect for validation error message from laravel for default rule
        ]);
        $this->assertTrue(Session::has('success'));
        $this->assertEquals(302, $result->getStatusCode());

        $todo = Todo::find($todo->id);
        $this->assertEquals('Test 2', $todo->description);
    }

    /**
     * Testing the update of an existing todos on checked mark
     */
    public function testUpdateTodoCheckedTest()
    {
        // need to create the dummy data first
        $todo = Todo::create([
            'description' => 'Test 1',
            'checked' => false
        ]);
        $result = $this->post('/api/update/'. $todo->id . '/1', []);
        $todo = Todo::find($todo->id);
        $this->assertEquals(true, $todo->checked);

        $data = json_decode($result->getContent(), true);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('1', $data['status']);
    }

    /**
     * Testing the delete of an existing todos
     */
    public function testDeleteTodoTest()
    {
        // need to create the dummy data first
        $todo = Todo::create([
            'description' => 'Test 1',
            'checked' => false
        ]);
        $result = $this->delete('/api/delete/'. $todo->id, []);
        $todo = Todo::find($todo->id);
        $this->assertNull($todo);

        $data = json_decode($result->getContent(), true);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('1', $data['status']);
    }
}
