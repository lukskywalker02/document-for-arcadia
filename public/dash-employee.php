<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Employee Dashboard for Zoo Arcadia">
    <meta name="keywords" content="zoo, employee dashboard, animal care, zoo management">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Dashboard</title>

    <link rel="stylesheet" href="/node_modules/Normalize-css/normalize.css" />
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body class="employee-dashboard">
    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-md-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Zoo Arcadia - Employee Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#testimony">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feeding">Animal Feeding</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container my-4">
        <!-- Testimony Validation Section -->
        <section id="testimony" class="mb-5">
            <h2 class="mb-4">Validate Visitor Testimonials</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Testimonial</th>
                                <th scope="col">Visitor Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>"Great experience, loved the animals!"</td>
                                <td>John Doe</td>
                                <td>
                                    <button class="btn btn-success btn-sm">Validate</button>
                                    <button class="btn btn-danger btn-sm">Invalidate</button>
                                    <!-- before validate dynamically to enter in a state to edit -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Modify Zoo Services Section -->
        <section id="services" class="mb-5">
            <h2 class="mb-4">Modify Zoo Services</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="service-name" class="form-label">Select Service</label>
                            <select class="form-select" id="service-name">
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
                </div>
            </div>
        </section>

        <!-- Assign Food to Animals Section -->
        <section id="feeding">
            <h2 class="mb-4">Assign Food to Filtered Animal</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="animal-search" class="form-label">Filter animal by:</label>
                            <input type="text" class="form-control mb-2" id="animal-search"
                                placeholder="Search animal by name...">
                        </div>
                        <div class="mb-3">
                            <label for="filters" class="form-label">Filter Faster</label>
                            <div class="d-flex flex-wrap gap-3">
                                <select class="form-select w-auto" id="habitat-filter">
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
                        <div id="filter-results" class="mt-3">
                            <!-- animal generated by filter -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Animal found</h5>
                                    <p class="card-text">Name: <span id="filtered-animal-name">-</span></p>
                                    <p class="card-text">Bread: <span id="filtered-animal-bread">-</span></p>
                                    <p class="card-text">Habitat: <span id="filtered-animal-habitat">-</span></p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Accept animal</button>
                        <button class="btn btn-danger mb-3">Reset</button>

                        <hr class="mb-4">
                        <div class="mb-3">
                            <label for="food-type" class="form-label">Assign Food Type</label>
                            <select class="form-select" id="food-type">
                                <option selected disabled>Choose food type</option>
                                <option value="meat">Meat</option>
                                <option value="vegetables">Vegetables</option>
                                <option value="fruits">Fruits</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="food-quantity" class="form-label">Assign Quantity (grams)</label>
                            <input type="number" class="form-control" id="food-quantity"
                                placeholder="Enter quantity in grams">
                        </div>
                        <div class="mb-3">
                            <label for="feeding-date" class="form-label">Date and Time  feeded</label>
                            <input type="datetime-local" class="form-control" id="feeding-date">
                        </div>
                        <div id="global-filter-results" class="mt-2">
                            <!-- Results will be dynamically injected here -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Assign nutrition to Animal Filtered</h5>
                                    <p class="card-text">Name: <span id="animal-name">-</span></p>
                                    <p class="card-text">Bread: <span id="animal-bread">-</span></p>
                                    <p class="card-text">Habitat: <span id="animal-habitat">-</span></p>
                                    <p class="card-text">Last Meal: <span id="last-meal">-</span></p>
                                    <p class="card-text">Quantity of Meal: <span id="last-quantity">-</span></p>
                                    <p class="card-text">Last Date to Feed: <span id="last-date">-</span></p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Assign Food</button>
                        <button class="btn btn-danger">Reset</button>

                    </form>
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