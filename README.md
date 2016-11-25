# PHP-Uploader

# Example

```
$time = time();
$Upload = new Upload($_FILES['image']); 
$Upload->setMaxSize(32, "MB"); 
$Upload->AllowedTypes(array("image/png", "image/gif", "image/jpeg")); 

$Upload->setName("NAME); 
$Upload->setPrefix("org_"); 
$Upload->setSuffix("_".$time); 
$Upload->setPath($dir_pics); 
$Upload->Render(); 

$Upload->setName("NAME"); 
$Upload->setPrefix("thumb_"); 
$Upload->setSuffix("_".$time); 
$Upload->setPath($dir_pics); 
$Upload->setWidth(160); 
$path = $Upload->Render(); 
```
