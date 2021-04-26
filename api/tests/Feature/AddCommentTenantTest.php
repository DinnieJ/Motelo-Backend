<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddCommentTenantTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIncorrectCase($data, $message)
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $responses = $this->json('POST', 'api/tenant/comment/add', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $this->assertEquals($message, $result);
    }

    public function testCorrectCase($data)
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $responses = $this->json('POST', 'api/tenant/comment/add', $data, ['Authorization' => "Bearer $token"]);
        $responses->assertStatus(201)
            ->assertJsonStructure([
                'messages',
                'comment' => [
                    'id',
                    'tenant_id',
                    'room_id',
                    'comment',
                    'time_context'
                ]
            ]);
    }

    public function testUTCID01()
    {
        $data = [
            'room_id' => '',
            'comment' => 'abc'
        ];
        $message = 'ID của room không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID02()
    {
        $data = [
            'room_id' => '6', //exist room
            'comment' => 'abc'
        ];
        $this->testCorrectCase($data);
    }

    public function testUTCID03()
    {
        $data = [
            'room_id' => '99',
            'comment' => 'abc'
        ];
        $message = 'ID của room không tồn tại';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID04()
    {
        $data = [
            'room_id' => 'abc',
            'comment' => 'abc'
        ];
        $message = 'ID của room phải là số nguyên dương';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID05()
    {
        $data = [
            'room_id' => '6',
            'comment' => ''
        ];
        $message = 'Trường comment không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID06()
    {
        $token = null;
        $data = [
            'room_id' => '7',
            'comment' => 'abc'
        ];
        $responses = $this->json('POST', 'api/tenant/comment/add', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $message = [
            'message' => 'Authorization Token not found'
        ];
        $this->assertEquals($message, $result);
    }

    public function testUTCID07()
    {
        $data = [
            'room_id' => '7',
            'comment' => 'abc'
        ];
        $this->testCorrectCase($data);
    }

    public function testUTCID08()
    {
        $data = [
            'room_id' => '99',
            'comment' => 'abc'
        ];
        $message = 'ID của room không tồn tại';
        $this->testIncorrectCase($data, $message);
    }

}
