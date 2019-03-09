<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class ContactTest extends TestCase
{


    /** @test */
    public function get_all_contacts()
    {
        $user = User::findOrFail(1);

        $response = $this->withHeaders($this->headers($user))->json('GET', '/api/contacts'); 
       
        $response->assertJSON([
          'success' => true
        ]);
    }

    /** @test */
    public function get_all_contacts_without_auth()
    {
        $response = $this->json('GET', '/api/contacts'); 
       
        $response->assertJSON([
          'success' => false,
          'reason' => 'not_logged_in'
        ]);
    }
}
