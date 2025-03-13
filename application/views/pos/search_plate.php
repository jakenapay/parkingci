<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    <div class="content">
    <div class="search-section">
                <input type="text" placeholder="Enter plate number to find similar matches..." id="plateSearch">
                <button onclick="searchSimilarPlates()">Search Similar</button>
            </div>

            <h3 class="results-header">Similar Plate Numbers</h3>

            <div class="similar-results">
                <!-- Example Result 1 -->
                <div class="result-card">
                    <img src="/api/placeholder/120/90" alt="Vehicle photo" class="vehicle-image">
                    <div class="vehicle-details">
                        <div class="info-item">
                            <span class="info-label">Plate Number</span>
                            <span class="info-value plate-number">ABC 123</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Parking Code</span>
                            <span class="info-value">P-001</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Access Type</span>
                            <span class="info-value">VIP</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Entry Time</span>
                            <span class="info-value">09:30 AM</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Status</span>
                            <span class="info-value status-paid">PAID</span>
                        </div>
                    </div>
                    <button class="edit-button">Edit</button>
                    <span class="similarity-badge">90% Match</span>
                </div>

                <!-- Example Result 2 -->
                <div class="result-card">
                    <img src="/api/placeholder/120/90" alt="Vehicle photo" class="vehicle-image">
                    <div class="vehicle-details">
                        <div class="info-item">
                            <span class="info-label">Plate Number</span>
                            <span class="info-value plate-number">ABC 124</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Parking Code</span>
                            <span class="info-value">P-002</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Access Type</span>
                            <span class="info-value">Regular</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Entry Time</span>
                            <span class="info-value">10:15 AM</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Status</span>
                            <span class="info-value status-pending">PENDING</span>
                        </div>
                    </div>
                    <button class="edit-button">Edit</button>
                    <span class="similarity-badge">85% Match</span>
                </div>
            </div>

    </div>
</section>

<style>
        .content {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .search-section {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-section input {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .search-section button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-section button:hover {
            background-color: #0056b3;
        }

        .results-header {
            margin: 20px 0 10px;
            color: #666;
        }

        .similar-results {
            display: grid;
            gap: 15px;
        }

        .result-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.2s;
        }

        .result-card:hover {
            transform: translateX(5px);
            border-color: #007bff;
        }

        .vehicle-image {
            width: 120px;
            height: 90px;
            border-radius: 4px;
            object-fit: cover;
        }

        .vehicle-details {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label {
            font-size: 12px;
            color: #666;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
        }

        .plate-number {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        .status-paid {
            color: #28a745;
        }

        .status-pending {
            color: #dc3545;
        }

        .edit-button {
            padding: 8px 16px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #5a6268;
        }

        .similarity-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f8f9fa;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            color: #666;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 16px;
        }
    </style>