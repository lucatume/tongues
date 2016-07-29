<?php

namespace Tongues\WP;


use Tongues\Exceptions\FailedDbUpdateException;
use Tongues\Interfaces\Cache\ArrayAccessCache;

class Blogs implements \Tongues\Interfaces\WP\Blogs
{
    /**
     * @var array
     */
    protected $blogIdsForLangIdsCache = [];
    /**
     * @var \wpdb
     */
    protected $wpdb;
    /**
     * @var ArrayAccessCache
     */
    private $cache;

    public function __construct(ArrayAccessCache $cache, \wpdb $wpdb)
    {
        $this->cache = $cache;
        $this->wpdb = $wpdb;
    }

    /**
     * @return array An array containing  the existing blogs `blog_ids`
     */
    public function getBlogIds()
    {
        if (empty($this->cache['blogs']['blogIds'])) {
            $this->getBlogIdsAndLangIds();
        }

        return $this->cache['blogs']['blogIds'];
    }

    public function getBlogIdsAndLangIds()
    {
        if (empty($this->cache['blogs']['blogIdsAndLangIds'])) {
            $blogIdsAndLangIds = $this->wpdb->get_results("SELECT blog_id, lang_id FROM {$this->wpdb->blogs}");

            $blogIds = wp_list_pluck($blogIdsAndLangIds, 'blog_id');
            $langIds = wp_list_pluck($blogIdsAndLangIds, 'lang_id');

            $this->cache['blogs'] = ['blogIds' => $blogIds, 'langIds' => $langIds, 'blogIdsAndLangIds' => array_combine($blogIds, $langIds)];
        }

        return $this->cache['blogs']['blogIdsAndLangIds'];
    }

    /**
     * @param int $blogId
     * @return int|false The blog `lang_id` value or `false` otherwise.
     */
    public function getBlogLangId($blogId)
    {
        if (empty($this->cache['blogs']['blogIdsAndLangIds'])) {
            $this->getBlogIdsAndLangIds();
        }

        return $this->cache['blogs']['blogIdsAndLangIds'][$blogId];
    }

    /**
     * @param array $blogIdsAndLangIds
     * @return int The number of rows updated
     *
     * @throws FailedDbUpdateException If the update operation failed.
     */
    public function updateLangIdsForBlogIds(array $blogIdsAndLangIds)
    {
        $wpdb = $this->wpdb;
        $values = [];
        array_walk($blogIdsAndLangIds, function ($lang_id, $blog_id) use ($wpdb, &$values) {
            $values[] = $wpdb->prepare('(%d,%d)', $blog_id, $lang_id);
        });
        $values = implode(',', $values);
        $query = "INSERT INTO {$this->wpdb->blogs} (blog_id, lang_id) VALUES {$values} ON DUPLICATE KEY UPDATE lang_id=VALUES(lang_id)";
        $updated = $this->wpdb->query($query);
        if (false === $updated) {
            throw new FailedDbUpdateException('There was a problem updating lang_id values, [' . $query . ']');
        }
    }
}