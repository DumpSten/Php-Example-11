

<?php

if (!isset($_GET['id']) || empty($_GET['id']) ) {
    header('Location:index.php');
    exit;
}   

$sorgu = $db->prepare('SELECT * FROM lessons WHERE id=? ');
$sorgu->execute([$_GET['id']]);
$lesson = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$lesson) {
    header('Location:index.php');
    exit;
}
$lessonCategorie = explode(',', $lesson['categories_id']);

$categories = $db->query('SELECT * FROM categories ORDER BY ad ASC')->fetchAll(PDO::FETCH_ASSOC);


if (!isset($_POST['submit'])) {
    $baslik = $_POST["baslik"] ?? null;
    $icerik = isset($_POST["icerik"]) ? $_POST["icerik"]:null;
    $onay = isset($_POST["onay"]) ? $_POST["onay"]: 0 ;
    $categories_id = isset($_POST["categories_id"]) && is_array($_POST['categories_id']) ? implode(',', $_POST["categories_id"]):null;

    if (!$baslik) {
        echo "Başlık Ekleyin";
    }elseif (!$icerik) {
        echo "İçerik Ekleyn";
    }else {
        $sorgu = $db->prepare('UPDATE lessons SET
            baslik = ?,
            icerik = ?,
            onay = ?,
            categories_id = ?
            WHERE id = ?');
        $update = $sorgu->execute([$baslik , $icerik , $onay,$categories_id ,$lesson['id']]);

        if ($update) {
            header('Location:index.php?sayfa=read&id=' .$lesson['id']);
        }else {
            echo 'Güncelleme işlemi başarısız';
        }
    }
}

/*
$sorgu = $db->prepare('UPDATE lessons SET
baslik = ?,
icerik = ?,
onay = ?
WHERE id = ?');
$update = $sorgu->execute([
    'yeni başlık' , 'yeni içerik' , 1 , 5
]);

if ($update) {
    echo 'Güncelleme işlemi başarılı ';
}else {
    echo 'Güncelleme işlemi başarısız';
}
*/


?>

<form action="" method="post">
    Başlık:<br>
    <input type="text" name='baslik'><br> <br>
    
    İçerik:<br>
    <textarea name="icerik" cols="30"
        rows="10"></textarea><br> <br>
    
    Kategorei:<br>
    <select name="categories_id[]" multiple size="6">
        <?php foreach ($categories as $categorie):?>
            <option <?php echo in_array($categorie['id'], $lessonCategorie)  ? 'selected' : '' ?> value="<?php echo $categorie['id'] ?>"><?php echo $categorie['ad'] ?></option>
        <?php endforeach; ?>    
    </select><br> <br>
    
    Onay:<br>
    <select name="onay">
        <option value="1">Onaylı</option>
        <option value="0">Onaylı Değil</option>
    </select>
    <button type="submit">Update</button>
</form>