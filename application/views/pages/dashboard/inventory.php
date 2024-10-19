<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-sort-amount-up-alt fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['suppliers_count'] ?></span>
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
                    <span class="display-4 font-weight-bold"><?php echo $reports['materials_count'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Materials</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-shopping-cart fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['products_count'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Products</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-archive fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['total_transactions_count'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Transactions</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-people-carry fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['total_completed_transactions_count'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Total No. of Completed Transactions</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card overflow-hidden h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-between">
                    <i class="fas fa-boxes fa-6x"></i>
                    <span class="display-4 font-weight-bold"><?php echo $reports['products_with_lowest_quantity_count'] ?></span>
                </div>
                <div class="card-footer bg-pastel_red">
                    <p class="text-center text-light m-0">Products With Lowest Quantity Less Than 100</p>
                </div>
            </div>
        </div>
    </div>
</div>