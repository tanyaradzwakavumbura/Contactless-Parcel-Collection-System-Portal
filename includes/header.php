<div class="content-header">
    <div class="content-search">
    </div>
    <nav class="nav">
        <?php
        if(isset($_SESSION["main_account"])){
            $main_account = $_SESSION["main_account"];
            
            $details_query = $connect->prepare("SELECT * FROM users WHERE username=?");
            $details_query->execute([$main_account]);
            while($row=$details_query->fetch(PDO::FETCH_ASSOC)){
                $main_name = $row["name"];
                $main_surname = $row["surname"];
            }
            ?>
        <form method="post">
            <input type="text" name="switch_username" value="<?php echo $main_account;?>" hidden>
            <button class="nav-link" type="submit" name="switch_back" style="padding-top:12px; padding-right:20px;background: none;border: none;color: inherit;font: inherit;cursor: pointer;outline: inherit;" data-toggle="tooltip" data-placement="bottom" title="Switch Back to <?php echo $main_name." ".$main_surname;?>">
            <i data-feather="grid"></i>
        </button>
        </form>
        <?php
        }
        ?>
        <div class="dropdown dropdown-profile">
            <a href="#" class="dropdown-link" data-toggle="dropdown" data-display="static">
                <div class="avatar avatar-online"><img src="images/avatar.svg" class="rounded-circle" alt=""></div>

            </a><!-- dropdown-link -->
            <div class="dropdown-menu dropdown-menu-right tx-13">
                
                <div class="avatar avatar-lg"><img src="images/avatar.svg" class="rounded-circle" alt=""></div>
                <br>
                <h6 class="tx-semibold mg-b-5"><?php echo $name." ".$surname;?></h6>
                <p class="mg-b-25 tx-12 tx-color-03"><?php echo $main_job;?></p>

                <a href="settings" class="dropdown-item"><i data-feather="user"></i>Account Settings</a>
                <a href="logout" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>

            </div><!-- dropdown-menu -->
        </div><!-- dropdown -->

    </nav>
</div><!-- content-header -->