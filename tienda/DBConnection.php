<?php
//Conexion a la base de datos


// Clase DBConnection 
class DBConnection {
    private $host = "localhost";
    private $username = 'root';
    private $password = '';
    private $db = 'tienda';
    private $conn = null;


    //Constructor de la clase
    public function __construct(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->conn->connect_errno) {
            throw new Exception('DB connection error: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }

    public function getConnection(){
        return $this->conn;
    }



    //extraer productos de la base de datos segun el lenguaje seleccionado 
    public function fetchProducts($lang = 'es'){
        $products = [];
        if ($lang === 'en'){
            $sql = "SELECT id, name AS title, description AS description, price AS price FROM `productosen`";
        } else {
            $sql = "SELECT id, nombre AS title, descripcion AS description, precio AS price FROM `productoses`";
        }
        $result = $this->conn->query($sql);
        if ($result === false){
            throw new Exception('DB query error: ' . $this->conn->error);
        }
        while ($row = $result->fetch_assoc()){
            if (isset($row['price'])) $row['price'] = (float)$row['price'];
            $products[] = $row;
        }
        $result->free();
        return $products;
    }

    //Ingresar los productos en la tabla HTML
    public function renderProductsTable(array $products, $lang = 'es'){
        $html = '<table border="1" cellpadding="6" cellspacing="0">';
        $html .= '<thead><tr><th>Nombre</th><th>Precio</th></tr></thead><tbody>';
        foreach ($products as $p){
            $id = isset($p['id']) ? urlencode($p['id']) : '';
            $title = htmlspecialchars($p['title']);
            $price = number_format((float)$p['price'], 2);
            $link = 'productos.php?id=' . $id . '&lang=' . urlencode($lang);
            $onclick = "document.cookie='selected_product_id={$id};path=/;max-age=86400';";
            $linkHtml = '<a href="' . htmlspecialchars($link) . '" onclick="' . htmlspecialchars($onclick) . '">' . $title . '</a>';
            $html .= "<tr><td>{$linkHtml}</td><td>" . htmlspecialchars($price) . "</td></tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }
    
    /**
     * Fetch a single product by id and language. Returns associative array or null if not found.
     * @param int $id
     * @param string $lang
     * @return array|null
     * @throws Exception
     */
    public function fetchProductById($id, $lang = 'es'){
        $id = (int)$id;
        if ($id <= 0) return null;
        if ($lang === 'en'){
            $sql = "SELECT id, name AS title, description AS description, price AS price FROM `productosen` WHERE id = {$id} LIMIT 1";
        } else {
            $sql = "SELECT id, nombre AS title, descripcion AS description, precio AS price FROM `productoses` WHERE id = {$id} LIMIT 1";
        }
        $result = $this->conn->query($sql);
        if ($result === false){
            throw new Exception('DB query error: ' . $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row && isset($row['price'])) $row['price'] = (float)$row['price'];
        $result->free();
        return $row ?: null;
    }


    // Cerramos la conexion HTML
    public function close(){
        if ($this->conn){
            $this->conn->close();
            $this->conn = null;
        }
    }
}
?>