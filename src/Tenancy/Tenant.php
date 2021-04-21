<?php

namespace CmdrSharp\NetBox\Tenancy;

use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;
use CmdrSharp\NetBox\Traits\RequiresSlugs;

class Tenant extends NetBox
{
    use HandlesNetBoxResults,
        RequiresSlugs;

    /** @var string */
    const API_PATH = parent::API_PATH . 'tenancy/tenants/';

    /** @var array|string[] */
    protected array $fillable = [
        'name',
        'slug',
        'group',
        'description',
        'comments',
    ];

    /**
     * @param string $name
     * @return Tenant
     */
    public function setName(string $name): Tenant
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @param string $slug
     * @param bool $slugify
     * @return $this
     */
    public function setSlug(string $slug, bool $slugify = true): Tenant
    {
        if($slugify) {
            $slug = $this->slugify($slug);
        }

        $this->setAttribute('slug', $slug);

        return $this;
    }

    /**
     * @param int $id
     * @return Tenant
     */
    public function setGroup(int $id): Tenant
    {
        $this->setAttribute('group', $id);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setGroupByName(string $name): Tenant
    {
        $groupQuery = TenantGroup::whereName($name);
        $group = $this->getOnlyResult($groupQuery);

        $this->setAttribute('group', $group->id);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Tenant
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    /**
     * @param string $comments
     * @return $this
     */
    public function setComments(string $comments): Tenant
    {
        $this->setAttribute('comments', $comments);

        return $this;
    }
}