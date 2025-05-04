<?php
session_start();
require_once '../conection/db_connect.php';
require_once '../header.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Puxa os personagens do usuário
$sql = "SELECT nome, sistema, nivel, imagem FROM personagens WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

?>

<h2>Meus Personagens</h2>

<?php if ($result->num_rows > 0): ?>
    <div>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <img src="../static/<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem do Personagem" width="150" height="150">
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($row['nome']); ?></p>
                <p><strong>Sistema:</strong> <?php echo htmlspecialchars($row['sistema']); ?></p>
                <p><strong>Nível:</strong> 
                    <?php 
                        if ($row['sistema'] === 'Ordem Paranormal') {
                            echo ($row['nivel'] * 5) . '%';
                        } else {
                            echo 'Nível ' . $row['nivel'];
                        }
                    ?>
                </p>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Você ainda não criou nenhum personagem.</p>
<?php endif; ?>

<a href="escolher_sistema.php">
    <button>Criar Personagem</button>
</a>

<?php $stmt->close(); $conn->close(); ?>
