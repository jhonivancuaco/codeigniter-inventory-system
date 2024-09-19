<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Computation_model extends CI_Model {

    // Fetch various reports and return them in an array
    public function get_reports() {
        // Fetch different report sections
        $order_status = $this->get_order_status();
        $lowest_product_stocks = $this->get_lowest_product_stocks(5); // Get 5 products with the lowest stock
        $top_sales = $this->get_top_sales();
        $monthly_sales = $this->get_monthly_sales();
        $sales_and_profit = $this->get_sales_and_profit();
        $highest_payment_method = $this->get_highest_payment_method();

        // Return the collected data as an associative array
        return array(
            'order_status' => $order_status,
            'lowest_product_stocks' => $lowest_product_stocks,
            'top_sales' => $top_sales,
            'monthly_sales' => $monthly_sales,
            'sales_and_profit' => $sales_and_profit,
            'highest_payment_method' => $highest_payment_method
        );
    }

    // Fetch data for the overview dashboard
    public function overview() {
        // Get various counts and percentages for the overview
        $supplier_count = $this->get_total_suppliers_count();
        $products_count = $this->get_total_products_count();
        $orders_count = $this->get_total_orders_count();
        $sales_percentage = $this->get_sales_percentage();
        $profit_percentage = $this->get_profit_percentage();
        $lowest_product_stock = $this->get_lowest_product_stocks(1); // Get the product with the lowest stock

        // Return the overview data as an associative array
        $data = array(
            'suppliers' => $supplier_count,
            'products' => $products_count,
            'orders' => $orders_count,
            'sales_percentage' => $sales_percentage,
            'profit_percentage' => $profit_percentage,
            'lowest_product_stock' => $lowest_product_stock
        );

        return $data;
    }

    // Get the count of orders based on their status
    public function get_order_status() {
        // Fetch all orders from the 'orders' table
        $query = $this->db->get('orders');
        $orders = $query->result();

        // Initialize the order status counters
        $order_status = array(
            'pending' => 0,
            'completed' => 0,
            'cancelled' => 0,
            'return' => 0
        );

        // Loop through each order and count based on their status
        foreach ($orders as $order) {
            switch ($order->status) {
                case 'Pending':
                    $order_status['pending']++;
                    break;
                case 'Completed':
                    $order_status['completed']++;
                    break;
                case 'Cancelled':
                    $order_status['cancelled']++;
                    break;
                case 'Returned':
                    $order_status['return']++;
                    break;
            }
        }

        // Return the status counts
        return $order_status;
    }

    // Get the lowest stocked products (returns the top N based on the $length parameter)
    public function get_lowest_product_stocks(int $length) {
        // Fetch all products from the 'products' table
        $query = $this->db->get('products');
        $products = $query->result();

        // Fetch all orders from the 'orders' table
        $query = $this->db->get('orders');
        $orders = $query->result();

        // Initialize an array to store product stock data
        $stocks = array();
        foreach ($products as $product) {
            $product_quantity = $product->quantity; // Start with the original product quantity

            // Subtract the quantity ordered from the product's stock
            foreach ($orders as $order) {
                if ($order->product_id == $product->id) {
                    $product_quantity -= $order->quantity; // Deduct order quantity from product stock
                }
            }

            // Add the product details to the stocks array
            $stocks[] = array(
                'name' => $product->material,
                'quantity' => $product_quantity
            );
        }

        // Sort products by quantity in ascending order
        usort($stocks, function ($a, $b) {
            return $a['quantity'] <=> $b['quantity'];
        });

        // Slice the array to get only the top N products (based on $length)
        $stocks = array_slice($stocks, 0, $length);

        // If only one product is requested, return it as a single item instead of an array
        if ($length == 1) {
            if (count($stocks) > 0) {
                $stocks = $stocks[0];
            } else {
                $stocks = array();
            }
        }

        // Return the lowest stock products
        return $stocks;
    }

    // Get the top-selling products (returns the top 6 products by sales)
    public function get_top_sales() {
        // Query to get the top-selling products based on order quantities
        $this->db->select('p.material as product_name, SUM(o.quantity) as count');
        $this->db->from('orders o');
        $this->db->join('products p', 'p.id = o.product_id');
        $this->db->group_by('o.product_id');
        $this->db->order_by('count', 'DESC');
        $this->db->limit(6); // Limit to top 6 products
        $query = $this->db->get();
        $orders = $query->result();

        // Initialize the sales data array
        $top_sales_data = array();

        if ($orders) {
            foreach ($orders as $order) {
                $top_sales_data['labels'][] = $order->product_name;
                $top_sales_data['data'][] = $order->count;
            }
        } else {
            $top_sales_data['labels'] = array('No data available');
            $top_sales_data['data'] = array(0);
        }

        return $top_sales_data;
    }

    // Get the sales data for the past month (grouped by day)
    public function get_monthly_sales() {
        // Query to get the daily sales for the last month
        $this->db->select('DATE(date_purchased) as date_purchased, SUM(quantity) as total_purchased');
        $this->db->from('orders');
        $this->db->where('date_purchased >= ', date('Y-m-d H:i:s', strtotime('-1 month')));
        $this->db->where('date_purchased <= ', date('Y-m-d H:i:s'));
        $this->db->group_by('DATE(date_purchased)');
        $query = $this->db->get();
        $orders = $query->result();

        // Initialize the monthly sales data array
        $monthly_sales_data = array();

        if ($orders) {
            foreach ($orders as $order) {
                // Format the date and add it to the labels
                $monthly_sales_data['labels'][] = date('D - M j', strtotime($order->date_purchased));
                // Add the total sales for the day
                $monthly_sales_data['data'][] = $order->total_purchased;
            }
        } else {
            $monthly_sales_data['labels'] = array(date('D - M j'));
            $monthly_sales_data['data'] = array(0);
        }

        return $monthly_sales_data;
    }

    // Get the total sales and profit data for the past month
    public function get_sales_and_profit() {
        $one_month_ago = date('Y-m-d', strtotime('-1 month'));

        // Query to fetch the orders, prices, and profit margins for the last month
        $this->db->select('o.date_delivered, o.quantity, p.price, p.additional_price');
        $this->db->from('orders o');
        $this->db->join('products p', 'p.id = o.product_id');
        $this->db->where('DATE(o.date_delivered) >=', $one_month_ago);
        $this->db->order_by('o.date_delivered', 'ASC');
        $this->db->group_by('o.date_delivered');

        $query = $this->db->get();
        $orders = $query->result();

        // Initialize an array to store sales and profit data
        $sales_and_profit = [];

        foreach ($orders as $order) {
            // Format the purchase date
            $purchase_date = date('Y-m-d', strtotime($order->date_delivered));

            // Calculate the total sales and profit for the order
            $total_sales = $order->price * $order->quantity;
            $total_profit = ($order->price - $order->additional_price) * $order->quantity;

            // Accumulate sales and profit data based on the date
            if (isset($sales_and_profit[$purchase_date])) {
                $sales_and_profit[$purchase_date]['total_sales'] += $total_sales;
                $sales_and_profit[$purchase_date]['total_profit'] += $total_profit;
            } else {
                $sales_and_profit[$purchase_date] = [
                    'total_sales' => $total_sales,
                    'total_profit' => $total_profit
                ];
            }
        }

        // Initialize arrays for graphing the data
        $sales_and_profit_data = [
            'labels' => [],
            'total_sales' => [],
            'total_profit' => []
        ];

        // Format the sales and profit data for the graph
        if (!empty($sales_and_profit)) {
            foreach ($sales_and_profit as $date => $data) {
                $sales_and_profit_data['labels'][] = date('D - M j', strtotime($date));
                $sales_and_profit_data['total_sales'][] = $data['total_sales'];
                $sales_and_profit_data['total_profit'][] = $data['total_profit'];
            }
        } else {
            $sales_and_profit_data['labels'] = array(date('D - M j'));
            $sales_and_profit_data['total_sales'] = array(0);
            $sales_and_profit_data['total_profit'] = array(0);
        }



        return $sales_and_profit_data;
    }

    // Get the most popular payment method
    public function get_highest_payment_method() {
        // Query to count how many times each payment method was used
        $this->db->select('mode_of_payment, COUNT(*) as count');
        $this->db->from('orders');
        $this->db->group_by('mode_of_payment');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get();
        $payment_method = $query->result();

        // Initialize the payment method data array
        $payment_method_data = array(
            'labels' => [],
            'data' => []
        );

        // Store payment method names and counts
        if ($payment_method) {
            foreach ($payment_method as $item) {
                $payment_method_data['labels'][] = $item->mode_of_payment;
                $payment_method_data['data'][] = $item->count;
            }
        } else {
            $payment_method_data['labels'] = array("No data available");
            $payment_method_data['data'] = array(0);
        }

        return $payment_method_data;
    }

    // Get the total count of active suppliers
    public function get_total_suppliers_count() {
        $this->db->where('status', 'active'); // Only count active suppliers
        $query = $this->db->get('suppliers');
        $supplier = $query->result();
        return count($supplier);
    }

    // Get the total count of active products
    public function get_total_products_count() {
        $this->db->where('status', 'active'); // Only count active products
        $query = $this->db->get('products');
        $supplier = $query->result();
        return count($supplier);
    }

    // Get the total number of orders
    public function get_total_orders_count() {
        $query = $this->db->get('orders');
        $supplier = $query->result();
        return count($supplier);
    }

    // Calculate the percentage change in sales between yesterday and the day before
    public function get_sales_percentage() {
        // Define dates for today, yesterday, and the day before
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $day_before_yesterday = date('Y-m-d', strtotime('-2 days'));

        // Query for yesterday's sales
        $this->db->select('COUNT(*) as total_orders');
        $this->db->where("date_purchased >= '$yesterday' AND date_purchased < '$today'");
        $query_yesterday = $this->db->get('orders');
        $yesterday_orders = $query_yesterday->row()->total_orders;

        // Query for sales the day before yesterday
        $this->db->select('COUNT(*) as total_orders');
        $this->db->where("date_purchased >= '$day_before_yesterday' AND date_purchased < '$yesterday'");
        $query_day_before = $this->db->get('orders');
        $day_before_orders = $query_day_before->row()->total_orders;

        // Calculate the percentage change
        if ($day_before_orders > 0) {
            $percentage_change = (($yesterday_orders - $day_before_orders) / $day_before_orders) * 100;
        } else {
            $percentage_change = $yesterday_orders > 0 ? 100 : 0;
        }

        return round($percentage_change) . '%';
    }

    // Calculate the percentage change in profit between yesterday and the day before
    public function get_profit_percentage() {
        // Define dates for today, yesterday, and the day before
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $day_before_yesterday = date('Y-m-d', strtotime('-2 days'));

        // Query for yesterday's profit
        $this->db->select('SUM((p.price - p.additional_price) * o.quantity) as total_profit');
        $this->db->from('orders o');
        $this->db->join('products p', 'p.id = o.product_id');
        $this->db->where("o.date_purchased >= '$yesterday' AND o.date_purchased < '$today'");
        $query_yesterday = $this->db->get();
        $yesterday_profit = $query_yesterday->row()->total_profit;

        // Query for profit the day before yesterday
        $this->db->select('SUM((p.price - p.additional_price) * o.quantity) as total_profit');
        $this->db->from('orders o');
        $this->db->join('products p', 'p.id = o.product_id');
        $this->db->where("o.date_purchased >= '$day_before_yesterday' AND o.date_purchased < '$yesterday'");
        $query_day_before = $this->db->get();
        $day_before_profit = $query_day_before->row()->total_profit;

        // Calculate the percentage change in profit
        if ($day_before_profit > 0) {
            $percentage_change = (($yesterday_profit - $day_before_profit) / $day_before_profit) * 100;
        } else {
            $percentage_change = $yesterday_profit > 0 ? 100 : 0;
        }

        return round($percentage_change) . '%';
    }
}
