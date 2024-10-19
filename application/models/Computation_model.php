<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Computation_model extends CI_Model {

    // Fetch various reports and return them in an array
    public function get_reports() {

        $this->db->where('status', 'active');
        $query = $this->db->get('suppliers');
        $suppliers_count = $query->num_rows();

        $this->db->where('status', 'active');
        $query = $this->db->get('materials');
        $materials_count = $query->num_rows();

        $this->db->where('status', 'active');
        $query = $this->db->get('products');
        $products_count = $query->num_rows();

        $query = $this->db->get('transactions');
        $total_transactions_count = $query->num_rows();

        $this->db->where('date_delivered IS NOT NULL');
        $query = $this->db->get('transactions');
        $total_completed_transactions_count = $query->num_rows();

        $this->db->where('status', 'active');
        $this->db->where('quantity <', 100);
        $query = $this->db->get('products');
        $products_with_lowest_quantity_count = $query->num_rows();

        $data = array(
            'suppliers_count' => $suppliers_count,
            'materials_count' => $materials_count,
            'products_count' => $products_count,
            'total_transactions_count' => $total_transactions_count,
            'total_completed_transactions_count' => $total_completed_transactions_count,
            'products_with_lowest_quantity_count' => $products_with_lowest_quantity_count
        );

        return $data;
    }

    public function get_statistics() {

        // ------------------------------------------------------------------------------------------------------------------------
        // get transactions status info
        $this->db->where('status', 'completed');
        $query = $this->db->get('transactions');
        $completed_orders = $query->num_rows();

        $this->db->where('status', 'pending');
        $query = $this->db->get('transactions');
        $pending_orders = $query->num_rows();

        $this->db->where('status', 'returned');
        $query = $this->db->get('transactions');
        $returned_orders = $query->num_rows();

        $this->db->where('status', 'cancelled');
        $query = $this->db->get('transactions');
        $cancelled_orders = $query->num_rows();

        // ------------------------------------------------------------------------------------------------------------------------
        // line graph transactions

        $endDate = new DateTime();
        // Create a DateTime object for one month ago
        $startDate = (clone $endDate)->modify('- 30 days');
        // Create an array to store the dates
        $dates = [];
        // Loop from start date to end date
        while ($startDate <= $endDate) {
            // Add the current date to the array
            $dates[] = $startDate->format('Y-m-d');
            // Move to the next day
            $startDate->modify('+1 day');
        }

        $transactions = [];
        foreach ($dates as $date) {
            $this->db->where('DATE(date_delivered)', $date);
            $this->db->where('status', 'completed');
            $query = $this->db->get('transactions');
            $transactions[date('D - M j', strtotime($date))] = $query->num_rows();
        }

        $line_graph_data = array(
            'lg' => array(
                'labels' => array_keys($transactions),
                'data' => array_values($transactions)
            ),
            'sm' => array(
                'labels' => array_slice(array_keys($transactions), 16),
                'data' => array_slice(array_values($transactions), 16)
            ),
            'xs' => array(
                'labels' => array_slice(array_keys($transactions), 21),
                'data' => array_slice(array_values($transactions), 21)
            ),
        );

        // ------------------------------------------------------------------------------------------------------------------------
        // payment methods usage
        $this->db->select('mode_of_payment, COUNT(*) as count');
        $this->db->group_by('mode_of_payment');
        $query = $this->db->get('transactions');
        $mop = $query->result();

        $formattedMop = [];
        foreach ($mop as $item) {
            $formattedMop[(string)$item->mode_of_payment] = (int)$item->count;
        }
        arsort($formattedMop);
        // ------------------------------------------------------------------------------------------------------------------------
        // products with lowest quantity
        $this->db->where('status', 'active');
        $this->db->order_by('quantity', 'asc');
        $query = $this->db->get('products', 5);
        $products_with_lowest_stocks = $query->result();

        // ------------------------------------------------------------------------------------------------------------------------
        // top selling products

        $this->db->select('p.name, COUNT(*) as count');
        $this->db->order_by('count', 'desc');
        $this->db->group_by('p.name');
        $this->db->where('p.status', 'active');
        $this->db->join('products p', 'p.id = t.product_id');
        $this->db->limit(5);
        $query = $this->db->get('transactions t');
        $tsp = $query->result();

        $top_selling_products = [];
        foreach ($tsp as $_tsp) {
            $top_selling_products[$_tsp->name] = $_tsp->count;
        }
        arsort($top_selling_products);

        // ------------------------------------------------------------------------------------------------------------------------
        // counts

        $counts = $this->get_reports();
        $counts = array(
            'suppliers' => $counts['suppliers_count'],
            'materials' => $counts['materials_count'],
            'products' => $counts['products_count'],
            'transactions' => $counts['total_transactions_count']
        );
        arsort($counts);

        $data = array(
            'order_status' => array(
                'completed' => $completed_orders,
                'pending' => $pending_orders,
                'returned' => $returned_orders,
                'cancelled' => $cancelled_orders,
            ),
            'line_graph_data' => $line_graph_data,
            'mop' => array(
                'labels' => array_keys($formattedMop),
                'data' => array_values($formattedMop)
            ),
            'products_with_lowest_stocks' => $products_with_lowest_stocks,
            'orders' => array(
                'labels' => array('completed', 'pending', 'returned', 'cancelled'),
                'data' => array($completed_orders, $pending_orders, $returned_orders, $cancelled_orders)
            ),
            'top_selling_products' => array(
                'labels' => array_keys($top_selling_products),
                'data' => array_values($top_selling_products)
            ),
            'counts' => array(
                'labels' => array_keys($counts),
                'data' => array_values($counts)
            )
        );

        return $data;
    }
}
