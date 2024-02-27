<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del cuerpo de la solicitud en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Realiza la validación de los datos (puedes agregar más validaciones según tus necesidades)
    $username = isset($data['username']) ? $data['username'] : '';
    $password = isset($data['password']) ? $data['password'] : '';

    if (empty($username) || empty($password)) {
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Campos de usuario o contraseña vacíos'));
        exit;
    }

    // Hash de la contraseña (asegúrate de usar un método seguro en un entorno de producción)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepara la declaración SQL para la inserción
    $stmt = $conn->prepare("INSERT INTO usuario (Nombre, Contraseña) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    // Ejecuta la declaración SQL
    if ($stmt->execute()) {
        // Envía una respuesta de éxito
        http_response_code(200);
        echo json_encode(array('message' => 'Usuario registrado exitosamente'));
    } else {
        // Envía una respuesta de error
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Error al registrar el usuario'));
    }
    error_log("Solicitud recibida desde: " . $_SERVER['REMOTE_ADDR']);
    error_log("Datos del POST: " . print_r($_POST, true));
    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si la solicitud no es de tipo POST, devuelve un error
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Método no permitido'));
}
