<?php

namespace Tests\Feature;

use Tests\TestCase;

class DocsTest extends TestCase
{
    public function test_docs_live(): void
    {
        $response = $this->get(route('docs.index'));

        $response->assertStatus(200);
    }
}
