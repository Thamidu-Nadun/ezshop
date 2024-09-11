<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Dashboard</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
                <li>Dashboard</li>
            </ul>
        </div>
        <div class="row">
            <!-- Your Profile Views Chart -->
            <div class="col-lg-12 m-b30">
                <div class="widget-box bg-bg-color">
                    <div class="wc-title">
                        <h4>Dashboard</h4>
                    </div>
                    <?php include('card.php'); ?>
                    <?php include('chart.php'); ?>
                </div>
            </div>
            <!-- Your Profile Views Chart END-->
        </div>
        <div class="row">
                <?php include('notification.php'); ?>
        </div>
    </div>
</main>