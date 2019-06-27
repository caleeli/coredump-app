<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use JDD\Workflow\Facades\Workflow;
use JDD\Workflow\Models\Process;
use Tests\TestCase;

/**
 * Application menus
 */
class BpmnSampleTest extends TestCase
{
    use DatabaseMigrations;
    //use WithoutEvents;

    /**
     * Get the menu list for the user.
     *
     * @return void
     */
    public function testGetMenuesForUser()
    {
        // Start a process instance from default start event
        Workflow::callProcess('sample.bpmn');

        // Get process instance model
        $instance = Process::first();
        // Get current tokens
        $tokens = $instance->tokens;
        // Get first token
        $token = $tokens[0];
        $tokenId = $token['id'];

        // Assertion: One process instance should be started
        $this->assertEquals(1, Process::count());

        // Assertion: It has one ACTIVE token
        $this->assertEquals(1, count($tokens));
        $this->assertEquals('ACTIVE', $token['status']);

        // Complete the active task
        Workflow::completeTask($instance->id, $tokenId);

        // Refresh the instance from the database
        $instance->refresh();

        // Assertion: Verify the Script Task failed and the Console Task is active
        $this->assertArraySubset(['status' => 'FAILING'], $instance->tokens[0]);
        $this->assertArraySubset(['status' => 'ACTIVE'], $instance->tokens[1]);
    }
}
