<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

use AJT\Toggl\TogglClient;
use PHPUnit\Framework\TestCase;

/**
 * Set up the following file to run this test:
 * \phpunit.xml by copying \phpunit-dist.xml and fill in the variables
 * - toggl_api_key: See https://www.toggl.com/public/api#api_token for more information on the api key
 * - toggl_test_workspace_id: Print it by running this test with XDebug (or similar) and have a look at the end of the setUp() method
 */
class TogglAPIV9TestCase extends TestCase
{
    protected TogglClient $client;
    protected int $workspace_id;

    protected function setUp(): void
    {
        global $toggl_api_version;
        global $toggl_api_key;
        global $toggl_test_workspace_id;

        $toggl_api_version = 'v9';

        $this->client = TogglClient::factory([
            'api_key' => $toggl_api_key,
        ]);
        $this->workspace_id = $toggl_test_workspace_id;

        // to detect your workspace id(s), print it/them here with XDebug (or similar)
        $workspaces = $this->client->getWorkspaces();
    }
}
