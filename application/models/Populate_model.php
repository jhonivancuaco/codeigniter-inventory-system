<?php

class Populate_model extends CI_Model {

    // Constructor to initialize the database connection
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Function to generate a random full name (first name + last name)
    private function getName() {
        $firstNames = ['John', 'Jane', 'Michael', 'Emily', 'Chris', 'Sarah', 'James', 'Anna', 'David', 'Jessica', 'Robert', 'Samantha', 'Daniel', 'Linda', 'Mark', 'Laura', 'Paul', 'Amy', 'Steven', 'Rachel', 'Brian', 'Megan', 'Kevin', 'Sophia', 'Jason', 'Olivia', 'Ethan', 'Chloe', 'Matthew', 'Lily', 'Alexander', 'Grace', 'Tyler', 'Isabella', 'Ryan', 'Mia', 'Luke', 'Natalie', 'Benjamin', 'Abigail'];

        $lastNames = ['Smith', 'Johnson', 'Brown', 'Taylor', 'Anderson', 'Thomas', 'Moore', 'Jackson', 'White', 'Harris', 'Martin', 'Lee', 'Walker', 'Hall', 'Allen', 'Young', 'Hernandez', 'King', 'Wright', 'Lopez', 'Hill', 'Scott', 'Green', 'Adams', 'Baker', 'Gonzalez', 'Nelson', 'Carter', 'Mitchell', 'Perez', 'Roberts', 'Turner', 'Phillips', 'Campbell', 'Parker', 'Evans', 'Edwards', 'Collins', 'Stewart', 'Morris'];

        // Randomly pick one first name and one last name
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    // Function to generate a random address with street number, street name, city, state, and zip code
    private function getAddress() {
        $streetNames = ['Main', 'Oak', 'Pine', 'Maple', 'Cedar', 'Elm', 'Willow', 'Birch', 'Lake', 'Hill', 'Sunset', 'River', 'Cherry', 'Walnut', 'Highland', 'Park', 'Washington', 'Lincoln', 'Jefferson', 'Adams', 'Franklin', 'Clinton', 'Jackson', 'Madison', 'Grant', 'Roosevelt', 'Kennedy', 'Wilson'];

        $streetTypes = ['St', 'Ave', 'Blvd', 'Rd', 'Ln', 'Dr', 'Pl', 'Terrace', 'Court', 'Way'];

        $cities = ['Springfield', 'Riverside', 'Greenwood', 'Fairview', 'Madison', 'Georgetown', 'Clinton', 'Franklin', 'Salem', 'Arlington', 'Ashland', 'Bristol', 'Cambridge', 'Dayton', 'Lexington', 'Manchester', 'Newport', 'Norfolk', 'Portland', 'Trenton'];

        $states = ['CA', 'NY', 'TX', 'FL', 'IL', 'PA', 'OH', 'GA', 'NC', 'MI'];

        // Generate a random street number, street name, city, state, and zip code
        $streetNumber = rand(100, 9999);
        $streetName = $streetNames[array_rand($streetNames)];
        $streetType = $streetTypes[array_rand($streetTypes)];
        $city = $cities[array_rand($cities)];
        $state = $states[array_rand($states)];
        $zipCode = rand(10000, 99999);

        return "$streetNumber $streetName $streetType, $city, $state $zipCode";
    }

    // Generate a random alphanumeric string of a given length
    private function randomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    // Generate a random supplier name using a combination of prefixes and suffixes
    private function randomSupplierName() {
        $prefixes = ['Global', 'United', 'Elite', 'Premium', 'Creative', 'Alpha', 'Omega', 'Royal', 'Superior', 'Dynamic'];
        $suffixes = ['Print', 'Graphics', 'Design', 'Solutions', 'Services', 'Media', 'Studios', 'Works', 'Creations', 'Productions'];

        return $prefixes[array_rand($prefixes)] . ' ' . $suffixes[array_rand($suffixes)];
    }

    // Generate a random product material name from a predefined list
    private function randomProductMaterial() {
        $materials = ['Business Cards', 'Flyers', 'Brochures', 'Posters', 'Banners', 'Stickers', 'Labels', 'Letterheads', 'Envelopes', 'Custom T-Shirts', 'Mugs with Custom Prints', 'Calendars', 'Signage', 'Notepads', 'Bookmarks', 'Greeting Cards', 'Presentation Folders', 'Roll-Up Banners', 'Invitations', 'Menus', 'Decals', 'Window Graphics', 'Vehicle Wraps', 'Vinyl Stickers', 'Canvas Prints', 'Custom Packaging', 'Photo Books', 'Wall Art', 'Certificates', 'Business Forms', 'Wedding Invitations', 'Marketing Materials', 'Graphic Design Services', 'Branding Packages', 'Logo Design', 'Custom Embroidery', 'Event Invitations', 'Trade Show Booth Graphics', 'Labels and Packaging Design', 'Catalogs', 'Annual Reports', 'Tote Bags with Prints', 'Custom Pens', '3D Printing Services', 'Heat Pressed Apparel', 'Pop-Up Display Stands', 'Vinyl Banners', 'Outdoor Signage', 'ID Cards and Badges', 'Presentation Materials'];
        return $materials[array_rand($materials)];
    }

    // Generate a random mobile number in a specific format
    private function getNumber() {
        return  '09' . substr(str_shuffle("0123456789"), 0, 9);
    }

    // Main function to populate the database with random suppliers, products, and orders
    public function populateDatabase($suppliersCount = 10, $productsCount = 100, $ordersCount = 1000) {
    
        // Check if suppliers table is empty
        $suppliersExists = $this->db->count_all('suppliers');
        if ($suppliersExists == 0 && $suppliersCount > 0) {
            $supplierIds = [];
            for ($i = 0; $i < $suppliersCount; $i++) {
                $name = $this->randomSupplierName();
                $address = $this->getAddress();
                $mobile = $this->getNumber();
                $status = 'active';
                $date = date('Y-m-d H:i:s', mt_rand(strtotime('2024-06-01'), strtotime('2024-06-30'))); // Random date in June 2024
    
                // Prepare supplier data and insert into the database
                $data = array(
                    'name' => $name,
                    'address' => $address,
                    'mobile' => $mobile,
                    'status' => $status,
                    'date_added' => $date
                );
                $this->db->insert('suppliers', $data);
                $supplierIds[] = $this->db->insert_id(); // Save the supplier ID for future use
            }
        } else {
            // If the table is not empty, retrieve the existing supplier IDs
            $suppliers = $this->db->select('id')->get('suppliers')->result_array();
            $supplierIds = array_column($suppliers, 'id');
        }

        // Check if products table is empty
        $productsExists = $this->db->count_all('products');
        if ($productsExists == 0 && $productsCount > 0) {
            $productIds = [];
            for ($i = 0; $i < $productsCount; $i++) {
                $material = $this->randomProductMaterial();
                $supplierId = $supplierIds[array_rand($supplierIds)]; // Randomly assign a supplier
    
                // Ensure product's date_added is after the supplier's date_added
                $dateAdded = date('Y-m-d H:i:s', mt_rand(strtotime('2024-07-01'), strtotime('2024-07-30'))); // Random date in July 2024
    
                // Random product pricing and stock data
                $price = rand(10, 1000); // Random price between 10 and 1000
                $additional_price = rand(50, 100); // Random additional price
                $additional_price = $additional_price > $price ? $price / 2 : $additional_price; // Ensure additional price does not exceed base price
                $quantity = rand(100, 1000); // Random quantity between 100 and 1000
    
                // Prepare product data and insert into the database
                $data = array(
                    'material' => $material,
                    'supplier_id' => $supplierId,
                    'price' => $price,
                    'additional_price' => $additional_price,
                    'quantity' => $quantity,
                    'date_added' => $dateAdded
                );
                $this->db->insert('products', $data);
                $productIds[] = $this->db->insert_id(); // Save the product ID for future use
            }
        } else {
            // If the table is not empty, retrieve the existing product IDs
            $products = $this->db->select('id')->get('products')->result_array();
            $productIds = array_column($products, 'id');
        }
    
        // Check if orders table is empty
        $ordersExists = $this->db->count_all('orders');
        if ($ordersExists == 0 && $ordersCount > 0) {
            for ($i = 0; $i < $ordersCount; $i++) {
                $transactionId = time() . mt_rand(100000, 999999); // Generate a unique transaction ID
                $name = $this->getName();
                $address = $this->getAddress();
                $mobile = $this->getNumber();
                $productId = $productIds[array_rand($productIds)]; // Randomly assign a product
    
                // Fetch product data for constraints
                $product = $this->db->get_where('products', array('id' => $productId))->row();
    
                // Ensure datePurchased is not less than product's date_added
                $datePurchased = date('Y-m-d H:i:s', mt_rand(strtotime('2024-08-01'), time())); // Random date from August 2024 to today
    
                // Ensure dateDelivered is after datePurchased and valid
                $dateDelivered = rand(0, 1) ? date('Y-m-d H:i:s', rand(strtotime($datePurchased), time())) : null;
    
                $quantity = rand(1, 10); // Random quantity between 1 and 10
    
                // Randomly assign a payment method
                $modes = array('Over-the-Counter', 'Cash On Delivery', 'Bank Transfer', 'GCash', 'PayMaya', 'Other');
                $modeOfPayment = $modes[array_rand($modes)];
    
                // Randomly assign an order status
                $statuses = array_fill(0, 6, 'Completed');
                $statuses = array_merge($statuses, array_fill(0, 3, 'Pending'));
                $statuses = array_merge($statuses, array('Returned', 'Cancelled'));
                shuffle($statuses);
                $status = array_shift($statuses);
    
                // Prepare order data and insert into the database
                $data = array(
                    'transaction_id' => $transactionId,
                    'name' => $name,
                    'address' => $address,
                    'mobile' => $mobile,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'mode_of_payment' => $modeOfPayment,
                    'status' => $status,
                    'date_purchased' => $datePurchased,
                    'date_delivered' => $status == 'Completed' ? ($dateDelivered ?: date('Y-m-d H:i:s')) : null,
                    'date_added' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('orders', $data); // Insert order into database
            }
        }
    }
    
}
