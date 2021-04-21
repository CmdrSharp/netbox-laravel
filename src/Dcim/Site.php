<?php

namespace CmdrSharp\NetBox\Dcim;

use CmdrSharp\NetBox\NetBox;
use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Traits\HandlesNetBoxResults;
use CmdrSharp\NetBox\Traits\RequiresSlugs;

class Site extends NetBox
{
    use HandlesNetBoxResults,
        RequiresSlugs;

    /** @var string */
    const API_PATH = 'api/dcim/sites/';

    /** @var array|string[] */
    protected array $fillable = [
        'name',
        'slug',
        'status',
        'region',
        'tenant',
        'facility',
        'asn',
        'time_zone',
        'description',
        'physical_address',
        'shipping_address',
        'latitude',
        'longitude',
        'contact_name',
        'contact_phone',
        'contact_email',
        'comments',
    ];

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Site
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    /**
     * @param string $slug
     * @param bool $slugify
     * @return $this
     */
    public function setSlug(string $slug, bool $slugify = true): Site
    {
        if($slugify) {
            $slug = $this->slugify($slug);
        }

        $this->setAttribute('slug', $slug);

        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): Site
    {
        $this->setAttribute('status', $status);

        return $this;
    }

    /**
     * @param int $region
     * @return $this
     */
    public function setRegion(int $region): Site
    {
        $this->setAttribute('region', $region);

        return $this;
    }

    /**
     * @param int $tenant
     * @return $this
     */
    public function setTenant(int $tenant): Site
    {
        $this->setAttribute('tenant', $tenant);

        return $this;
    }

    /**
     * @param string $tenant
     * @return $this
     */
    public function setTenantByName(string $tenant): Site
    {
        $tenantQuery = Tenant::whereName($tenant);
        $tenant = $this->getOnlyResult($tenantQuery);

        $this->setAttribute('tenant', $tenant->id);

        return $this;
    }

    /**
     * @param string $facility
     * @return $this
     */
    public function setFacility(string $facility): Site
    {
        $this->setAttribute('facility', $facility);

        return $this;
    }

    /**
     * @param int $asn
     * @return $this
     */
    public function setAsn(int $asn): Site
    {
        $this->setAttribute('asn', $asn);

        return $this;
    }

    /**
     * @param string $timezone
     * @return $this
     */
    public function setTimezone(string $timezone): Site
    {
        $this->setAttribute('time_zone', $timezone);

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Site
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    /**
     * @param string $physicalAddress
     * @return $this
     */
    public function setPhyiscalAddress(string $physicalAddress): Site
    {
        $this->setAttribute('physical_address', $physicalAddress);

        return $this;
    }

    /**
     * @param string $shippingAddress
     * @return $this
     */
    public function setShippingAddress(string $shippingAddress): Site
    {
        $this->setAttribute('shipping_address', $shippingAddress);

        return $this;
    }

    /**
     * @param string $latitude
     * @return $this
     */
    public function setLatitude(string $latitude): Site
    {
        $this->setAttribute('latitude', $latitude);

        return $this;
    }

    /**
     * @param string $longitude
     * @return $this
     */
    public function setLongitude(string $longitude): Site
    {
        $this->setAttribute('longitude', $longitude);

        return $this;
    }

    /**
     * @param string $contactName
     * @return $this
     */
    public function setContactName(string $contactName): Site
    {
        $this->setAttribute('contact_name', $contactName);

        return $this;
    }

    /**
     * @param string $contactPhone
     * @return $this
     */
    public function setContactPhone(string $contactPhone): Site
    {
        $this->setAttribute('contact_phone', $contactPhone);

        return $this;
    }

    /**
     * @param string $contactEmail
     * @return $this
     */
    public function setContactEmail(string $contactEmail): Site
    {
        $this->setAttribute('contact_email', $contactEmail);

        return $this;
    }

    /**
     * @param string $comments
     * @return $this
     */
    public function setComments(string $comments): Site
    {
        $this->setAttribute('comments', $comments);

        return $this;
    }
}