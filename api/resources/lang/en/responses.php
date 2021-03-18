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
    ],
    'list_room' => [
        'gender' => [
            'integer' => 'Mã giới tính không hợp lệ',
            'exists' => 'Mã giới tính không tồn tại'
        ],
        'room_type' => [
            'regex' => 'Mã loại phòng phải ghi ở dạng số cách biệt bởi dấu ,',
            'in' => 'Mã loại phòng không tồn tại'
        ],
        'min_price' => [
            'numeric' => 'Giá tối thiểu không hợp lệ'
        ],
        'max_price' => [
            'numeric' => 'Giá tối đa không hợp lệ'
        ],
        'features' => [
            'regex' => 'Mã thuộc tính phòng phải ghi ở dạng số cách biệt bởi dấu ,',
            'in' => 'Mã thuộc tính phòng không tồn tại',
        ]
    ],
    'favorite' => [
        'room_id' => [
            'required' => 'ID của phòng không được để trống',
            'integer' => 'ID của phòng phải là số nguyên dương',
            'exists' => 'ID của phòng không tồn tại'
        ]
    ],
    'inn' => [
        'name' => [
            'required' => 'Không để trống tên nhà trọ'
        ],
        'water_price' => [
            'required' => 'Không để trống giá nước',
            'numeric' => 'Giá nước phải là số',
            'gt' => 'Giá nước phải là số dương'
        ],
        'electric_price' => [
            'required' => 'Không để trống giá điện',
            'numeric' => 'Giá điện phải là số',
            'gt' => 'Giá điện phải là số dương'
        ],
        'open_hour' => [
            'required' => 'Không để trống giờ mở cửa',
            'integer' => 'Giờ mở cửa phải là số dương',
        ],
        'close_hour' => [
            'required' => 'Không để trống giờ đóng cửa',
            'integer' => 'Giờ đóng cửa phải là số dương',
        ],
        'open_minute' => [
            'required' => 'Không để trống phút mở cửa',
            'integer' => 'Phút mở cửa phải là số dương',
        ],
        'close_minute' => [
            'required' => 'Không để trống phút đóng cửa',
            'integer' => 'Phút đóng cửa phải là số dương',
        ],
        'address' => [
            'required' => 'Không để trống địa chỉ nhà'
        ],
        'location' => [
            'required' => 'Không để trống địa chỉ map'
        ],
        'features' => [
            'required' => 'Không để trống tiện ích'
        ],
        'images' => [
            'required' => 'Không để trống ảnh'
        ]
    ],
    'room' => [
        'id' => [
            'required' => 'Thiếu id phòng',
            'exists' => 'ID phòng không tồn tại',
            'numeric' => 'ID phòng phải là số',
            'verified' => 'Phòng đã được xác thực'
        ],
        'title' => [
            'required' => 'Tên phòng trọ không được để trống'
        ],
        'room_type_id' => [
            'required' => 'Không được để trống loại phòng',
            'integer' => 'Loại phòng phải được đánh dấu là mã số',
            'exists' => 'Không tồn tại mã số cho loại phòng này'
        ],
        'price' => [
            'required' => 'Không để trống giá',
            'numeric' => 'Giá phòng phải là số'
        ],
        'acreage' => [
            'required' => 'Không để trống diện tích',
            'numeric' => 'Diện tích phòng phải là số'
        ],
        'description' => [
            'required' => 'Không để trống miêu tả phòng'
        ],
        'gender_type_id' => [
            'required' => 'Không để trống trường giới tính',
            'integer' => 'Giới tính phải là mã số',
            'exists' => 'Không tồn tại mã số giới tính này'
        ],
        'images' => [
            'required' => 'Không để trống ảnh'
        ]
    ],

    'utility' => [
        'utility_type_id' => [
            'required' => 'Mã loại tiện ích bị thiếu',
            'numeric' => 'Mã loại tiện ích phải là số',
            'exists' => 'Mã loại tiện ích không tồn tại'
        ],
        'title' => [
            'required' => 'Tên tiện ích bị thiếu'
        ],
        'description' => [
            'required' => 'Miêu tả bị thiếu'
        ],
        'location' => [
            'required' => 'Thiếu tọa độ'
        ]
    ],
];
