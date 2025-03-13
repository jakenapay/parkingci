<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Search</title>
    <script src="<?= base_url('assets/')?>dist/js/jquery-new.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e0e0e0, #f4f4f9);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            flex-direction: column;
        }
        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        #search {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            border: none;
            border-radius: 50px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            font-size: 1.1rem;
            outline: none;
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
        }
        #search:focus {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            background-color: #f9f9f9;
        }
        #gateCounts {
            width: 100%;
            max-width: 1000px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px 0;
            gap: 20px;
            overflow-x: auto;
        }
        .card {
            background: #fff;
            border: none;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            width: 200px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            transform: perspective(1000px) rotateY(0deg);
        }
        .card:hover {
            transform: perspective(1000px) rotateY(10deg);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
        }
        .card-details {
            color: #555;
        }
        .card-details div {
            margin-bottom: 10px;
            font-size: 1rem;
        }
        .card-details strong {
            color: #333;
        }
        #results {
            width: 100%;
            max-width: 1000px;
            max-height: 500px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            overflow-y: auto;
        }
        .result-card {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .result-card div {
            font-size: 0.9rem;
            color: #333;
        }
        .result-card strong {
            color: #007bff;
        }
        .result-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .placeholder {
            width: 100%;
            height: 150px;
            background: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Real-time Parking Search</h1>
    <div id="gateCounts"></div>
    <input type="text" id="search" placeholder="Search by parking code...">
    <div id="results"></div>

    <script>
        $(document).ready(function(){
            // Function to fetch and display gate counts
            function fetchGateCounts() {
                $.ajax({
                    url: "<?= base_url('ServerController/getCounts'); ?>",
                    method: "GET",
                    dataType: "json",
                    success: function(data){
                        console.log(data); // Debugging line to check data
                        let output = '';
                        // Define all gate IDs
                        const gateIds = ['G1', 'G2', 'G3', 'G4'];
                        // Create a map to store counts by GateId
                        const gateMap = gateIds.reduce((map, gateId) => {
                            map[gateId] = 0;
                            return map;
                        }, {});

                        // Update map with data
                        data.forEach(function(item){
                            gateMap[item.GateId] = item.count;
                        });

                        // Generate output from gateMap
                        gateIds.forEach(function(gateId){
                            output += `
                                <div class="card">
                                    <div class="card-details">
                                        <div><strong>Gate ID:</strong> ${gateId}</div>
                                        <div><strong>Count:</strong> ${gateMap[gateId]} Vehicles</div>
                                    </div>
                                </div>
                            `;
                        });

                        $('#gateCounts').html(output);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching gate counts: ", textStatus, errorThrown);
                    }
                });
            }

            // Function to fetch and display search results
            $('#search').on('keyup', function(){
                let query = $(this).val();
                $.ajax({
                    url: "<?= base_url('ServerController/search'); ?>",
                    method: "GET",
                    data: {query: query},
                    dataType: "json",
                    success: function(data){
                        console.log(data); // Debugging line to check data
                        let output = '';
                        if(data.length > 0){
                            data.forEach(function(item){
                                let vehicleType;
                                switch(item.vechile_cat_id) {
                                    case '1': vehicleType = 'Motorcycle'; break;
                                    case '2': vehicleType = 'Car'; break;
                                    case '3': vehicleType = 'Bus/Truck'; break;
                                    default: vehicleType = 'Unknown'; break;
                                }

                                let imgPlaceholder = item.AccessType === 'plate number' ? 
                                    `<img src="${item.picturePath}/${item.pictureName}" alt="Vehicle Image">` : 
                                    `<div class="placeholder">No Image</div>`;

                                output += `
                                    <div class="result-card">
                                        ${imgPlaceholder}
                                        <div><strong>Access Type:</strong> ${item.AccessType}</div>
                                        <div><strong>Parking Code:</strong> ${item.parking_code}</div>
                                        <div><strong>Vehicle Type:</strong> ${vehicleType}</div>
                                        <div><strong>Gate ID:</strong> ${item.GateId}</div>
                                        <div><strong>Gate Exit:</strong> ${item.GateEx}</div>
                                        <div><strong>In Time:</strong> ${new Date(item.in_time * 1000).toLocaleString()}</div>
                                        <div><strong>Out Time:</strong> ${item.out_time ? new Date(item.out_time * 1000).toLocaleString() : 'N/A'}</div>
                                        <div><strong>Total Time:</strong> ${item.total_time}</div>
                                        <div><strong>Paid Status:</strong> ${item.paid_status}</div>
                                    </div>
                                `;
                            });
                        } else {
                            output += '<div class="no-results">No results found</div>';
                        }
                        $('#results').html(output);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching search results: ", textStatus, errorThrown);
                    }
                });
            });

            // Fetch gate counts on page load and every 30 seconds
            fetchGateCounts();
            setInterval(fetchGateCounts, 30000);
        });
    </script>
</body>
</html>
