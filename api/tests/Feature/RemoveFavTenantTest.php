<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RemoveFavTenantTest extends TestCase
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
        $responses = $this->json('POST', 'api/tenant/favorite/remove', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $this->assertEquals($message, $result);
    }

    public function testCorrectCase($data)
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $responses = $this->json('POST', 'api/tenant/favorite/remove', $data, ['Authorization' => "Bearer $token"]);
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
            'room_id' => 8
        ];
        $message = [
            'message' => 'Bạn đã gỡ phòng này rồi'
        ];
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID03()
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $data = [
            'room_id' => 9
        ];
        $responses = $this->json('POST', 'api/tenant/favorite/remove', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $message = [
            'message' => 'Đã gỡ khỏi danh sách yêu thích'
        ];
        $this->assertEquals($message, $result);
        $responses->assertStatus(200);
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
            'room_id' => '12'
        ];
        $responses = $this->json('POST', 'api/tenant/favorite/remove', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $message = [
            'message' => 'Authorization Token not found'
        ];
        $this->assertEquals($message, $result);
    }

    public function testUTCID07()
    {
        $data = [
            'room_id' => 10 //not exist Room
        ];
        $message = [
            'message' => 'Bạn đã gỡ phòng này rồi'
        ];
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID08()
    {
        $token = auth('tenant')->attempt([
            'email' => 'nguoithue1@gmail.com',
            'password' => 'nguoithue1'
        ]);
        $data = [
            'room_id' => 7
        ];
        $responses = $this->json('POST', 'api/tenant/favorite/remove', $data, ['Authorization' => "Bearer $token"]);
        $result = $responses->original;
        $message = [
            'message' => 'Đã gỡ khỏi danh sách yêu thích'
        ];
        $this->assertEquals($message, $result);
        $responses->assertStatus(200);
    }

    public function testUTCID09()
    {
        $data = [
            'room_id' => 100
        ];
        $message = 'ID của phòng không tồn tại';
        $this->testIncorrectCase($data, $message);
    }


}
