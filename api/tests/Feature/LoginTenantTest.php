<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTenantTest extends TestCase
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

    public function testIncorrectCase($email, $password, $message)
    {
        $data = [
            'email' => $email,
            'password' => $password
        ];

        $responses = $this->json('POST', 'api/auth/tenant/login', $data);
        $result = $responses->original;
        $this->assertEquals($message, $result);
    }

    public function testCorrectCase($email, $password)
    {
        $data = [
            'email' => $email,
            'password' => $password
        ];

        $responses = $this->json('POST', 'api/auth/tenant/login', $data);
        $result = $responses->original;
        $responses->assertStatus(200);
    }

    public function testUTCID01()
    {
        $email = 'abcmnp';
        $pwd = '12345678';
        $message = 'Email đang bị sai định dạng';
        $this->testIncorrectCase($email, $pwd, $message);
    }

    public function testUTCID02()
    {
        $email = 'nguoithue1@gmail.com';
        $pwd = 'nguoithue1';
        $this->testCorrectCase($email, $pwd);
    }

    public function testUTCID03()
    {
        $email = 'abc1@ex.com';
        $pwd = '12345678';
        $message = 'Email không tồn tại';
        $this->testIncorrectCase($email, $pwd, $message);
    }

    public function testUTCID04()
    {
        $email = 'a.b.c123@ex.@com';
        $pwd = '12345678';
        $message = 'Email đang bị sai định dạng';
        $this->testIncorrectCase($email, $pwd, $message);
    }

    public function testUTCID05()
    {
        $email = 'nguoithue1@gmail.com';
        $pwd = '12345678a';
        $message = [
            'message' => 'invalid_email_or_password'
        ];
        $this->testIncorrectCase($email, $pwd, $message);
    }

    public function testUTCID06()
    {
        $email = 'nguoithue1@gmail.com';
        $pwd = '';
        $message = 'Không để trống mật khẩu';
        $this->testIncorrectCase($email, $pwd, $message);
    }

    public function testUTCID07()
    {
        $email = 'abcmnp';
        $pwd = '12345678';
        $message = 'Email đang bị sai định dạng';
        $this->testIncorrectCase($email, $pwd, $message);
    }

    public function testUTCID08()
    {
        $email = '';
        $pwd = '12345678';
        $message = 'Không để trống email';
        $this->testIncorrectCase($email, $pwd, $message);
    }
}
