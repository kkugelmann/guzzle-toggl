<?php

namespace AJT\Toggl\tests\Toggl\APITests\V9;

/**
 * @inheritDoc
 */
class TogglAPIV9TagsTest extends TogglAPIV9TestCase
{
    /**
     * https://developers.track.toggl.com/docs/api/tags#get-tags
     * https://developers.track.toggl.com/docs/api/tags#post-create-tag
     * https://developers.track.toggl.com/docs/api/tags#put-update-tag
     * https://developers.track.toggl.com/docs/api/tags#delete-delete-tag
     */
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

    protected function setUp(): void
    {
        parent::setUp();
        // to flush your Clients in you Toggl Workspace uncomment this (WARNING: use a testing Toggl Workspace!)
        // $this->flushTags();
    }

    private function flushTags(): void
    {
        $tag_listed = $this->client->getTags([
            'workspace_id' => $this->workspace_id,
        ]);
        foreach ($tag_listed as $tag_created) {
            @$this->client->deleteTag([
                'workspace_id' => $this->workspace_id,
                'tag_id' => $tag_created['id'],
            ]);
        }
    }

}
