<?php

namespace Tests\Feature;

use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Tymon\JWTAuth\JWTAuth;

class OwnerTest extends TestCase
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

    public function testLogin()
    {
        $data = [
            'email' => 'chutro1@fpt.edu.vn',
            'password' => '12345678'
        ];
        $responses = $this->json('POST', 'api/auth/owner/login', $data);
        $responses->assertStatus(200);

    }

    public function testLogout()
    {

        $token = auth('owner')->attempt([
            'email' => 'chutro1@fpt.edu.vn',
            'password' => '12345678'
        ]);
        $responses = $this->json('POST', 'api/auth/owner/logout', [], ['Authorization' => "Bearer $token"]);
        $responses->assertStatus(200);

    }

    public function testOwnerRegister()
    {
        $data = [
            'name' => 'Nguyen Thi Mai',
            'email' => 'mainn@gmail.com',
            'date_of_birth' => '1992-02-21',
            'password' => 'mainn12345',
            'address' => '17 ngo 10 tran quoc hoan , hanoi',
            'contacts' => [
                [
                    'type' => 1,
                    'content' => '0904821099',
                ],
                [
                    'type' => 2,
                    'content' => 'fb.com/mainn',
                ]
            ]
        ];
        $responses = $this->json('POST', 'api/auth/owner/register', $data);
        $responses->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'owner'
            ]);

    }

    public function testCreateNewInn()
    {
        $token = auth('owner')->attempt([
            'email' => 'mainn@gmail.com',
            'password' => 'mainn12345'
        ]);
        $data = [
            'name' => 'Nhà trọ mai ngọc',
            'water_price' => 1500,
            'electric_price' => 1200,
            'open_hour' => 6,
            'open_minute' => 10,
            'close_hour' => 24,
            'close_minute' => 00,
            'features' => [
                1, 2, 3, 6, 7, 8, 9, 10
            ],
            'description' => 'Nhà trọ Mai Ngọc - Khu Vực Thạch Thất , thích hợp cho sinh viên các trường FPT, Đại học quốc gia',
            'address' => 'Số 31 QL21B , Thạch Thất , Hà Nội',
            'location' => [
                'lat' => '51.44444',
                'lng' => '13.55442'
            ]
        ];
        $responses = $this->json('POST', 'api/owner/inn/create', $data, ['Authorization' => "Bearer $token"]);
        $responses->assertStatus(200)
            ->assertJsonStructure([
                'message', 'inn_id'
            ]);
    }

    public function testCreateNewRoom()
    {
        $token = auth('owner')->attempt([
            'email' => 'mainn@gmail.com',
            'password' => 'mainn12345'
        ]);
        $filepath = 'C:\Users\HIEU\Documents\hard-work\Study\Spring 2021\Capstone\data test';
        $data = [
            'title' => 'Phòng trọ nhỏ 2 giường - Nhà trọ Mai Ngọc',
            'room_type_id' => 1,
            'price' => 3000000,
            'acreage' => 30,
            'description' => 'Phòng trọ nhỏ thích hợp với những bạn có nhu cầu một căn phòng với đầy đủ tiện nghi trang thiết bị hiện đại',
            'gender_type_id' => 1,
            'images' => [
                new UploadedFile($filepath . '/' . 'e97fcdc2c78835d66c9990.jpg', 'e97fcdc2c78835d66c9990.jpg', null, null, true),
                new UploadedFile($filepath . '/' . 'e11929182252d00c89435.jpg', 'e11929182252d00c89435.jpg', null, null, true),
                new UploadedFile($filepath . '/' . 'f429d2dfd8952acb738415.jpg', 'f429d2dfd8952acb738415.jpg', null, null, true),
            ]
        ];
        $responses = $this->json('POST', 'api/owner/room/create', $data, ['Authorization' => "Bearer $token"]);
        $responses->assertStatus(200);
    }
}
