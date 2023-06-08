<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

use AJT\Toggl\TogglClient;
use PHPUnit\Framework\TestCase;

/**
 * Set up the following file to run this test:
 * \phpunit.xml by copying \phpunit-dist.xml and fill in the variables
 *  - toggl_api_key: See https://www.toggl.com/public/api#api_token for more information on the api key
 */
class TogglAPIV9Test extends TestCase
{
    private TogglClient $client;
    private int $workspace_id;

    protected function setUp(): void
    {
        global $toggl_api_version;
        global $toggl_api_key;

        $toggl_api_version = 'v9';

        $this->client = TogglClient::factory([
            'api_key' => $toggl_api_key,
        ]);
        $workspaces = $this->client->getWorkspaces();
        $this->workspace_id = $workspaces[0]['id'];
    }

    public function testProject_create_get_update_delete(): void
    {
        $project_created = $this->client->createProject([
            'workspace_id' => $this->workspace_id,
            'active' => true,
            'name' => 'AAA Project',
        ]);

        $project_got = $this->client->getProject([
            'workspace_id' => $this->workspace_id,
            'project_id' => $project_created['id'],
        ]);
        $this->assertSame($project_created['name'], $project_got['name']);

        $this->assertSame(true, $project_created['is_private']);
        $update_result = $this->client->updateProject([
            'workspace_id' => $this->workspace_id,
            'project_id' => $project_created['id'],
            'name' => 'AAB Project',
        ]);
        $this->assertSame('AAB Project', $update_result['name']);

        $delete_result = $this->client->deleteProject([
            'workspace_id' => $this->workspace_id,
            'project_id' => $project_created['id'],
        ]);
        $this->assertEmpty($delete_result);
    }

    public function testClient_create_get_update_delete(): void
    {
        $client = [];
        $client['name'] = 'AAA Client';
        $client['notes'] = 'AAA Client Notes';

        $client_created = $this->client->createClient([
            'workspace_id' => $this->workspace_id,
            ...$client,
        ]);

        $client_got = $this->client->getClient([
            'workspace_id' => $this->workspace_id,
            'client_id' => $client_created['id'],
        ]);

        $this->assertSame($client['name'], $client_got['name']);

        $client['name'] = 'AAB Client';
        $client['notes'] = 'AAB Client Notes';
        $client_updated = $this->client->updateClient([
            'workspace_id' => $this->workspace_id,
            'client_id' => $client_created['id'],
            ...$client,
        ]);

        $this->assertSame($client['name'], $client_updated['name']);

        $delete_result = $this->client->deleteClient([
            'workspace_id' => $this->workspace_id,
            'client_id' => $client_created['id'],
        ]);
        $this->assertEmpty($delete_result);
    }

    public function testTag_create_get_update_delete(): void
    {
        $tag = [];
        $tag['name'] = 'AAA Tag';

        $tag_created = $this->client->createTag([
            'workspace_id' => $this->workspace_id,
            ...$tag,
        ]);

        $tag_got = $this->client->getTags([
            'workspace_id' => $this->workspace_id,
        ]);
        $tag_got = array_map(fn($tag) => $tag['name'], $tag_got->toArray());
        $this->assertContains($tag['name'], $tag_got);

        $tag['name'] = 'AAB Tag';
        $tag_updated = $this->client->updateTag([
            'workspace_id' => $this->workspace_id,
            'tag_id' => $tag_created['id'],
            ...$tag,
        ]);

        $this->assertSame($tag['name'], $tag_updated['name']);

        $delete_result = $this->client->deleteTag([
            'workspace_id' => $this->workspace_id,
            'tag_id' => $tag_created['id'],
        ]);
        $this->assertEmpty($delete_result);
    }

}
