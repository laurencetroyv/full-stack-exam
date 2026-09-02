<?php $page = 'about'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/about.css">

    <title>About</title>
</head>
<body>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container about-main">
    <h1>Exam</h1>

    <div class="about-grid">
        <p>
            ABC Distribution Company is a distributor of electrical supplies with inventories stored across North, East, South, West. The company owner requires a transactional web-based system to manage materials, pricing, availability, and reporting per location.
        </p>

        <dl>
            <div>
                <dt>Material Registry</dt>
                <dd>
                    <ul>
                        <li>Ability to add, edit, delete, and deactivate materials.</li>
                        <li>Materials should be uniquely identifiable.</li>
                        <li>Category management may be static or dynamic (your design choice).</li>
                    </ul>
                </dd>
            </div>

            <div>
                <dt>Location Setup & Material Control</dt>
                <dd>
                    <p>Predefined locations: <strong>North, East, South, West</strong>. <br> Materials can be:</p>
                    <ul>
                        <li>Assigned to multiple locations</li>
                        <li>Marked as <strong>Available / Not Available</strong> per location</li>
                        <li>Set as <strong>Active / Inactive</strong> per location</li>
                        <li>Assigned a <strong>location-specific price</strong></li>
                    </ul>
                    <p>Interface to manage:</p>
                    <ul>
                        <li>Material availability per location</li>
                        <li>Active / Inactive status per location</li>
                        <li>Price per location</li>
                    </ul>
                    <p><strong>Note: <i>Changes in one location must not affect other locations.</i></strong></p>
                </dd>
            </div>

            <div>
                <dt>Reports</dt>
                <dd>
                    * Generate reports that display:
                    * Materials per location
                    * **Filters:**
                    * Location
                    * Status (Active / Inactive)
                    * Availability (Available / Not Available)
                </dd>
            </div>
        </dl>
    </div>
</main>
</body>
</html>