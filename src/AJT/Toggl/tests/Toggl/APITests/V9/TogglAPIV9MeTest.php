<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

/**
 * @inheritDoc
 */
class TogglAPIV9MeTest extends TogglAPIV9TestCase
{
    /**
     * https://developers.track.toggl.com/docs/api/me#get-me
     * https://developers.track.toggl.com/docs/api/me#put-me
     */
    public function testMe_get_update(): void
    {
        $me = $this->client->getMe();
        global $toggl_api_key;
        $this->assertSame($toggl_api_key, $me['api_token']);
        $this->assertArrayNotHasKey('clients', $me);
        $this->assertArrayNotHasKey('projects', $me);
        $this->assertArrayNotHasKey('tags', $me);
        $this->assertArrayNotHasKey('workspaces', $me);
        $this->assertArrayNotHasKey('time_entries', $me);

        $me_with_related_data = $this->client->getMe([
            'with_related_data' => true,
        ]);
        $this->assertArrayHasKey('clients', $me_with_related_data);
        $this->assertArrayHasKey('projects', $me_with_related_data);
        $this->assertArrayHasKey('tags', $me_with_related_data);
        $this->assertArrayHasKey('workspaces', $me_with_related_data);
        $this->assertArrayHasKey('time_entries', $me_with_related_data);

        $me_updated = $this->client->updateMe([
            'beginning_of_week' => $me['beginning_of_week'] === 1 ? 0 : 1,
            'country_id' => $me['country_id'] + 1,
            'email' => 'updated@email.com',
            'fullname' => $me['fullname'] . 'updated',
        ]);
        $this->assertSame($me['fullname'] . 'updated', $me_updated['fullname']);
        $this->client->updateMe([
            'beginning_of_week' => $me['beginning_of_week'],
            'country_id' => $me['country_id'],
            'email' => $me['email'],
            'fullname' => $me['fullname'],
        ]);
    }

    /**
     * https://developers.track.toggl.com/docs/api/me#get-clients
     */
    public function testGetClients(): void
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

        $clients_got = $this->client->getClients(['since' => time() - 1]);
        $this->assertEquals($clients_created, $clients_got->toArray());

        foreach ($clients_created as $client_created) {
            @$this->client->deleteClient([
                'workspace_id' => $this->workspace_id,
                'client_id' => $client_created['id'],
            ]);
        }
    }

    /**
     * https://developers.track.toggl.com/docs/api/me#post-closeaccount
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-features
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-users-last-known-location
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-logged
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-lostpassword
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#post-lostpassword
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#post-lostpassword-conformation
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-organizations-that-a-user-is-part-of
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-projects
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-projectspaginated
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-tags
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-tasks
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-trackreminders
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-webtimer
     */

    /**
     * https://developers.track.toggl.com/docs/api/me#get-workspaces
     */

}
