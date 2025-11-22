<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['owner_id'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['add'])){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];
    $connector = $_POST['connector_types'];
    $max_power = $_POST['max_power'];
    $owner_id = $_SESSION['owner_id'];

    $sql = "INSERT INTO stations (owner_id, name, latitude, longitude, address, connector_types, max_power) 
            VALUES ($owner_id, '$name', '$lat', '$lng', '$address', '$connector', '$max_power')";

    if($conn->query($sql)){
        $message = "Station Added Successfully!";
        $message_type = "success";
    } else {
        $message = "Error: " . $conn->error;
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Station</title>
    <meta charset="UTF-8">
    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            min-height: 100vh;
            background: radial-gradient(circle at top left, #00e676 0, #001219 45%, #000814 100%);
            color: #e5f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .wrapper{
            width: 100%;
            max-width: 900px;
        }
        .dashboard-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            color: #e0f2f1;
        }
        .app-title{
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .app-logo{
            width: 36px;
            height: 36px;
            border-radius: 999px;
            background: radial-gradient(circle at 30% 30%, #a7ff83, #00e676, #00bfa5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #001219;
            font-size: 18px;
        }
        .app-title h1{
            font-size: 20px;
            font-weight: 600;
        }
        .app-title span{
            font-size: 12px;
            color: #b2dfdb;
        }
        .top-actions a{
            text-decoration: none;
            color: #e0f2f1;
            font-size: 13px;
            margin-left: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(224, 242, 241, 0.25);
            background: rgba(0, 0, 0, 0.25);
        }
        .top-actions a:hover{
            border-color: #00e676;
        }

        .card{
            background: linear-gradient(135deg, rgba(7, 26, 48, 0.95), rgba(1, 22, 39, 0.98));
            border-radius: 18px;
            padding: 22px 24px 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.45);
            border: 1px solid rgba(0, 230, 118, 0.25);
        }
        .card-header{
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
        }
        .card-title{
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .card-title h2{
            font-size: 18px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .pill{
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 999px;
            background: rgba(0, 230, 118, 0.08);
            border: 1px solid rgba(0, 230, 118, 0.4);
            color: #b9fbc0;
        }
        .card-title p{
            font-size: 12px;
            color: #b0bec5;
        }
        .card-meta{
            text-align: right;
            font-size: 11px;
            color: #90a4ae;
        }
        .badge{
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(3, 218, 198, 0.12);
            border: 1px solid rgba(3, 218, 198, 0.4);
            margin-bottom: 4px;
        }
        .badge-dot{
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #00e5ff;
        }

        .status-message{
            font-size: 13px;
            margin-bottom: 16px;
            padding: 10px 12px;
            border-radius: 10px;
        }
        .status-success{
            background: rgba(0, 230, 118, 0.08);
            border: 1px solid rgba(0, 230, 118, 0.4);
            color: #b9fbc0;
        }
        .status-error{
            background: rgba(255, 82, 82, 0.08);
            border: 1px solid rgba(255, 82, 82, 0.4);
            color: #ff8a80;
        }

        form{
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 16px;
            margin-top: 4px;
        }
        .field{
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .field-full{
            grid-column: span 2;
        }
        label{
            font-size: 12px;
            color: #b0bec5;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        input{
            padding: 9px 10px;
            border-radius: 10px;
            border: 1px solid rgba(176, 190, 197, 0.4);
            background: rgba(1, 15, 28, 0.9);
            color: #e5f7ff;
            font-size: 13px;
            outline: none;
        }
        input::placeholder{
            color: #78909c;
        }
        input:focus{
            border-color: #00e676;
            box-shadow: 0 0 0 1px rgba(0, 230, 118, 0.2);
        }

        .hint{
            font-size: 11px;
            color: #78909c;
        }

        .actions{
            grid-column: span 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 4px;
        }
        .btn-primary{
            border: none;
            padding: 10px 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, #00e676, #00c853);
            color: #001219;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 25px rgba(0, 230, 118, 0.35);
        }
        .btn-primary:hover{
            filter: brightness(1.03);
        }
        .btn-secondary{
            font-size: 12px;
            text-decoration: none;
            color: #b0bec5;
        }
        .btn-secondary:hover{
            color: #e0f2f1;
        }

        @media (max-width: 720px) {
            .card{
                padding: 18px 16px 20px;
            }
            form{
                grid-template-columns: 1fr;
            }
            .field-full, .actions{
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="dashboard-header">
        <div class="app-title">
            <div class="app-logo">EV</div>
            <div>
                <h1>Owner Console</h1>
                <span>Manage your smart EV charging stations</span>
            </div>
        </div>
        <div class="top-actions">
            <a href="dashboard.php">◀ Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h2>➕ Add Charging Station <span class="pill">Owner verified</span></h2>
                <p>Register a new EV charging point with accurate location and connector details.</p>
            </div>
            <div class="card-meta">
                <div class="badge">
                    <span class="badge-dot"></span>
                    Live EV Network
                </div>
                <div>Changes are reflected for users after admin approval.</div>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="status-message <?php echo ($message_type === 'success') ? 'status-success' : 'status-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="field field-full">
                <label>Station Name</label>
                <input type="text" name="name" required placeholder="e.g., GreenCharge Plaza - Sector 21">
            </div>

            <div class="field field-full">
                <label>Address</label>
                <input type="text" name="address" required placeholder="Street, Area, City">
                <div class="hint">Use a clear address so drivers can easily find the station.</div>
            </div>

            <div class="field">
                <label>Latitude</label>
                <input type="text" name="latitude" required placeholder="e.g., 19.0760">
            </div>

            <div class="field">
                <label>Longitude</label>
                <input type="text" name="longitude" required placeholder="e.g., 72.8777">
            </div>

            <div class="field">
                <label>Connector Types</label>
                <input type="text" name="connector_types" placeholder="e.g., Type-2, CCS2" required>
            </div>

            <div class="field">
                <label>Max Power (kW)</label>
                <input type="number" name="max_power" required placeholder="e.g., 60">
            </div>

            <div class="actions">
                <a href="dashboard.php" class="btn-secondary">⟵ Cancel & go back</a>
                <button type="submit" name="add" class="btn-primary">
                    Save Station
                    <span>⚡</span>
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
