<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Administrator Dashboard for Zoo Arcadia">
    <meta name="keywords" content="zoo, admin dashboard, zoo management, animal care, habitat improvement">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrator Dashboard</title>

    <link rel="stylesheet" href="/node_modules/Normalize-css/normalize.css" />
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body class="admin-dashboard">
    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-md-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Zoo Arcadia - Administrator Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#accounts">Manage-Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Modify-Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#habitats-sugestion">Habitat-Suggestions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reports">Veterinary-Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#hours">zoo-hours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#habitat-modification">modify-habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonies">testimonies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#manage-animal">manage-animals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statistics">Statistics</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container my-4">
        <!-- Manage Accounts Section -->
        <section id="accounts" class="mb-5">
            <h2 class="mb-4">Manage User Accounts</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="user-type" class="form-label">Select User Type</label>
                            <select class="form-select" id="user-type">
                                <option selected disabled>Choose user type</option>
                                <option value="employee">Employee</option>
                                <option value="veterinarian">Veterinarian</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="user-name" class="form-label">User Name</label>
                            <input type="email" class="form-control" id="user-name" placeholder="Enter user's name">
                        </div>
                        <div class="mb-3">
                            <label for="user-email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="user-email" placeholder="Enter email address">
                        </div>
                        <div class="mb-3">
                            <label for="user-password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="user-password"
                                    placeholder="Generated password" readonly>
                                <button class="btn btn-secondary" type="button" id="generate-password">Generate</button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </form>


                    <hr class="my-4">

                    <h3>Existing Accounts</h3>
                    <ul class="list-group" id="accounts-list">
                        <!-- Dynamically generated list of accounts -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            John Doe - Employee
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Jane Smith - Veterinarian
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Modify Services Section -->
        <section id="services" class="mb-5">
            <h2 class="mb-4">Modify Zoo Services</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="service-name" class="form-label">Select Service</label>
                            <select class="form-select" id="e-service-name">
                                <option selected disabled>Choose a service</option>
                                <option value="guided-tour">Guided Tour</option>
                                <option value="zoo-cafe">Zoo Café</option>
                                <option value="kids-playground">Kids Playground</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="service-image" class="form-label">Service Image</label>
                            <input type="file" class="form-control" id="service-image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="service-title" class="form-label">Service Title</label>
                            <input type="text" class="form-control" id="service-title"
                                placeholder="Update the title of the service">
                        </div>
                        <div class="mb-3">
                            <label for="service-description" class="form-label">Service Description</label>
                            <textarea class="form-control" id="service-description" rows="3"
                                placeholder="Update the details of the service"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button class="btn btn-danger">Reset</button>
                    </form>
                    <hr class="my-4">
                    <h3>Last 3 Services Modified</h3>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Service Title: <span id="last-service-title-1">Zoo Café</span></h5>
                            <p class="card-text">Description: <span id="last-service-description-1">A relaxing café with
                                    zoo-themed decor.</span></p>
                            <p class="card-text">Image Path: <span
                                    id="last-service-image-path-1">/path/to/last-image-1.jpg</span></p>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Service Title: <span id="last-service-title-2">Guided Tour</span>
                            </h5>
                            <p class="card-text">Description: <span id="last-service-description-2">An exciting guided
                                    tour through the zoo.</span></p>
                            <p class="card-text">Image Path: <span
                                    id="last-service-image-path-2">/path/to/last-image-2.jpg</span></p>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Service Title: <span id="last-service-title-3">Kids Playground</span>
                            </h5>
                            <p class="card-text">Description: <span id="last-service-description-3">A fun area for kids
                                    to play and learn.</span></p>
                            <p class="card-text">Image Path: <span
                                    id="last-service-image-path-3">/path/to/last-image-3.jpg</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Habitat Suggestions Section -->
        <section id="habitats-sugestion" class="mb-5">
            <h2 class="mb-4">Review Habitat Suggestions</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="habitat-filter" class="form-label">Filter by Habitat</label>
                            <select class="form-select" id="habitat-filter">
                                <option selected disabled>Choose a habitat</option>
                                <option value="savannah">Savannah</option>
                                <option value="jungle">Jungle</option>
                                <option value="swamp">Swamp</option>
                            </select>
                        </div>
                        <div id="suggestions" class="mt-3">
                            <!-- Suggestions dynamically generated -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Improvement Suggestion</h5>
                                    <br>
                                    <p class="card-text mb-3">Proposed on: <span id="suggestion-date">-</span></p>
                                    <p class="card-text mb-3">Details: <span id="suggestion-details">-</span></p>
                                    <button class="btn btn-success">Accept</button>
                                    <button class="btn btn-danger">Reject</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-5">
                            <div id="accepted-suggestions" class="w-50 me-2">
                                <h4>Accepted Suggestions</h4>
                                <ul class="list-group">
                                    <!-- Dynamically add accepted suggestions -->
                                </ul>
                            </div>
                            <div id="rejected-suggestions" class="w-50 ms-2">
                                <h4>Rejected Suggestions</h4>
                                <ul class="list-group">
                                    <!-- Dynamically add rejected suggestions -->
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Veterinary Reports Section -->
        <section id="reports" class="mb-5">
            <h2 class="mb-4">Filter Veterinary Reports</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="animal-search" class="form-label">Filter animal by:</label>
                            <input type="text" class="form-control mb-2" id="animal-search"
                                placeholder="Search animal by name...">
                            <div class="mb-3">
                                <label for="filters" class="form-label">Filter Faster</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <select class="form-select w-auto" id="admin-habitat-filter">
                                        <option selected disabled>Habitat</option>
                                        <option value="savannah">Savannah</option>
                                        <option value="jungle">Jungle</option>
                                        <option value="swamp">Swamp</option>
                                    </select>
                                    <select class="form-select w-auto" id="classes-filter">
                                        <option selected disabled>classes</option>
                                        <option value="mammal">Mammal</option>
                                        <option value="bird">Bird</option>
                                        <option value="reptile">Reptile</option>
                                    </select>
                                    <select class="form-select w-auto" id="nutrition-filter">
                                        <option selected disabled>Nutrition</option>
                                        <option value="carnivore">Carnivore</option>
                                        <option value="herbivore">Herbivore</option>
                                        <option value="omnivore">Omnivore</option>
                                    </select>
                                    <select class="form-select w-auto" id="status-filter">
                                        <option selected disabled>Status</option>
                                        <option value="healthy">Healthy</option>
                                        <option value="sick">Sick</option>
                                        <option value="quarantined">Quarantined</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="review-date" class="form-label">By Review Date:</label>
                                <input type="datetime-local" class="form-control" id="review-date">
                            </div>

                            <div id="filter-results" class="mt-3">
                                <!-- animal generated by filter -->
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Report founded...</h5>
                                        <p class="card-text">Animal Name: <span id="animal-name">-</span></p>
                                        <p class="card-text">Veterinary Owner: <span id="user-veterinary">-</span></p>
                                        <p class="card-text">Habitat: <span id="animal-habitat">-</span></p>
                                        <p class="card-text">State of animal: <span id="animal-state">-</span></p>
                                        <p class="card-text">Review date: <span id="review-date-animal">-</span></p>
                                        <p class="card-text">Type of Nutrition: <span id="nutrition">-</span></p>
                                        <p class="card-text">Type of Nutrition proposed: <span
                                                id="nutrition-proposed">-</span></p>
                                        <p class="card-text">Quantity: <span id="nutrition-quantity">-</span></p>
                                        <p class="card-text">Quantity proposed: <span
                                                id="nutrition-quantity-proposed">-</span></p>
                                        <br>
                                        <p class="card-text">Health Details: <span id="health-details">-</span></p>
                                        <br>
                                        <p class="card-text">Veterinarian Opinion: <span id="vet-opinion">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Modify zoo hours -->
        <section id="hours" class="my-4">
            <h3>Modify Zoo Hours</h3>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="open-days" class="form-label">Days Open</label>
                            <select multiple class="form-select" id="open-days">
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="opening-time" class="form-label">Opening Time</label>
                            <input type="time" class="form-control" id="opening-time">
                        </div>
                        <div class="mb-3">
                            <label for="closing-time" class="form-label">Closing Time</label>
                            <input type="time" class="form-control" id="closing-time">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Hours</button>
                        <button class="btn btn-danger">Reset</button>
                    </form>
                </div>
            </div>
        </section>
        <!-- Modify Zoo Habitats -->
        <section id="habitat-modification" class="mb-5">
            <h2 class="mb-4">Modify Zoo Habitats</h2>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="habitat-name" class="form-label">Select Habitat</label>
                            <select class="form-select" id="habitat-name">
                                <option selected disabled>Choose a habitat</option>
                                <option value="savannah">Savannah</option>
                                <option value="jungle">Jungle</option>
                                <option value="swamp">Swamp</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="habitat-title" class="form-label">Habitat Title</label>
                            <input type="text" class="form-control" id="habitat-title"
                                placeholder="Enter new habitat title">
                        </div>
                        <div class="mb-3">
                            <label for="habitat-description" class="form-label">Habitat Description</label>
                            <textarea class="form-control" id="habitat-description" rows="3"
                                placeholder="Update habitat details"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="habitat-image" class="form-label">Habitat Image</label>
                            <input type="file" class="form-control" id="habitat-image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Habitat</button>
                        <button class="btn btn-danger">Reset</button>
                    </form>
                </div>
            </div>
        </section>

        <section id="testimonies" class="mb-5">
            <h2 class="mb-4">Manage Visitor Testimonies</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3>Last 3 Validated Testimonies</h3>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="card-text">"The zoo was amazing!"</p>
                            <p class="card-text">- Visitor: John Doe</p>
                            <button class="btn btn-warning btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="card-text">"Loved the guided tours, very informative."</p>
                            <p class="card-text">- Visitor: Jane Smith</p>
                            <button class="btn btn-warning btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="card-text">"The kids loved the playground!"</p>
                            <p class="card-text">- Visitor: Alice Johnson</p>
                            <button class="btn btn-warning btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h3>New Testimonies</h3>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="card-text">"The food court was delightful!"</p>
                            <p class="card-text">- Visitor: Bob Williams</p>
                            <button class="btn btn-success btn-sm">Accept</button>
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="card-text">"Amazing animal shows!"</p>
                            <p class="card-text">- Visitor: Sarah Brown</p>
                            <button class="btn btn-success btn-sm">Accept</button>
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Remove, Edit or Add Animal Section -->
        <section id="manage-animal" class="mb-5">
            <h2 class="mb-4">Remove, Edit or Add Animal</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Filter for Existing Animals -->
                    <form>
                        <div class="mb-3">
                            <label for="animal-search" class="form-label">Filter Animal by:</label>
                            <input type="text" class="form-control mb-2" id="rea-animal-search"
                                placeholder="Search animal by name...">
                        </div>
                        <div class="mb-3">
                            <label for="filters" class="form-label">Filter Faster</label>
                            <div class="d-flex flex-wrap gap-3">
                                <select class="form-select w-auto" id="rea-habitat-filter">
                                    <option selected disabled>Habitat</option>
                                    <option value="savannah">Savannah</option>
                                    <option value="jungle">Jungle</option>
                                    <option value="swamp">Swamp</option>
                                </select>
                                <select class="form-select w-auto" id="rea-classes-filter">
                                    <option selected disabled>classes</option>
                                    <option value="mammal">Mammal</option>
                                    <option value="bird">Bird</option>
                                    <option value="reptile">Reptile</option>
                                </select>
                            </div>
                        </div>

                        <!-- Current Animal Details -->
                        <div id="current-animal-details" class="mt-3">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Animal Found</h5>
                                    <p class="card-text">Name: <span id="current-animal-name">-</span></p>
                                    <p class="card-text">specie : <span id="current-animal-specie ">-</span></p>
                                    <p class="card-text">Habitat: <span id="current-animal-habitat">-</span></p>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mb-3">Edit</button>
                        <button class="btn btn-warning mb-3">Delete</button>
                        <button class="btn btn-secondary mb-3">Reset</button>

                        <hr class="my-4">

                        <!-- Form to Add or Edit Animal -->
                        <h3>Edit or Add Animal</h3>
                        <div class="mb-3">
                            <label for="new-animal-name" class="form-label">New Name</label>
                            <input type="text" class="form-control" id="new-animal-name" placeholder="Enter new name">
                        </div>
                        <div class="mb-3">
                            <label for="new-animal-specie " class="form-label">New specie </label>
                            <input type="text" class="form-control" id="new-animal-specie " placeholder="Enter new specie ">
                        </div>
                        <div class="mb-3">
                            <label for="new-animal-habitat" class="form-label">New Habitat</label>
                            <select class="form-select" id="new-animal-habitat">
                                <option selected disabled>Choose a habitat</option>
                                <option value="savannah">Savannah</option>
                                <option value="jungle">Jungle</option>
                                <option value="swamp">Swamp</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="new-animal-image" class="form-label">New Image</label>
                            <input type="file" class="form-control" id="new-animal-image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button class="btn btn-danger">Reset</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section id="statistics">
            <h2 class="mb-4">Zoo Statistics</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <p>Top 10 most visited animals:</p>
                    <ol id="top-animals">
                        <!-- List dynamically generated -->
                        <li>Animal 1</li>
                        <li>Animal 2</li>
                        <li>Animal 3</li>
                        <li>Animal 4</li>
                        <li>Animal 5</li>
                        <li>Animal 6</li>
                        <li>Animal 7</li>
                        <li>Animal 8</li>
                        <li>Animal 9</li>
                        <li>Animal 10</li>
                    </ol>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-3 mt-5 fixed-bottom">
        <div class="container text-center">
            <p>&copy; 2024 Zoo Arcadia. All rights reserved.</p>
        </div>
    </footer>

    <script type="module" src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>