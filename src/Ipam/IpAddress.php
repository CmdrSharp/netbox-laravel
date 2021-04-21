<?php

namespace CmdrSharp\NetBox\Ipam;

use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;

class IpAddress extends NetBox
{
    use HandlesNetBoxResults;

    /** @var string */
    const API_PATH = 'api/ipam/ip-addresses/';

    /** @var array|string[] */
    protected array $fillable = [
        'address',
        'vrf',
        'tenant',
        'status',
        'role',
        'assigned_object_type',
        'assigned_object_id',
        'nat_inside',
        'nat_outside',
        'dns_name',
        'description',
    ];

    /**
     * @param string $ipAddress
     * @return $this
     */
    public function setAddress(string $ipAddress): IpAddress
    {
        $this->setAttribute('address', $ipAddress);

        return $this;
    }

    /**
     * @param int $vrf
     * @return $this
     */
    public function setVrf(int $vrf): IpAddress
    {
        $this->setAttribute('vrf', $vrf);

        return $this;
    }

    /**
     * @param int $tenant
     * @return $this
     */
    public function setTenant(int $tenant): IpAddress
    {
        $this->setAttribute('tenant', $tenant);

        return $this;
    }

    /**
     * @param string $tenant
     * @return $this
     */
    public function setTenantByName(string $tenant): IpAddress
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
    public function setStatus(string $status): IpAddress
    {
        $this->setAttribute('status', $status);

        return $this;
    }

    /**
     * @param int $role
     * @return $this
     */
    public function setRole(int $role): IpAddress
    {
        $this->setAttribute('role', $role);

        return $this;
    }

    /**
     * @param string $assignedObjectType
     * @return $this
     */
    public function setAssignedObjectType(string $assignedObjectType): IpAddress
    {
        $this->setAttribute('assigned_object_type', $assignedObjectType);

        return $this;
    }

    /**
     * @param int $assignedObjectId
     * @return $this
     */
    public function setAssignedObjectId(int $assignedObjectId): IpAddress
    {
        $this->setAttribute('assigned_object_id', $assignedObjectId);

        return $this;
    }

    /**
     * @param int $natInside
     * @return $this
     */
    public function setNatInside(int $natInside): IpAddress
    {
        $this->setAttribute('nat_inside', $natInside);

        return $this;
    }

    /**
     * @param int $natOutside
     * @return $this
     */
    public function setNatOutside(int $natOutside): IpAddress
    {
        $this->setAttribute('nat_outside', $natOutside);

        return $this;
    }

    /**
     * @param string $dnsName
     * @return $this
     */
    public function setDnsName(string $dnsName): IpAddress
    {
        $this->setAttribute('dns_name', $dnsName);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): IpAddress
    {
        $this->setAttribute('description', $description);

        return $this;
    }
}
