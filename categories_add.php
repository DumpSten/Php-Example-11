<?php 

if (isset($_POST['ad'])) {
    if (empty($_POST['ad'])) {
        echo 'Lütfen Kategori Adı Giriniz.';
    } else {
        $sorgu=$db->prepare('INSERT INTO categories SET ad= ?');
        $add = $sorgu->execute([$_POST['ad']]);

        if ($add) {
            header('Location:index.php?sayfa=categories');
        }else {
            echo 'Kategori Eklenemedi';
        }
    }
}

?>

<form action="" method="post">

    Kategori Adı:<br>
    <input type="text" name="ad" ><br><br>
    <button type='submit' >Gönder</button>

</form>