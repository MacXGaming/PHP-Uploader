# PHP-Uploader

# Example

Image Upload
```
$time = time();
$Upload = new Upload($_FILES['image']); 
$Upload->setMaxSize(32, "MB"); 

$Upload->setName("NAME"); 
$Upload->setPrefix("org_"); 
$Upload->setSuffix("_".$time); 
$Upload->setPath($dir_pics); 
$Upload->Move(); 
```

File Upload
```
$time = time();
$Upload = new Upload($_FILES['file']); 
$Upload->setMaxSize(32, "MB"); 
$Upload->AllowedTypes(array("image/png", "image/gif", "image/jpeg")); 

$Upload->setName("NAME"); 
$Upload->setPrefix("org_"); 
$Upload->setSuffix("_".$time); 
$Upload->setPath($dir_pics); 
$Upload->Render(); 
```
