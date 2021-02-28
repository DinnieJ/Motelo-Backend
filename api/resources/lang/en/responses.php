<?php

return [
    'auth' => [
        'email' => [
            'email' => 'Email đang bị sai định dạng',
            'required' => 'Không để trống email',
            'exists' => 'Email không tồn tại',
            'unique' => 'Email đã tồn tại'
        ],

        'password' => [
            'required' => 'Không để trống mật khẩu',
            'min' => 'Mật khẩu tối thiểu :min ký tự'
        ],
        'date_of_birth' => [
            'required' => 'Không để trống ngày sinh',
            'date' => 'Vui lòng nhập đúng định dạng ngày'
        ],
        'name' => [
            'required' => 'Không để trống tên',
            'string' => 'Nhập đúng định dạng chuỗi',
            'regex' => 'Tên không thể có số và kí tự đặc biệt'
        ],
        'address' => [
            'required' => 'Không để trống địa chỉ',
            'regex' => 'Không nhập kí tự đặc biệt cho địa chỉ ngoài dấu, - .'
        ],
        'contact' => [
            'required' => 'Không để trống liên lạc',
            'min' => 'Cần có tối thiểu :min thông tin liên lạc'
        ]
    ],
    'tenant_comment' => [
        'tenant_id' => [
            'required' => 'ID của tenant không được để trống',
            'integer' => 'ID của tenant phải là số nguyên dương',
            'exists' => 'ID của tenant không tồn tại'
        ],
        'room_id' => [
            'required' => 'ID của room không được để trống',
            'integer' => 'ID của room phải là số nguyên dương',
            'exists' => 'ID của room không tồn tại'
        ],
        'comment' => [
            'required' => 'Trường comment không được để trống'
        ],

        //for comment_id
        'id' => [
            'required' => 'ID của comment không được để trống',
            'integer' => 'ID của comment phải là số nguyên dương',
            'exists' => 'ID của comment không tồn tại'
        ]
    ]
];
