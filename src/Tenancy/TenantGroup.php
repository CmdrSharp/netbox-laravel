<?php

namespace CmdrSharp\NetBox\Tenancy;

use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Traits\RequiresSlugs;

class TenantGroup extends NetBox
{
    use RequiresSlugs;

    /** @var string */
    const API_PATH = parent::API_PATH . 'tenancy/tenant-groups/';

    /** @var array|string[] */
    protected array $fillable = [
        'name',
        'slug',
        'parent',
        'description',
    ];

    /**
     * @param string $name
     * @return TenantGroup
     */
    public function setName(string $name): TenantGroup
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @param string $slug
     * @param bool $slugify
     * @return $this
     */
    public function setSlug(string $slug, bool $slugify = true): TenantGroup
    {
        if ($slugify) {
            $slug = $this->slugify($slug);
        }

        $this->setAttribute('slug', $slug);

        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setParent(int $id): TenantGroup
    {
        $this->setAttribute('parent', $id);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): TenantGroup
    {
        $this->setAttribute('description', $description);

        return $this;
    }
}
