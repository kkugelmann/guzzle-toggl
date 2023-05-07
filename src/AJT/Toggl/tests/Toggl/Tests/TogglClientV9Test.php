<?php

namespace AJT\Toggl\tests\Toggl\Tests;

use AJT\Toggl\TogglClient;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Set up the following files to run this test:
 * - \apikey.php by copying \apikey-dist.php
 * - \phpunit.xml by copying \phpunit-dist.xml
 */
class TogglClientV9Test extends TestCase
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

        $deleteResult = @$this->client->deleteProject([
            'workspace_id' => $workspace,
            'project_id' => $project['id'],
        ]);
        $this->assertEmpty($deleteResult);
    }

    protected function setUp(): void
    {
        require __DIR__ . '/../../../../../../apikey.php';

        if ($toggl_api_version !== 'v9') {
            throw new Exception('This test is only for v9');
        }

        $this->client = TogglClient::factory([
            'api_key' => $toggl_api_key,
        ]);
    }

}
