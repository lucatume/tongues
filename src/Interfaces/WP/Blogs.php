<?php

namespace Tongues\Interfaces\WP;


use Tongues\Exceptions\FailedDbUpdateException;

interface Blogs
{
    /**
     * @return array An array containing  the existing blogs `blog_ids`
     */
    public function getBlogIds();

    /**
     * @param int $blogId
     * @return int|false The blog `lang_id` value or `false` otherwise.
     */
    public function getBlogLangId($blogId);

    /**
     * @param array $blogIdsAndLangIds
     * @return int The number of rows updated
     *
     * @throws FailedDbUpdateException If the update operation failed.
     */
    public function updateLangIdsForBlogIds(array $blogIdsAndLangIds);
}