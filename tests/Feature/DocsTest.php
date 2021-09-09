<?php

namespace Tests\Feature;

use Tests\TestCase;

class DocsTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $this->assertEquals(route('docs.index'), $response->json('docs'));
        $this->assertEquals('https://github.com/defichain-api/masternode-health', $response->json('github'));
    }

    public function test_docs_live(): void
    {
        $response = $this->get(route('docs.index'));

        $response->assertStatus(200);
    }
}
