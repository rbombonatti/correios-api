<?php

function connection() 
{
    $host = 'localhost';
    $dbname = '';
    $usuario = '';
    $senha = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}

function clearString($original)
{
    $sanitized = str_replace('"', "", $original);
    $sanitized = str_replace("'", "", $sanitized);
    $sanitized = str_replace(chr(13), "", $sanitized);
    $sanitized = str_replace(chr(10), "", $sanitized);
    $sanitized = htmlspecialchars(strip_tags($sanitized));

    return $sanitized;
}

function formatStringToCurrency($original)
{
    $formated = clearString($original);
    $formated = str_replace('R$ ', '', $formated);
    $formated = str_replace(',', '.', $formated);

    return $formated;
}

function dateFormat($originalDate) 
{   
    $newDate = DateTime::createFromFormat('d/m/y', $originalDate);
    return $newDate->format('Y-m-d');
}

function formatCustomerId($originalCustomerId)
{
    $customerId = str_replace('.', '', $originalCustomerId);
    return str_replace('-', '', $customerId);

}

function insertRecord($lines) {
    try {
        $sql = "INSERT INTO customer_order 
                    (order_id,
                    customer_id,
                    delivery_date,
                    order_date,
                    order_value,
                    product_id,
                    quantity,
                    order_description) 
                VALUES "; 

        for ($i=0; $i < count($lines) ; $i++) { 
            
            if ($i === 0) continue;
            
            $dados = explode(",", $lines[$i]);
            
            $order_id = $dados[0];
            $customer_id = formatCustomerId($dados[1]);
            $delivery_date = dateFormat($dados[2]);
            $order_date = dateFormat($dados[3]);
            $order_value = formatStringToCurrency($dados[4] . ',' . $dados[5]);
            $product_id = $dados[6];
            $quantity = $dados[7];
            $order_description = clearString($dados[8] . $lines[$i+1] . $lines[$i+2]); 
            $i= $i+2;

            $sql .= "('$order_id',
                '$customer_id',
                '$delivery_date',
                '$order_date',
                '$order_value',
                '$product_id',
                '$quantity',
                '$order_description'
            ),";

        }

        $sql = substr($sql, 0, -1);
        $stmt = connection()->prepare($sql);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() . ' registros inseridos!';
        }

    } catch (PDOException $e) {
        return "\n\nErro na inserção dos dados: " . $e->getMessage();
    } 
}

if (count($argv) != 2) {
    die("\n\nErro! O comando deve ser: php read_csv_file.php [nome_do_arquivo.csv]\n\n");
}

$nomeArquivo = $argv[1];

if (!file_exists($nomeArquivo)) {
    die("O arquivo não existe: $nomeArquivo\n");
}

$linhas = file($nomeArquivo);

echo PHP_EOL;

echo insertRecord($linhas);

echo PHP_EOL . PHP_EOL . "Processo concluído." . PHP_EOL;
