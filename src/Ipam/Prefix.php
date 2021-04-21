<?php

namespace CmdrSharp\NetBox\Ipam;

use CmdrSharp\NetBox\Dcim\Site;
use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;
use Psr\Http\Message\ResponseInterface;

class Prefix extends NetBox
{
    use HandlesNetBoxResults;

    /** @var string */
    const API_PATH = 'api/ipam/prefixes/';

    /** @var array|string[] */
    protected array $fillable = [
        'prefix',
        'role',
        'site',
        'tenant',
        'vlan',
        'is_pool',
        'description',
        'vrf',
        'status'
    ];

    /**
     * @param string $prefix
     * @return ResponseInterface
     */
    public static function wherePrefix(string $prefix): ResponseInterface
    {
        return parent::where("?prefix={$prefix}");
    }

    /**
     * @param string $ip
     * @return ResponseInterface
     */
    public static function whereContains(string $ip): ResponseInterface
    {
        return parent::where("?contains={$ip}");
    }

    /**
     * @param string $prefix
     * @return ResponseInterface
     */
    public static function whereWithin(string $prefix): ResponseInterface
    {
        return parent::where("?within={$prefix}");
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix): Prefix
    {
        $this->setAttribute('prefix', $prefix);

        return $this;
    }

    /**
     * @param int $role
     * @return $this
     */
    public function setRole(int $role): Prefix
    {
        $this->setAttribute('role', $role);

        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRoleByName(string $role): Prefix
    {
        $roleQuery = Role::whereName($role);
        $role = $this->getOnlyResult($roleQuery);

        $this->setAttribute('role', $role->id);

        return $this;
    }

    /**
     * @param int $site
     * @return $this
     */
    public function setSite(int $site): Prefix
    {
        $this->setAttribute('site', $site);

        return $this;
    }

    /**
     * @param string $site
     * @return $this
     */
    public function setSiteByName(string $site): Prefix
    {
        $siteQuery = Site::whereName($site);
        $site = $this->getOnlyResult($siteQuery);

        $this->setAttribute('site', $site->id);

        return $this;
    }

    /**
     * @param int $tenant
     * @return $this
     */
    public function setTenant(int $tenant): Prefix
    {
        $this->setAttribute('tenant', $tenant);

        return $this;
    }

    /**
     * @param string $tenant
     * @return $this
     */
    public function setTenantByName(string $tenant): Prefix
    {
        $tenantQuery = Tenant::whereName($tenant);
        $tenant = $this->getOnlyResult($tenantQuery);

        $this->setAttribute('tenant', $tenant->id);

        return $this;
    }

    /**
     * @param int $vlan
     * @return $this
     */
    public function setVlan(int $vlan): Prefix
    {
        $this->setAttribute('vlan', $vlan);

        return $this;
    }

    /**
     * @param string $vlan
     * @return $this
     */
    public function setVlanByName(string $vlan): Prefix
    {
        $vlanQuery = Vlan::whereName($vlan);
        $vlan = $this->getOnlyResult($vlanQuery);

        $this->setAttribute('vlan', $vlan->id);

        return $this;
    }

    /**
     * @param bool $isPool
     * @return $this
     */
    public function setPool(bool $isPool): Prefix
    {
        $this->setAttribute('is_pool', $isPool);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Prefix
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    /**
     * @param int $vrf
     * @return $this
     */
    public function setVrf(int $vrf): Prefix
    {
        $this->setAttribute('vrf', $vrf);

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): Prefix
    {
        $this->setAttribute('status', $status);

        return $this;
    }
}
