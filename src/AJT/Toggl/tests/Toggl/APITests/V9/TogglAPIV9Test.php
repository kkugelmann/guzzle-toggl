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
    private int $workspaceId;

    protected function setUp(): void
    {
        global $toggl_api_version;
        global $toggl_api_key;

        $toggl_api_version = 'v9';

        $this->client = TogglClient::factory([
            'api_key' => $toggl_api_key,
        ]);
        $workspaces = $this->client->getWorkspaces();
        $this->workspaceId = $workspaces[0]['id'];
    }

    public function testProject_create_get_update_delete(): void
    {
        $project = $this->client->createProject([
            'workspace_id' => $this->workspaceId,
            'active' => true,
            'name' => 'AAA Project',
        ]);

        $projectGet = $this->client->getProject([
            'workspace_id' => $this->workspaceId,
            'project_id' => $project['id'],
        ]);
        $this->assertSame($project['name'], $projectGet['name']);

        $this->assertSame(true, $project['is_private']);
        $updateResult = $this->client->updateProject([
            'workspace_id' => $this->workspaceId,
            'project_id' => $project['id'],
            'name' => 'AAB Project',
        ]);
        $this->assertSame('AAB Project', $updateResult['name']);

        $deleteResult = $this->client->deleteProject([
            'workspace_id' => $this->workspaceId,
            'project_id' => $project['id'],
        ]);
        $this->assertEmpty($deleteResult);
    }

    public function testClient_create_get_update_delete(): void
    {
        $client = [];
        $client['name'] = 'AAA Client';
        $client['notes'] = 'AAA Client Notes';

        $clientCreate = $this->client->createClient([
            'workspace_id' => $this->workspaceId,
            ...$client,
        ]);

        $clientGet = $this->client->getClient([
            'workspace_id' => $this->workspaceId,
            'client_id' => $clientCreate['id'],
        ]);

        $this->assertSame($client['name'], $clientGet['name']);

        $client['name'] = 'AAB Client';
        $client['notes'] = 'AAB Client Notes';
        $clientUpdate = $this->client->updateClient([
            'workspace_id' => $this->workspaceId,
            'client_id' => $clientCreate['id'],
            ...$client,
        ]);

        $this->assertSame($client['name'], $clientUpdate['name']);

        $deleteResult = $this->client->deleteClient([
            'workspace_id' => $this->workspaceId,
            'client_id' => $clientCreate['id'],
        ]);
        $this->assertEmpty($deleteResult);
    }

}
