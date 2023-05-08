<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

use AJT\Toggl\TogglClient;
use PHPUnit\Framework\TestCase;

/**
 * Set up the following files to run this test:
 * - \phpunit.xml by copying \phpunit-dist.xml and fill in the variables
 */
class TogglAPIV9Test extends TestCase
{
    private TogglClient $client;

    public function testProject_create_get_update_delete(): void
    {
        $workspaces = $this->client->getWorkspaces();
        $workspace = $workspaces[0]['id'];

        $project = $this->client->createProject([
            'workspace_id' => $workspace,
            'active' => true,
            'name' => 'AAA Project',
        ]);

        $projectGet = $this->client->getProject([
            'workspace_id' => $workspace,
            'project_id' => $project['id'],
        ]);
        $this->assertSame($project['id'], $projectGet['id']);

        $this->assertSame(true, $project['is_private']);
        $updateResult = $this->client->updateProject([
            'workspace_id' => $workspace,
            'project_id' => $project['id'],
            'name' => 'AAB Project',
        ]);
        $this->assertSame('AAB Project', $updateResult['name']);

        $deleteResult = $this->client->deleteProject([
            'workspace_id' => $workspace,
            'project_id' => $project['id'],
        ]);
        $this->assertEmpty($deleteResult);
    }

    protected function setUp(): void
    {
        global $toggl_api_version;
        global $toggl_api_key;

        $toggl_api_version = 'v9';

        $this->client = TogglClient::factory([
            'api_key' => $toggl_api_key,
        ]);
    }

}
