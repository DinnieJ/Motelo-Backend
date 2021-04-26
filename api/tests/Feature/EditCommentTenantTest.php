<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditCommentTenantTest extends TestCase
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
        $responses = $this->json('POST', 'api/tenant/comment/update', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $this->assertEquals($message, $result);
    }

    public function testCorrectCase($data)
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $responses = $this->json('POST', 'api/tenant/comment/update', $data, ['Authorization' => "Bearer $token"]);
        $responses->assertStatus(200)
            ->assertJsonStructure([
                'message',
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
            'id' => '46',
            'comment' => 'abc'
        ];
        $this->testCorrectCase($data);
    }

    public function testUTCID02()
    {
        $data = [
            'id' => '47',
            'comment' => 'abc'
        ];
        $message = 'ID của comment không tồn tại';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID03()
    {
        $data = [
            'id' => 'abc',
            'comment' => 'abc'
        ];
        $message = 'ID của comment phải là số nguyên dương';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID04()
    {
        $data = [
            'comment' => 'abc'
        ];
        $message = 'ID của comment không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID05()
    {
        $data = [
            'id' => '46',
            'comment' => ''
        ];
        $message = 'Trường comment không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID06()
    {
        $data = [
            'id' => '99',
            'comment' => ''
        ];
        $message = 'ID của comment không tồn tại';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID07()
    {
        $data = [
            'id' => '',
            'comment' => ''
        ];
        $message = 'ID của comment phải là số nguyên dương';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID08()
    {
        $data = [
            'id' => '',
            'comment' => ''
        ];
        $message = 'ID của comment phải là số nguyên dương';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID09()
    {
        $data = [
            'id' => '',
            'comment' => ''
        ];
        $message = 'ID của comment phải là số nguyên dương';
        $this->testIncorrectCase($data, $message);
    }
}
