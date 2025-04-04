<div class="content content-components">
    <div class="container ">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View All Assets</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">View MIL Assets</h4>
            </div>
            <div class="d-none d-md-block">
                <a href="register_new_asset.php" class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="user" class="wd-10 mg-r-5"></i>Add New Assets</a>
                <a href="update_assets.php" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="user" class="wd-10 mg-r-5"></i> Update Assets</a>
            </div>
        </div>
        <hr>
        <div class="row col-12">
            <div data-label="Example" class="df-example demo-table col-md-12">
                <br>
                <table id="example1" class="table table-hover table-bordered">
                    <thead class="thead-gray-100">
                        <tr>
                            <th class="wd-20p">Code</th>
                            <th class="wd-15p">Category</th>
                            <th class="wd-25p">Asset</th>
                            <th class="wd-20p">Serial No</th>
                            <th class="wd-15p">Department</th>
                            <th class="wd-10p">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    
                                $find_mil_assets = $connect->prepare("SELECT * FROM assets WHERE status=? AND code=?");
                                $stat = "";
                                $find_mil_assets->execute([$stat,$search_item]);
                                while($row=$find_mil_assets->fetch(PDO::FETCH_ASSOC)){
                                    $aseet_code = $row["code"];
                                    $aseet_category = $row["category"];
                                    $aseet_description = $row["description"];
                                    $aseet_serial = $row["serial"];
                                    $aseet_supplier = $row["supplier"];
                                    $aseet_amount = $row["amount"];
                                    $aseet_depreciation_cat = $row["depreciation_cat"];
                                    $aseet_barcode = $row["barcode"];
                                    $aseet_date = $row["date"];
                                    $aseet_department = $row["department"];
                                    $aseet_id = $row["id"];
                                    
                                    $find_deps = $connect->prepare("SELECT * FROM departments WHERE dep_code=?");
                                    $find_deps->execute([$aseet_department]);
                                    while($row=$find_deps->fetch(PDO::FETCH_ASSOC)){
                                        $dep_name = $row["name"];
                                    }
                                    
                                    
                                    $find_owner = $connect->prepare("SELECT * FROM asset_register WHERE asset=?");
                                    $find_owner->execute([$aseet_code]);
                                    while($row=$find_owner->fetch(PDO::FETCH_ASSOC)){
                                        $asset_user_name = $row["user"];
                                    }
                                    $count_onwer = $find_owner->rowCount();
                                    
                                    if($count_onwer == 1){
                                        //Find User Details
                                        $find_user_details = $connect->prepare("SELECT * FROM users WHERE username=?");
                                        $find_user_details->execute([$asset_user_name]);
                                        while($row=$find_user_details->fetch(PDO::FETCH_ASSOC)){
                                          $owner_name = $row["name"];  
                                          $owner_surname = $row["name"];  
                                        }
                                        
                                        $onwer_fullname = $owner_name." ".$owner_surname;
                                        
                                    }else{
                                        $onwer_fullname = "Unassigned";
                                    }
                               
                                ?>

                        <tr>
                            <td><?php echo $aseet_code;?></td>
                            <td>
                                <?php echo limit_string($aseet_category,30);?>
                            </td>
                            <td>
                                <?php echo limit_string($aseet_description,30);?>
                            </td>
                            <td>
                                <?php echo limit_string($aseet_serial,45);?>
                            </td>

                            <td>
                                <?php echo limit_string($dep_name,20);?>
                            </td>

                            <td>
                                <div class="">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Options
                                        </button>
                                        
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="#view_asset_history<?php echo $aseet_id;?>" class="dropdown-item" data-toggle="modal">View Asset History</a>

                                            <a href="#view_asset_details<?php echo $aseet_id;?>" class="dropdown-item" data-toggle="modal">View Asset Details</a>

                                            

                                            <form method="post">
                                                <input type="text" hidden name="the_asset" value="<?php echo $aseet_code;?>">
                                                <button type="submit" name="open_asset" class="dropdown-item">Open Asset Record</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                                ?>
                    </tbody>
                </table>


            </div><!-- df-example -->
        </div><!-- row -->

    </div><!-- container -->
</div>