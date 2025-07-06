<?php 
include("inc/config.php");

$sub_cat_name = $_POST['sub_cat_name'] ?? '';
$id = $_REQUEST['id'] ?? 0;

$slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($sub_cat_name)));
$slug_url = rtrim($slug_url, '-');

$base_slug = $slug_url;
$slug = $base_slug;
$i = 1;

// Make sure the table name is correct here
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_decorate_sub_category WHERE url = ? AND sub_cat_id != ?");
$stmt->execute([$slug, $id]);
$count = $stmt->fetchColumn();

while ($count > 0) {
    $slug = $base_slug . '-' . $i++;
    $stmt->execute([$slug, $id]);
    $count = $stmt->fetchColumn();
}

$url = $slug;

echo "Generated Slug: " . $url;
?>
