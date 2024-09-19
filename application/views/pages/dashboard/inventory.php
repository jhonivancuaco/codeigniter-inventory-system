<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-sort-amount-up-alt fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['suppliers'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Suppliers</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-chart-line fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['products'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-shopping-cart fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['orders'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Orders</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-archive fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['sales_percentage'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Daily Sales Percentage</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-people-carry fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['profit_percentage'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Daily Profit Percentage</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-boxes fa-6x"></i>
                    <span class="font-weight-bold text-center">

                        <?php if (isset($reports['lowest_product_stock']['name'])): ?>
                            <span class="h2"><?php echo $reports['lowest_product_stock']['name'] ?></span>
                            <br>
                            <?php echo $reports['lowest_product_stock']['quantity'] ?> pcs in stock
                        <?php else: ?>
                            <span class="h2">No Products Available</span>
                        <?php endif; ?>

                    </span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Product With Lowest Stock</p>
                </div>
            </div>
        </div>
    </div>
</div>