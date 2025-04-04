<div class="row row-xs">
<div class="col-lg-4 col-md-6 mg-t-10">
    <div class="card" style="border-color:#7CB74B; border-width:1px; border-radius:10px">
        <div class="card-body pd-y-20 pd-x-25">
            <a href="view_all_pending_parceles_transporter">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                                    <?php echo $count_all_pending_parcels;?>
                                </h3>
                                <h6 class="tx-12 tx-semibold tx-uppercase tx-spacing-1 tx-primary mg-b-5">
                                    Pending Parcels
                                </h6>
                                <p class="tx-13 tx-color-03 mg-b-0"><b>Parcels Pending to be Transported</b></p>
                            </div>
                            <div class="text-right">
                                <h3 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                                 
                                </h3>
                            </div>
                        </div>
                         
                    </div>
                    <div class="col-12">
                        <div class="chart-ten">
                            <!-- Your chart content here -->
                        </div>
                    </div>
                </div>
            </a>
        </div><!-- card-body -->
    </div><!-- card -->
</div><!-- col -->

<div class="col-lg-4 col-md-6 mg-t-10">
    <div class="card" style="border-color:#7CB74B; border-width:1px; border-radius:10px">
        <div class="card-body pd-y-20 pd-x-25">
            <a href="view_all_in_transit_parcels_by_transporter">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                                   <?php echo $count_all_in_transit_parcels;?>
                                </h3>
                                <h6 class="tx-12 tx-semibold tx-uppercase tx-spacing-1 tx-primary mg-b-5">
                                    Intransit Parcels
                                </h6>
                                <p class="tx-13 tx-color-03 mg-b-0"><b>Parcels currently being transported</b></p>
                            </div>
                            <div class="text-right">
                                <h3 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                                 
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="chart-ten">
                            <!-- Your chart content here -->
                        </div>
                    </div>
                </div>
            </a>
        </div><!-- card-body -->
    </div><!-- card -->
</div><!-- col -->

<div class="col-lg-4 col-md-6 mg-t-10">
    <div class="card" style="border-color:#7CB74B; border-width:1px; border-radius:10px">
        <div class="card-body pd-y-20 pd-x-25">
            <a href="view_all_delivered_parcels_transporter">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                                   <?php echo $count_all_delievered_parcels;?>
                                </h3>
                                <h6 class="tx-12 tx-semibold tx-uppercase tx-spacing-1 tx-primary mg-b-5">
                                    Delivered Parcels
                                </h6>
                                <p class="tx-13 tx-color-03 mg-b-0"><b>Number of Available Lockers</b></p>
                            </div>
                            <div class="text-right">
                                <h3 class="tx-normal tx-rubik tx-spacing--1 mg-b-5">
                                 
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="chart-ten">
                            <!-- Your chart content here -->
                        </div>
                    </div>
                </div>
            </a>
        </div><!-- card-body -->
    </div><!-- card -->
</div><!-- col -->



    
    
    <br>
    <div class="col-lg-12 col-xl-12 text-center">
        <br>
        <img src="images/login.png" width="20%" alt="Centered Image" class="img-fluid" style="max-width: 100%; height: auto;">
        <br><br>
        <form method="POST">
        <?php
            include("includes/alert.php");
        ?>
            <div class="form-group">
                <label for="lockerSelect">Select a Province:</label>
                <select class="form-control" name="transport_province">
                    <option value="" disabled selected>Select A Province</option>
                    <?php
                    $find_all_provinces = $connect->prepare("SELECT DISTINCT(province) FROM parcels WHERE status =?");
                    $pstat = "Pending";
                    $find_all_provinces->execute([$pstat]);
                    while ($row = $find_all_provinces->fetch(PDO::FETCH_ASSOC)) {
                        $province = $row['province'];

                        $find_all_parcels_in_province = $connect->prepare("SELECT * FROM parcels WHERE province =? AND status =?");
                        $find_all_parcels_in_province->execute([$province, $pstat]);
                        $parcel_count = $find_all_parcels_in_province->rowCount();
                        echo "<option value='$province'>$province - $parcel_count</option>";
                    }
                    ?>
                   
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block" name="take_parcels_in_province_and_transport" style="border-radius: 50px; padding: 10px 20px;">Take Parcels in Province and Transport them</button>
        </form>
    </div>
  
</div><!-- row -->