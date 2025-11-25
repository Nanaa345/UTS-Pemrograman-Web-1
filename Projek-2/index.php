<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$data = [
    [
        "id" => 1,
        "judul" => "Whiskas Tuna 1kg",
        "konten" => "Makanan kucing rasa tuna segar, kaya omega 3."
    ],
    [
        "id" => 2,
        "judul" => "Paket Grooming Kutu",
        "konten" => "Layanan mandi anti kutu dan jamur + potong kuku."
    ],
    [
        "id" => 3,
        "judul" => "Pasir Kucing Wangi",
        "konten" => "Pasir gumpal wangi lemon 5 liter."
    ]
];

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        echo json_encode([
            "status" => "success",
            "message" => "Data dummy berhasil diambil",
            "data" => $data
        ]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        
        if(isset($input['judul']) && isset($input['konten'])) {
            $simulasi_data_baru = [
                "id" => count($data) + 1,
                "judul" => $input['judul'],
                "konten" => $input['konten']
            ];

            $data += $simulasi_data_baru;
            
            echo json_encode([
                "status" => "success", 
                "message" => "Data berhasil ditambahkan (Simulasi)", 
                "data" => $simulasi_data_baru
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if($id) {
            $found = false;
            $updated_data = [];

            foreach($data as $item) {
                if($item['id'] == $id) {
                    $found = true;
                    $updated_data = [
                        "id" => $item['id'],
                        "judul" => isset($input['judul']) ? $input['judul'] : $item['judul'],
                        "konten" => isset($input['konten']) ? $input['konten'] : $item['konten']
                    ];
                    break;
                }
            }

            if($found) {
                echo json_encode([
                    "status" => "success", 
                    "message" => "Data ID $id berhasil diupdate (Simulasi)",
                    "data" => $updated_data
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "ID tidak ditemukan di data dummy"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Parameter ID wajib ada di URL"]);
        }
        break;

    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if($id) {
            $found = false;
            foreach($data as $item) {
                if($item['id'] == $id) {
                    $found = true;
                    break;
                }
            }

            if($found) {
                echo json_encode([
                    "status" => "success", 
                    "message" => "Data ID $id berhasil dihapus (Simulasi)"
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Parameter ID wajib ada di URL"]);
        }
        break;
}
?>