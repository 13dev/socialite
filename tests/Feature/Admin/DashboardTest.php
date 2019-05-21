<?php

namespace Tests\Feature\Admin;

use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function testDashboard()
    {
        factory(Post::class, 2)->create();
        factory(User::class, 2)->create();
        factory(Comment::class, 2)->create();

        $this->actingAsAdmin()
            ->get('/admin/dashboard')
            ->assertStatus(200)
            ->assertSee('Cette semaine')
            ->assertSee('Voir en détails')
            ->assertSee('4')
            ->assertSee('nouveaux articles')
            ->assertSee('9')
            ->assertSee('nouveaux utilisateurs')
            ->assertSee('2')
            ->assertSee('nouveaux commentaires');
    }
}
