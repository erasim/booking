<?php
// process form (simple example)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name         = htmlspecialchars($_POST['name']);
    $email        = htmlspecialchars($_POST['email']);
    $phone        = htmlspecialchars($_POST['phone']);
    $car_model    = htmlspecialchars($_POST['car_model']);
    $service_date = htmlspecialchars($_POST['service_date']);
    $details      = htmlspecialchars($_POST['details']);

    $bookingData = "$name,$email,$phone,$car_model,$service_date,$details\n";
    file_put_contents("bookings.csv", $bookingData, FILE_APPEND);

    $success = "Thank you, your booking has been received!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Service Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a, #1d4ed8, #10b981);
            padding: 20px;
        }

        .booking-wrapper {
            background: rgba(15, 23, 42, 0.9);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            max-width: 900px;
            width: 100%;
            color: #e5e7eb;
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
            overflow: hidden;
        }

        .booking-left {
            padding: 32px 28px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.15);
            color: #93c5fd;
            font-size: 12px;
            margin-bottom: 16px;
        }

        .badge span.dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.25);
        }

        h1 {
            font-size: 26px;
            margin-bottom: 4px;
            color: #f9fafb;
        }

        .subtitle {
            font-size: 14px;
            color: #9ca3af;
            margin-bottom: 24px;
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            font-size: 13px;
            color: #d1d5db;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea {
            border-radius: 10px;
            border: 1px solid rgba(75, 85, 99, 0.8);
            background: rgba(15, 23, 42, 0.85);
            padding: 10px 12px;
            font-size: 14px;
            color: #e5e7eb;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            outline: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: #6b7280;
        }

        input:focus,
        textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6, 0 0 0 6px rgba(59, 130, 246, 0.25);
            background: rgba(15, 23, 42, 1);
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .actions {
            grid-column: span 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
        }

        .small-note {
            font-size: 11px;
            color: #6b7280;
        }

        button[type="submit"] {
            border: none;
            border-radius: 999px;
            padding: 10px 26px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            color: #f9fafb;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            box-shadow: 0 12px 25px rgba(22, 163, 74, 0.45);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
            white-space: nowrap;
        }

        button[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(22, 163, 74, 0.55);
            filter: brightness(1.05);
        }

        button[type="submit"]:active {
            transform: translateY(0);
            box-shadow: 0 8px 18px rgba(22, 163, 74, 0.4);
        }

        button[type="submit"] svg {
            width: 16px;
            height: 16px;
        }

        .success-msg {
            margin-bottom: 12px;
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 12px;
            background: rgba(22, 163, 74, 0.15);
            color: #bbf7d0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .success-msg span.icon {
            width: 16px;
            height: 16px;
            border-radius: 999px;
            border: 2px solid #4ade80;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .booking-right {
            position: relative;
            overflow: hidden;
            padding: 24px 20px;
            background: radial-gradient(circle at top, rgba(56, 189, 248, 0.3), transparent 55%),
                        radial-gradient(circle at bottom, rgba(52, 211, 153, 0.25), transparent 55%),
                        linear-gradient(145deg, #020617, #020617);
            border-left: 1px solid rgba(55, 65, 81, 0.9);
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            opacity: 0.15;
            background-image: radial-gradient(circle at 1px 1px, #1e293b 1px, transparent 0);
            background-size: 18px 18px;
            pointer-events: none;
        }

        .stat-card {
            position: relative;
            z-index: 1;
            background: rgba(15, 23, 42, 0.96);
            border-radius: 16px;
            padding: 18px 16px;
            border: 1px solid rgba(55, 65, 81, 0.9);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.6);
            color: #e5e7eb;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .stat-title {
            font-size: 12px;
            color: #9ca3af;
        }

        .pill {
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(34, 197, 94, 0.15);
            color: #6ee7b7;
            font-size: 11px;
        }

        .stat-main {
            margin-bottom: 12px;
        }

        .stat-main h2 {
            font-size: 18px;
            margin-bottom: 4px;
            color: #f9fafb;
        }

        .stat-main p {
            font-size: 12px;
            color: #9ca3af;
        }

        .stat-items {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 6px;
        }

        .stat-item span.label {
            display: block;
            font-size: 11px;
            color: #6b7280;
        }

        .stat-item span.value {
            font-size: 14px;
            color: #e5e7eb;
            font-weight: 500;
        }

        .stat-footnote {
            margin-top: 10px;
            font-size: 11px;
            color: #6b7280;
        }

        @media (max-width: 768px) {
            .booking-wrapper {
                grid-template-columns: minmax(0, 1fr);
            }
            .booking-right {
                display: none;
            }
            body {
                padding: 16px;
            }
            form {
                grid-template-columns: minmax(0, 1fr);
            }
            .form-group.full,
            .actions {
                grid-column: span 1;
            }
            .actions {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
<div class="booking-wrapper">
    <div class="booking-left">
        <div class="badge">
            <span class="dot"></span>
            <span>Same‑day slots available</span>
        </div>

        <?php if (!empty($success)): ?>
            <div class="success-msg">
                <span class="icon">✓</span>
                <span><?php echo $success; ?></span>
            </div>
        <?php endif; ?>

        <h1>Book Your Car Service</h1>
        <p class="subtitle">Schedule a professional service in under a minute. Get instant confirmation and SMS updates.</p>

        <form method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="+91 98765 43210" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label for="car_model">Car Model</label>
                <input type="text" name="car_model" id="car_model" placeholder="Hyundai i20, Maruti Swift..." required>
            </div>

            <div class="form-group">
                <label for="service_date">Preferred Service Date</label>
                <input type="date" name="service_date" id="service_date" required>
            </div>

            <div class="form-group">
                <label for="details">Service Details</label>
                <textarea name="details" id="details" placeholder="Describe issues or select service type (general service, AC check, brakes, etc.)" required></textarea>
            </div>

            <div class="actions">
                <p class="small-note">Your details are safe and used only to confirm your booking.</p>
                <button type="submit">
                    Book Service
                    <svg viewBox="0 0 20 20" fill="none">
                        <path d="M4 10h10M10 4l6 6-6 6" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="booking-right">
        <div class="card-overlay"></div>
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">Today’s service capacity</span>
                <span class="pill">Live updated</span>
            </div>
            <div class="stat-main">
                <h2>92% on‑time delivery</h2>
                <p>Trusted by car owners across the city for regular maintenance and emergency repairs.</p>
            </div>
            <div class="stat-items">
                <div class="stat-item">
                    <span class="label">Slots left today</span>
                    <span class="value">7 / 40</span>
                </div>
                <div class="stat-item">
                    <span class="label">Customer rating</span>
                    <span class="value">4.8★</span>
                </div>
                <div class="stat-item">
                    <span class="label">Avg. service time</span>
                    <span class="value">3 hrs</span>
                </div>
                <div class="stat-item">
                    <span class="label">Pickup & drop</span>
                    <span class="value">Available</span>
                </div>
            </div>
            <p class="stat-footnote">Book now to lock your preferred slot and avoid workshop waiting time.</p>
        </div>
    </div>
</div>
</body>
</html>
