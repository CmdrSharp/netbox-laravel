<?php

namespace CmdrSharp\NetBox\Tests\Tenancy;

use CmdrSharp\NetBox\Tenancy\TenantGroup;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class TenantGroupTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_tenant_groups()
    {
        $query = TenantGroup::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_tenant_group_via_mass_assignment()
    {
        $model = new TenantGroup([
            'name' => 'PHPUnit Tenant Group 1',
            'slug' => 'phpunit-tenant-group-1',
            'description' => 'Test Case',
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function can_create_tenant_group_via_fluid_setters()
    {
        $query = (new TenantGroup())->setName('PHPUnit Tenant Group 2')
            ->setSlug('PHPUnit Tenant Group 2', true)
            ->setDescription('Test Case')
            ->create();

        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_tenant_group_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_tenant_group(int $id)
    {
        $query = TenantGroup::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_tenant_group_via_mass_assignment
     */
    public function can_get_tenant_group_by_name()
    {
        $query = TenantGroup::whereName('PHPUnit Tenant Group 1');
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_tenant_group_via_mass_assignment
     * @depends can_create_tenant_group_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_tenant_groups(int $idOne, int $idTwo)
    {
        $deleteOne = TenantGroup::delete($idOne);
        $deleteTwo = TenantGroup::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}