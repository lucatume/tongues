<?php

namespace Tongues\API\Handlers;


class NetworkSettings implements NetworkSettingsHandlerInterface
{

    /**
     * @var array
     */
    protected $blogIdsForLangIdsCache = [];

    public function handle(\WP_REST_Request $request)
    {
        if (!current_user_can('manage_network')) {
            return new \WP_REST_Response('Invalid auth', 403);
        }

        $lang_ids = $request->get_param('lang_ids');

        if (!is_array($lang_ids) || empty($lang_ids)) {
            return new \WP_REST_Response('lang_ids is missing from request or empty', 400);
        }

        array_filter($lang_ids, [$this, 'filterInvalidLangIdEntries']);

        if (empty($lang_ids)) {
            return new \WP_REST_Response('Invalid lang_ids entry', 400);
        }

        $lang_ids = $this->filterInexistentBlogsIdsEntries($lang_ids);

        if (empty($lang_ids)) {
            return new \WP_REST_Response('No blog_id specified exists', 400);
        }

        array_filter($lang_ids, [$this, 'filterUnchangedLangIdEntries']);

        if (empty($lang_ids)) {
            return new \WP_REST_Response('No lang_id changes made', 200);
        }

        return $this->updateBlogLangIds($lang_ids);
    }

    public function filterInexistentBlogsIdsEntries($langIdEntries)
    {
        $blogIds = array_map(function (array $langIdEntry) {
            return $langIdEntry['blog_id'];
        }, $langIdEntries);

        $langIdForBlog = $this->getLangIdForBlogIds($blogIds);

        $existingBlogIds = array_intersect(array_keys($langIdForBlog), $blogIds);

        if (empty($existingBlogIds)) {
            return [];
        }

        $filtered = [];
        foreach ($langIdEntries as $langIdEntry) {
            if (in_array($langIdEntry['blog_id'], $existingBlogIds)) {
                $filtered[] = $langIdEntry;
            }
        }

        return $filtered;
    }

    private function getLangIdForBlogIds($blogIds)
    {
        if (empty($this->blogIdsForLangIdsCache)) {
            /** @var \wpdb $wpdb */
            global $wpdb;

            $blogIdsIn = implode(',', array_map(function ($blogId) use ($wpdb) {
                return $wpdb->prepare('%d', $blogId);
            }, $blogIds));

            $blogIdsAndLangIds = $wpdb->get_results("SELECT blog_id, lang_id FROM {$wpdb->blogs} WHERE blog_id IN ({$blogIdsIn})");
            $this->blogIdsForLangIdsCache = array_combine(wp_list_pluck($blogIdsAndLangIds, 'blog_id'), wp_list_pluck($blogIdsAndLangIds, 'lang_id'));
        }

        return $this->blogIdsForLangIdsCache;
    }

    private function updateBlogLangIds(array $langIdEntries)
    {
        /** @var \wpdb $wpdb */
        global $wpdb;

        try {
            foreach ($langIdEntries as $langIdEntry) {
                $updated = $wpdb->update($wpdb->blogs, ['lang_id' => $langIdEntry['lang_id']], ['blog_id' => $langIdEntry['blog_id']], ['%d'], ['%d']);

                if (false === $updated) {
                    throw new \RuntimeException('There was a problem updating lang_id value to [' . $langIdEntry['lang_id'] . '] for blog_id [' . $langIdEntry['blog_id'] . ']');
                }
            }
        } catch (\RuntimeException $e) {
            return new \WP_REST_Response($e->getMessage(), 500);
        }

        return new \WP_REST_Response('lang_ids updated', 200);
    }

    protected function filterInvalidLangIdEntries($langIdEntry)
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

    protected function filterUnchangedLangIdEntries(array $langIdEntry)
    {
        return $langIdEntry['lang_id'] != $this->blogIdsForLangIdsCache[$langIdEntry['blog_id']];
    }
}