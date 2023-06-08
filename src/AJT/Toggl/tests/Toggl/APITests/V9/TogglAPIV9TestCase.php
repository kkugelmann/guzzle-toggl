<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

use AJT\Toggl\TogglClient;
use PHPUnit\Framework\TestCase;

/**
 * Set up the following file to run this test:
 * \phpunit.xml by copying \phpunit-dist.xml and fill in the variables
 *  - toggl_api_key: See https://www.toggl.com/public/api#api_token for more information on the api key
 */
class TogglAPIV9TestCase extends TestCase
{
    protected TogglClient $client;
    protected int $workspace_id;

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
}
