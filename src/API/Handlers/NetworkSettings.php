<?php

namespace Tongues\API\Handlers;


use Tongues\Exceptions\FailedDbUpdateException;
use Tongues\Interfaces\API\Handlers\NetworkSettingsHandler;
use Tongues\Interfaces\WP\Blogs;
use Tongues\Interfaces\WP\User;

class NetworkSettings implements NetworkSettingsHandler
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Blogs
     */
    protected $blogs;

    /**
     * NetworkSettings constructor.
     * @param User $user
     * @param Blogs $blogs
     */
    public function __construct(User $user, Blogs $blogs)
    {
        $this->user = $user;
        $this->blogs = $blogs;
    }

    public function handle(\WP_REST_Request $request)
    {
        if (!$this->user->can('manage_network')) {
            return new \WP_REST_Response('Invalid auth', 403);
        }

        $lang_ids = $request->get_param('lang_ids');

        if (!is_array($lang_ids) || empty($lang_ids)) {
            return new \WP_REST_Response('lang_ids is missing from request or empty', 400);
        }

        $lang_ids = array_filter($lang_ids, [$this, 'isValidLangIdEntry']);

        if (empty($lang_ids)) {
            return new \WP_REST_Response('Invalid lang_ids entry', 400);
        }

        $lang_ids = array_filter($lang_ids, [$this, 'blogExists']);

        if (empty($lang_ids)) {
            return new \WP_REST_Response('No blog_id specified exists', 400);
        }

        $lang_ids = array_filter($lang_ids, [$this, 'langIdIsChanged']);

        if (empty($lang_ids)) {
            return new \WP_REST_Response('No lang_id changes made', 200);
        }

        return $this->updateBlogLangIds($lang_ids);
    }

    private function updateBlogLangIds(array $langIdEntries)
    {
        try {
            $blogIdsAndLangIds = array_combine(array_column($langIdEntries, 'blog_id'), array_column($langIdEntries, 'lang_id'));
            $updated = $this->blogs->updateLangIdsForBlogIds($blogIdsAndLangIds);
        } catch (FailedDbUpdateException $e) {
            return new \WP_REST_Response($e->getMessage(), 500);
        }

        return new \WP_REST_Response('lang_ids updated', 200);
    }

    public function blogExists(array $langIdEntry)
    {
        $existingBlogIds = $this->blogs->getBlogIds();

        if (empty($existingBlogIds)) {
            return false;
        }

        return in_array($langIdEntry['blog_id'], $existingBlogIds);
    }

    protected function isValidLangIdEntry($langIdEntry)
    {
        if (!is_array($langIdEntry) || empty($langIdEntry)) {
            return false;
        }

        if (!(isset($langIdEntry['blog_id'])
            && is_numeric($langIdEntry['blog_id'])
            && isset($langIdEntry['lang_id'])
            && is_numeric($langIdEntry['lang_id']))
        ) {
            return false;
        }

        return true;
    }

    protected function langIdIsChanged(array $langIdEntry)
    {
        return $langIdEntry['lang_id'] != $this->blogs->getBlogLangId($langIdEntry['blog_id']);
    }
}