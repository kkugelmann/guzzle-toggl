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
    public function testGetProjects(): void
    {
        $uniqueId = rand(0, 1000000);
        $new_projects = [
            ['name' => 'AAA test project one' . $uniqueId],
            ['name' => 'AAA test project two' . $uniqueId],
            ['name' => 'AAA test project three' . $uniqueId],
        ];
        $projects_created = [];
        foreach ($new_projects as $new_project) {
            $project_created = $this->client->createProject([
                'workspace_id' => $this->workspace_id,
                'name' => $new_project['name'],
            ])->toArray();
            $project_created['created_at'] = $project_created['at'];
            $project_created['actual_hours'] ??= 0;
            $projects_created[] = $project_created;
        }

        $projects_listed = $this->client->getProjects([
            'workspace_id' => $this->workspace_id,
            'active' => 'both',
        ])->toArray();
        usort($projects_listed, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });
        $this->assertEquals($projects_created, $projects_listed);

        foreach ($projects_created as $project_created) {
            @$this->client->deleteProject([
                'workspace_id' => $this->workspace_id,
                'project_id' => $project_created['id'],
            ]);
        }
    }

    /**
     * https://developers.track.toggl.com/docs/api/projects#patch-workspaceprojects
     */

    /**
     * https://developers.track.toggl.com/docs/api/projects#post-workspaceprojects
     * https://developers.track.toggl.com/docs/api/projects#get-workspaceproject
     * https://developers.track.toggl.com/docs/api/projects#put-workspaceproject
     * https://developers.track.toggl.com/docs/api/projects#delete-workspaceproject
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
     * https://developers.track.toggl.com/docs/api/projects#patch-workspaceprojects
     */

    protected function setUp(): void
    {
        parent::setUp();
        // to flush your Projects in you Toggl Workspace uncomment this (WARNING: use a testing Toggl Workspace!)
        // $this->flushProjects();
    }

    private function flushProjects(): void
    {
        $projects_listed = $this->client->getProjects([
            'workspace_id' => $this->workspace_id,
            'active' => 'both',
        ])->toArray();
        foreach ($projects_listed as $project) {
            $this->client->deleteProject([
                'workspace_id' => $this->workspace_id,
                'project_id' => $project['id'],
            ]);
        }
    }

}
