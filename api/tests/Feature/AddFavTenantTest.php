<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddFavTenantTest extends TestCase
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
        $responses = $this->json('POST', 'api/tenant/favorite/add', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $this->assertEquals($message, $result);
    }

    public function testCorrectCase($data)
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $responses = $this->json('POST', 'api/tenant/favorite/add', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $responses->assertStatus(200);
    }

    public function testUTCID01()
    {
        $data = [];
        $message = 'ID của phòng không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID02()
    {
        $data = [
            'room_id' => 7
        ];
        $this->testCorrectCase($data);
    }

    public function testUTCID03()
    {
        $data = [
            'room_id' => 7
        ];
        $message = [
            'message' => 'Bạn đã thêm phòng này rồi'
        ];
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID04()
    {
        $data = [
            'room_id' => 99
        ];
        $message = 'ID của phòng không tồn tại';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID05()
    {
        $data = [
            'room_id' => 'abc'
        ];
        $message = 'ID của phòng phải là số nguyên dương';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID06()
    {
        $token = null;
        $data = [
            'room_id' => 12
        ];
        $responses = $this->json('POST', 'api/tenant/favorite/add', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $message = [
            'message' => 'Authorization Token not found'
        ];
        $this->assertEquals($message, $result);
    }

    public function testUTCID07()
    {
        $data = [];
        $message = 'ID của phòng không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID08()
    {
        $data = [];
        $message = 'ID của phòng không được để trống';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID09()
    {
        $data = [
            'room_id' => 6
        ];
        $message = [
            'message' => 'Bạn đã thêm phòng này rồi'
        ];
        $this->testIncorrectCase($data, $message);
    }


}
