# PHP-Uploader

# Example

$Upload = new Upload($_FILES['image']); 
$Upload->setMaxSize(32, "MB"); 
$Upload->AllowedTypes(array("image/png", "image/gif", "image/jpeg")); 

$Upload->setName($user_id); 
$Upload->setPrefix("org_"); 
$Upload->setSuffix("_".$time); 
$Upload->setPath($dir_pics); 
$Upload->Render(); 

$Upload->setName($user_id); 
$Upload->setPrefix("thumb_"); 
$Upload->setSuffix("_".$time); 
$Upload->setPath($dir_pics); 
$Upload->setWidth(160); 
$path = $Upload->Render(); 
