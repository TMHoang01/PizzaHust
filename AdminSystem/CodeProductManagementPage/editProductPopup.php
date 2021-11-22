<?php
    $title = 'Sửa Sản Phẩm';
	$baseUrl = '../';

	$id = $msg = $name = $price =  $status_product_id = $category_id  = $image = $description ='';

    require_once('../../database/utility.php');
    require_once('../../database/define.php');
    require_once('../../database/dbhelper.php');
    require_once('form_save.php');

	$id = getGet('id');

    $sql = "select * from product where id = '$id' ";

    $category_id = getArrResult($sql)['category_id'];
    $price = getArrResult($sql)['price'];
    $name = getArrResult($sql)['name'];
    $status_product_id = getArrResult($sql)['status_product_id'];
    $description = getArrResult($sql)['description'];
    $image = getArrResult($sql)['image'];

	$sql = "select * from category";
	$categoryItems = executeResult($sql);
	$sql = " select *from status ";
	$statusList = executeResult($sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="https://t004.gokisoft.com/uploads/2021/07/1-s-1637-ico-web.jpg">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css"> -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
        <title>Sửa sản Phẩm</title>
        <style>
            @font-face {
                font-family: Monsterrat;
                src: url("../../masterial/font/Montserrat-Medium.ttf");
            }
            body{
                font-family: Monsterrat;
            }
            .product_popup{
                width: 100%;
                height: 100%;
                position: fixed;
                background-color: rgba(0, 0, 0, 0.9);
                display: flex;
                justify-self: center;
                align-items: center;
                transition: 0.5s;
            }
            .product_popup .info_card{
                position: fixed;
                width: 70%;
                height: 80%;
                left: 15%;
                top: 10%;
                background: #f2f2f2;
                border-radius: 5px;
            }
                .product_popup .info_card .close_btn{
                    color: #404040;
                    z-index: 3;
                    position: absolute;
                    right: 0;
                    font-size: 20px;
                    margin: 20px;
                    cursor: pointer;
                }
                .product_popup .info_card h3{
                    position: absolute;
                    top: 5%;
                    left: 35%;
                    height: 5%;
                }
                .panel-body{
                    position: absolute;
                    width: 100%;
                    height: 90%;
                    top: 10%;
                }
                    form{
                        position: absolute;
                        width: 100%;
                        height: 100%;
                    }
                        .left_div{
                            position: absolute;
                            width: 50%;
                            height: 80%;
                            top: 15%;
                        }
                            .form_group{
                                position: absolute;
                                width: 100%;
                                height: 10%;
                            }
                            .form_group label{
                                height: 60%;
                                width: 35%;
                                text-align: right;
                                clear: both;
                                float:left;
                                margin-right:5%;
                                margin-top: 0.5%;
                            }
                            .form_group input{
                                position: absolute;
                                width: 50%;
                                height: 100%;
                                left: 40%;
                            }
                            .form_group select{
                                position: absolute;
                                width: 50%;
                                height: 100%;
                                left: 40%;
                            }
                        .right_div{
                            position: absolute;
                            width: 50%;
                            height: 70%;
                            top: 10%;
                            left: 50%;
                        }
                            .title_of_img_card{
                                position: absolute;
                                width: 100%;
                                height: 10%;
                                top: 0;
                                text-align: center;
                            }
                            .img_card{
                                position: absolute;
                                width: 80%;
                                height: 10%;
                                top: 10%;
                                left: 10%;
                                text-align: center;
                                border: 1px  solid  #000000;
                            }
                                .img_card input{
                                    position: absolute;
                                    width: 100%;
                                    height: auto;
                                    left: 20%;
                                }
                            .img_container{
                                position: absolute;
                                width: 80%;
                                height: 70%;
                                top: 20%;
                                left: 10%;
                                text-align: center;
                                border: 1px  solid  #000000;
                            }
                                .img_container img{
                                    margin: 5px;
                                    width: 80%;
                                    max-height: 100%;
                                }
                        .bottom_div{
                            position: absolute;
                            width: 20%;
                            height: 10%;
                            left: 45%;
                            top: 85%;
                        }
        </style>
    </head>
    <body>
        <div class="product_popup" id="editProduct_popup">
            <div class="info_card">
                <a href="ProductManagementPage.php"><i class="fa fa-times close_btn" aria-hidden="true"></i></a>
                <h3>Sửa thông tin sản phẩm</h3>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="left_div">
                            <div class="form_group" style="top: 5%">
                                <label for="usr">Tên sản phẩm:</label>
                                <input required="true" type="text" class="form-control" id="usr" name="name" value="<?=$name?>">
                                <input type="text" name="id" value="<?=$id?>" hidden="true">
                            </div>
                            
                            <div class="form_group" style="top: 20%">
                                <label for="usr">Loại Sản Phẩm:</label>
                                <select class="form-control" name="category_id" id="category_id" required="true">
                                    <option value="">-- Chọn --</option>
                                    <?php
                                        foreach($categoryItems as $category) {
                                            if($category['id'] == $category_id) {
                                                echo '<option selected value="'.$category['id'].'">'.$category['name'].'</option>';
                                            } else {
                                                echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form_group" style="top: 35%">
                                <label for="description">Mô tả sản phẩm:</label>
                                <input required="true" type="text" class="form-control" id="description" name="description" value="<?=$description?>">
                            </div>
                            
                            <div class="form_group"style="top: 50%">
                                <label for="status">Trạng thái:</label>
                                <select class="form-control" name="status_product_id" id="status_product_id" required="true">
                                    <option value="">-- Chọn --</option>
                                    <?php
                                        foreach($statusList as $status) {
                                            if($status['id'] == $status_product_id) {
                                                echo '<option selected value="'.$status['id'].'">'.$status['status'].'</option>';
                                            } else {
                                                echo '<option value="'.$status['id'].'">'.$status['status'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form_group" style="top: 65%">
                                <label for="price">Giá:</label>
                                <input required="true" type="number" class="form-control" id="price" name="price" value="<?=$price?>">
                            </div>
                        </div>
                        <div class="right_div">
                            <div class="title_of_img_card">
                                <label for="image">Hình ảnh sản phẩm:</label>
                            </div>
                            <div class="img_card">
                                <input name="image" id="image" type="file" accept="image/*" onchange="loadFile(event)">
                            </div>
                            <div class="img_container">
                                <?php 
                                    echo '<img id="output"  src="../../masterial/image/thuc_don/'.$image.'"/>';
                                ?>
                                <script>
                                    var loadFile = function(event) {
                                        var output = document.getElementById('output');
                                        output.src = URL.createObjectURL(event.target.files[0]);
                                        output.onload = function() {
                                        URL.revokeObjectURL(output.src) // free memory
                                        }
                                    };
                                </script>
                            </div>
                        </div>
                        <div class="bottom_div">
                            <button class="btn btn-success" name="confirm">Xác Nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

