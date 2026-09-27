<?php

namespace Tests\Feature\Blog;

use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    public function test_not_found_response_uses_the_blog_error_page(): void
    {
        $this->get('/page-that-does-not-exist')
            ->assertNotFound()
            ->assertSee('Blog/Error')
            ->assertSee('This page wandered off the page.');
    }
}