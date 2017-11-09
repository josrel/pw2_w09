<?php
$command = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_SPECIAL_CHARS);
if (isset($command) && $command == 'udt') {
    $id = filter_input(INPUT_GET, 'tod', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = array('api_key' => '123', 'id' => $id);
    $categoryData = Utility::curl_post('http://localhost/pw2_w09_ws/service/category/one',
                    $data);
    /* @var $category stdClass */
    $category = json_decode($categoryData);
}

$submitUpdate = filter_input(INPUT_POST, 'btnUpdate');
if (isset($submitUpdate)) {
    $newName = filter_input(INPUT_POST, 'txtCatName');
    $data = array('api_key' => '123', 'id' => $id, 'name' => $newName);
    Utility::curl_post('http://localhost/pw2_w09_ws/service/category/update',
            $data);
    header("location:index.php?navito=category");
}
?>

<form action="" method="post">
    <fieldset>
        <legend>Update Category Data</legend>
        <label for="idTxtCatName">Category name</label>
        <input id="idTxtCatName" name="txtCatName" type="text" autofocus="" placeholder="Category Name" required="" value="<?php echo $category->name; ?>">
        <br>
        <input type="submit" name="btnUpdate" value="Update Data" class="button button-primary">
    </fieldset>
</form>