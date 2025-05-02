<?php
require('top.inc.php');
$name='';
$categories_id='';
$mrp='';
$price='';
$qty='';
$image='';
$short_desc='';
$description='';
$meta_title='';
$meta_desc='';
$meta_keyword='';
if(isset($_GET['id']) && $_GET['id']!=''){
  $id=$_GET['id'];
  $res=$conn->query("select * from product where id='$id'");
  $row = $res->fetch_assoc();
  $categories_id=$row['categories_id'];
  $name=$row['name'];
  $mrp=$row['mrp'];
  $price=$row['price'];
  $qty=$row['qty'];
  $image=$_POST['image'];
  $short_desc=$row['short_desc'];
  $description=$row['description'];
  $meta_title=$row['meta_title'];
  $meta_desc=$row['meta_desc'];
  $meta_keyword=$row['meta_keyword'];
  }
 
if(isset($_POST['submit'])){
$name=$_POST['name'];
$categories_id=$_POST['categories_id'];
$mrp=$_POST['mrp'];
$price=$_POST['price'];
$qty=$_POST['qty'];
$image=$_POST['image'];
$short_desc=$_POST['short_desc'];
$description=$_POST['description'];
$meta_title=$_POST['meta_title'];
$meta_desc=$_POST['meta_desc'];
$meta_keyword=$_POST['meta_keyword'];
$status='1';
  if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
    try{
      if($_FILES['image']['name']!=''){
        $image=$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
        $conn->query("update product set name='$name',categories_id='$categories_id',mrp='$mrp',price='$price',qty='$qty',image='$image',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword' where id=$id");
      }
      else{
        $conn->query("update product set name='$name',categories_id='$categories_id',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword' where id=$id");

      }

    echo "sucess";
    }
    catch(Exception $a){
      echo 'Upload error : '.$a->getMessage();
      die();
    }
  }else{
  try{
    $image=$_FILES['image']['name'];
    $target_path = "media/product/" . basename($_FILES['image']['name']);
if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
    echo "File uploaded successfully!";
} else {
    echo "File upload failed!";
}

  $conn -> query("insert into product(name,categories_id,mrp,price,qty,image,short_desc,description,meta_title,meta_desc,meta_keyword,status) values('$name','$categories_id','$mrp','$price','$qty','$image','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword','$status')");
  }
  catch(Exception $e){
    echo 'Message: '.$e->getMessage();
    exit();
  }
  }
  header('location:product.php');
  die();
}

?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                          <div class="form-group">
                            <label for="categories" class="form-control-label">Categories</label>
                            <select class="form-control" name="categories_id" >                         
<option>Select Categories</option>
<?php
$res = $conn->query('select id,categories from categories order by categories desc');
while($row=$res->fetch_assoc()){
  if($row['id']==$categories_id){
    echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
  }else{
    echo "<option value=".$row['id'].">".$row['categories']."</option>";
  }
}
?>
</select>
</div>

<div class="form-group"><label for="company" class=" form-control-label">Product Name</label><input name="name" type="text" id="company" placeholder="Enter your product name" value="<?php echo $name ;?>" class="form-control" required></div>

<div class="form-group"><label for="company" class=" form-control-label">MRP</label><input name="mrp" type="text" id="company" placeholder="Enter your product mrp" value="<?php echo $mrp ;?>" class="form-control" required></div>

<div class="form-group"><label for="company" class=" form-control-label">Price</label><input name="price" type="text" id="company" placeholder="Enter your product price" value="<?php echo $price ;?>" class="form-control" required></div>

<div class="form-group"><label for="company" class=" form-control-label">Qty</label><input name="qty" type="text" id="company" placeholder="Enter your product qty" value="<?php echo $qty ;?>" class="form-control" required></div>

<div class="form-group"><label for="company" class=" form-control-label">image</label><input name="image" type="file" class="form-control"></div>

<div class="form-group"><label for="company" class=" form-control-label">Short Description</label><textarea name="short_desc" placeholder="Enter your product short description" class="form-control" required><?php echo $short_desc; ?></textarea></div>
<div class="form-group"><label for="company" class=" form-control-label">Description</label><textarea name="description" placeholder="Enter your product description" class="form-control" required><?php echo $description; ?></textarea></div>
<div class="form-group"><label for="company" class=" form-control-label">Meta Title</label><textarea name="meta_title" placeholder="Enter your product meta title" class="form-control" required><?php echo $meta_title; ?></textarea></div>
<div class="form-group"><label for="company" class=" form-control-label">Meta Description</label><textarea name="meta_desc" placeholder="Enter your product description" class="form-control" required><?php echo $meta_desc; ?></textarea></div>
<div class="form-group"><label for="company" class=" form-control-label">Meta Keyword</label><textarea name="meta_keyword" placeholder="Enter your product meta keyword" class="form-control" required><?php echo $meta_keyword; ?></textarea></div>

                           <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
</div>
<?php
require('footer.inc.php');
?>

