<?php

namespace Tests\Unit;

use App\Models\Kategori;
use App\Models\Wilaya;
use Tests\TestCase;

class AdminModelBindingTest extends TestCase
{
    public function test_wilaya_model_exposes_users_relation(): void
    {
        $wilaya = new Wilaya();

        $relation = $wilaya->users();

        $this->assertNotNull($relation);
        $this->assertSame('wilaya_id', $relation->getForeignKeyName());
    }

    public function test_kategori_uses_id_for_admin_route_model_binding(): void
    {
        $kategori = new Kategori();

        $this->assertSame('id', $kategori->getRouteKeyName());
    }
}
