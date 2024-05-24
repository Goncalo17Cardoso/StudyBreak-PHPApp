<?php
defined('CONTROL' or die('Access denied'));

$db = new database();

$note = $_POST['notes'] ?? null;

$result = $db->sendNotes($note, $_SESSION['id']);

if ($result['status'] == 'success') {
    $_SESSION['success'] = 'As suas notas foram atualizas!';
    header("Location: ?page=notes_admin");
    exit;
} else {
    $_SESSION['error'] = 'Erro ao atualizar as suas notas!';
    header("Location: ?page=notes_admin");
    exit;
}
?>