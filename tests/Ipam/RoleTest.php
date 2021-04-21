<?php

namespace CmdrSharp\NetBox\Tests\Ipam;

use CmdrSharp\NetBox\Ipam\Role;
use CmdrSharp\NetBox\Tests\NetBoxTestCase;

class RoleTest extends NetBoxTestCase
{
    /** @test */
    public function can_get_all_roles()
    {
        $query = Role::all();
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertIsNumeric($body->count);
    }

    /** @test */
    public function can_create_role_via_mass_assignment()
    {
        $model = new Role([
            'name' => 'PHPUnit Role 1',
            'slug' => 'phpunit-role-1',
            'description' => 'Test Case',
        ]);

        $query = $model->create();
        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /** @test */
    public function can_create_role_via_fluid_setters()
    {
        $query = (new Role())->setName('PHPUnit Role 2')
            ->setSlug('PHPUnit Role 2', true)
            ->setDescription('Test Case')
            ->create();

        $body = json_decode($query->getBody());

        $this->assertEquals(201, $query->getStatusCode());
        $this->assertObjectHasAttribute('id', $body);

        return $body->id;
    }

    /**
     * @test
     * @depends can_create_role_via_mass_assignment
     * @param int $id
     */
    public function can_get_one_role(int $id)
    {
        $query = Role::get($id);
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertEquals($id, $body->id);
    }

    /**
     * @test
     * @depends can_create_role_via_mass_assignment
     */
    public function can_get_role_by_name()
    {
        $query = Role::whereName('PHPUnit Role 1');
        $body = json_decode($query->getBody());

        $this->assertEquals(200, $query->getStatusCode());
        $this->assertObjectHasAttribute('count', $body);
        $this->assertEquals(1, $body->count);
    }

    /**
     * @test
     * @depends can_create_role_via_mass_assignment
     * @depends can_create_role_via_fluid_setters
     * @param int $idOne
     * @param int $idTwo
     */
    public function can_delete_roles(int $idOne, int $idTwo)
    {
        $deleteOne = Role::delete($idOne);
        $deleteTwo = Role::delete($idTwo);

        $this->assertEquals(204, $deleteOne->getStatusCode());
        $this->assertEquals(204, $deleteTwo->getStatusCode());
    }
}
