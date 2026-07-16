<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageRouteTest extends TestCase
{
    public function test_storage_route_serves_files_from_public_disk(): void
    {
        Storage::disk('public')->put('test-route.txt', 'hello-from-storage-route');

        $response = $this->get('/storage/test-route.txt');

        $response->assertOk();
        $response->assertHeader('content-type', 'text/plain; charset=UTF-8');
    }
}
