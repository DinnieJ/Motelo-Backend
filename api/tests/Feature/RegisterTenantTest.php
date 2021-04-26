<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTenantTest extends TestCase
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
        $responses = $this->json('POST', 'api/auth/tenant/register', $data);
        $result = $responses->original;
        $this->assertEquals($message, $result);
    }

    public function testCorrectCase($data)
    {
        $responses = $this->json('POST', 'api/auth/tenant/register', $data);
        $result = $responses->original;
        $responses->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'tenant' => [
                    'name',
                    'email',
                    'date_of_birth',
                    'phone_number',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    public function testUTCID01()
    {
        $data = [
            'name' => '',
            'email' => 'abc@ex1.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Không để trống tên';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID02()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc@ex1.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Không để trống tên';
        $this->testCorrectCase($data, $message);
    }

    public function testUTCID03()
    {
        $data = [
            'name' => 'Nam123456',
            'email' => 'abc@ex2.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Tên không thể có số và kí tự đặc biệt';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID04()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abcmnp',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Email đang bị sai định dạng';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID05()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc@ex1.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Email đã tồn tại';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID06()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc1@ex.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $this->testCorrectCase($data);
    }

    public function testUTCID07()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'a.b.c123@ex.@com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Email đang bị sai định dạng';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID08()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => '',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Không để trống email';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID09()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc2@ex.com',
            'password' => '12345678',
            'date_of_birth' => '',
            'phone_number' => '12345678'
        ];
        $message = 'Không để trống ngày sinh';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID10()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc3@ex.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => ''
        ];
        $message = [

        ];
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID11()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc4@ex.com',
            'password' => '12345678',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $this->testCorrectCase($data);
    }

    public function testUTCID12()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc5@ex.com',
            'password' => '',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Không để trống mật khẩu';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID13()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc5@ex.com',
            'password' => '1234567',
            'date_of_birth' => '1991-12-25',
            'phone_number' => '12345678'
        ];
        $message = 'Mật khẩu tối thiểu 8 ký tự';
        $this->testIncorrectCase($data, $message);
    }

    public function testUTCID14()
    {
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'abc5@ex.com',
            'password' => '12345678',
            'date_of_birth' => 'abc',
            'phone_number' => '12345678'
        ];
        $message = 'Vui lòng nhập đúng định dạng ngày';
        $this->testIncorrectCase($data, $message);
    }


}
