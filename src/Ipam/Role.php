<?php

namespace CmdrSharp\NetBox\Ipam;

use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Traits\RequiresSlugs;

class Role extends NetBox
{
    use RequiresSlugs;

    /** @var string */
    const API_PATH = parent::API_PATH . 'ipam/roles/';

    /** @var array|string[] */
    protected array $fillable = [
        'name',
        'slug',
        'weight',
        'description',
    ];

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): Role
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @param string $slug
     * @param bool $slugify
     * @return Role
     */
    public function setSlug(string $slug, bool $slugify = true): Role
    {
        if ($slugify) {
            $slug = $this->slugify($slug);
        }

        $this->setAttribute('slug', $slug);

        return $this;
    }

    /**
     * @param int $weight
     * @return $this
     */
    public function setWeight(int $weight): Role
    {
        $this->setAttribute('weight', $weight);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Role
    {
        $this->setAttribute('description', $description);

        return $this;
    }
}
