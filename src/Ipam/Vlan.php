<?php

namespace CmdrSharp\NetBox\Ipam;

use CmdrSharp\NetBox\Dcim\Site;
use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;

class Vlan extends NetBox
{
    use HandlesNetBoxResults;

    /** @var string */
    const API_PATH = 'api/ipam/vlans/';

    /** @var array|string[] */
    protected array $fillable = [
        'site',
        'group',
        'vid',
        'name',
        'tenant',
        'status',
        'role',
        'description',
    ];

    /**
     * @param int $site
     * @return $this
     */
    public function setSite(int $site): Vlan
    {
        $this->setAttribute('site', $site);

        return $this;
    }

    /**
     * @param string $site
     * @return $this
     */
    public function setSiteByName(string $site): Vlan
    {
        $siteQuery = Site::whereName($site);
        $site = $this->getOnlyResult($siteQuery);

        $this->setAttribute('site', $site->id);

        return $this;
    }

    /**
     * @param int $group
     * @return $this
     */
    public function setGroup(int $group): Vlan
    {
        $this->setAttribute('group', $group);

        return $this;
    }

    /**
     * @param int $vid
     * @return $this
     */
    public function setVid(int $vid): Vlan
    {
        $this->setAttribute('vid', $vid);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Vlan
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @param int $tenant
     * @return $this
     */
    public function setTenant(int $tenant): Vlan
    {
        $this->setAttribute('tenant', $tenant);

        return $this;
    }

    /**
     * @param string $tenant
     * @return $this
     */
    public function setTenantByName(string $tenant): Vlan
    {
        $tenantQuery = Tenant::whereName($tenant);
        $tenant = $this->getOnlyResult($tenantQuery);

        $this->setAttribute('tenant', $tenant->id);

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): Vlan
    {
        $this->setAttribute('status', $status);

        return $this;
    }

    /**
     * @param int $role
     * @return $this
     */
    public function setRole(int $role): Vlan
    {
        $this->setAttribute('role', $role);

        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRoleByName(string $role): Vlan
    {
        $roleQuery = Role::whereName($role);
        $role = $this->getOnlyResult($roleQuery);

        $this->setAttribute('role', $role->id);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Vlan
    {
        $this->setAttribute('description', $description);

        return $this;
    }
}
