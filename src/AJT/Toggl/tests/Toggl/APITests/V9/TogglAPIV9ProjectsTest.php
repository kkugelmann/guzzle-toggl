<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

/**
 * @inheritDoc
 */
class TogglAPIV9ProjectsTest extends TogglAPIV9TestCase
{
    /**
     * https://developers.track.toggl.com/docs/api/projects#get-get-workspace-projects-users
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#post-add-an-user-into-workspace-projects-users
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#patch-patch-project-users-from-workspace
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#put-update-an-user-into-workspace-projects-users
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#delete-delete-a-project-user-from-workspace-projects-users
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#get-workspaceprojects
     */
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

    /**
     * https://developers.track.toggl.com/docs/api/projects#post-workspaceprojects
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#patch-workspaceprojects
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#get-workspaceproject
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#put-workspaceproject
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#delete-workspaceproject
     */

}
