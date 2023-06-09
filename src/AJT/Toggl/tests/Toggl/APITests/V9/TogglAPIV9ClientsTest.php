<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

/**
 * @inheritDoc
 */
class TogglAPIV9ClientsTest extends TogglAPIV9TestCase
{
    /**
     * https://developers.track.toggl.com/docs/api/clients#get-list-clients
     */
    public function testListClients(): void
    {
        $new_clients = [
            ['name' => 'AAA test client one'],
            ['name' => 'AAA test client two'],
            ['name' => 'AAA test client three'],
        ];
        $clients_created = [];
        foreach ($new_clients as $new_client) {
            $clients_created[] = $this->client->createClient([
                'workspace_id' => $this->workspace_id,
                'name' => $new_client['name'],
            ])->toArray();
        }

        $clients_listed = $this->client->listClients([
            'workspace_id' => $this->workspace_id,
        ]);
        $this->assertEquals($clients_created, $clients_listed->toArray());

        foreach ($clients_created as $client_created) {
            @$this->client->deleteClient([
                'workspace_id' => $this->workspace_id,
                'client_id' => $client_created['id'],
            ]);
        }
    }

    /**
     * https://developers.track.toggl.com/docs/api/clients#post-create-client
     * https://developers.track.toggl.com/docs/api/clients#get-load-client-from-id
     * https://developers.track.toggl.com/docs/api/clients#put-change-client
     * https://developers.track.toggl.com/docs/api/clients#delete-delete-client
     */
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

    /**
     * https://developers.track.toggl.com/docs/api/clients#post-archives-client
     */

    /**
     * https://developers.track.toggl.com/docs/api/clients#post-restores-client-and-related-projects
     */

}
