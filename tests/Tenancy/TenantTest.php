<?php

namespace CmdrSharp\NetBox\Tests\Tenancy;

use CmdrSharp\NetBox\Tenancy\Tenant;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class TenantTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_tenants()
    {
        $query = Tenant::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_tenant_via_mass_assignment()
    {
        $model = new Tenant([
            'name' => 'PHPUnit Tenant 1',
            'slug' => 'phpunit-tenant-1',
            'description' => 'Test Case',
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function can_create_tenant_via_fluid_setters()
    {
        $query = (new Tenant())->setName('PHPUnit Tenant 2')
            ->setSlug('PHPUnit Tenant 2', true)
            ->setDescription('Test Case')
            ->create();

        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_tenant_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_tenant(int $id)
    {
        $query = Tenant::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_tenant_via_mass_assignment
     */
    public function can_get_tenant_by_name()
    {
        $query = Tenant::whereName('PHPUnit Tenant 1');
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_tenant_via_mass_assignment
     * @depends can_create_tenant_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_tenants(int $idOne, int $idTwo)
    {
        $deleteOne = Tenant::delete($idOne);
        $deleteTwo = Tenant::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}
