<!-- Form to edit an employee -->

<div class="card  shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h3>Edit Employee</h3>
    </div>
    <div class="card-body">
        <!-- Success/Error Messages -->
        <?php 
        require_once __DIR__ . '/../../../../includes/helpers/messages.php';
        display_alert_message();
        ?>

        <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
        
        <form action="" method="post">
            <?= csrf_field('employee_edit') ?>


            <!-- Very Important! Hidden input to store the employee ID, to be able to update the employee in the database -->
            <div>
                <!-- Hidden input to store the employee ID -->
                <input type="hidden" class="form-control" aria-describedby="id-help" id="id" name="id" value="<?php echo $employee->id; ?>">
            </div>


            <div class="mb-3">
                <label for="firstname"
                    class="form-label">Name:
                </label>

                <!-- value: to display the current employee name, in case we forget who we wanted to edit -->
                <!-- placeholder: to display the current employee name, in case we delete the text from the input, we can see the current employee name as a placeholder -->
                <input type="text"
                    class="form-control"
                    id="firstname"
                    placeholder="<?php echo $employee->first_name; ?>"
                    value="<?php echo $employee->first_name; ?>"
                    name="firstname"
                    aria-describedby="firstname-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="lastname"
                    class="form-label">Last Name:
                </label>

                <input type="text"
                    class="form-control"
                    id="lastname"
                    placeholder="<?php echo $employee->last_name; ?>"
                    value="<?php echo $employee->last_name; ?>"
                    name="lastname"
                    aria-describedby="lastname-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="birthdate"
                    class="form-label">Birthdate:
                </label>
                <input type="date"
                    class="form-control"
                    id="birthdate"
                    placeholder="<?php echo $employee->birthdate; ?>"
                    value="<?php echo $employee->birthdate; ?>"
                    name="birthdate"
                    aria-describedby="birthdate-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="phone"
                    class="form-label">phone:
                </label>
                <input type="number"
                    class="form-control"
                    id="phone"
                    placeholder="<?php echo $employee->phone; ?>"
                    value="<?php echo $employee->phone; ?>"
                    name="phone"
                    aria-describedby="phone-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="email"
                    class="form-label">email:
                </label>
                <input type="email"
                    class="form-control"
                    id="email"
                    placeholder="<?php echo $employee->email; ?>"
                    value="<?php echo $employee->email; ?>"
                    name="email"
                    aria-describedby="email-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="address"
                    class="form-label">address:
                </label>
                <input type="text"
                    class="form-control"
                    id="address"
                    placeholder="<?php echo $employee->address; ?>"
                    value="<?php echo $employee->address; ?>"
                    name="address"
                    aria-describedby="address-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="city"
                    class="form-label">city:
                </label>
                <input type="text"
                    class="form-control"
                    id="city"
                    placeholder="<?php echo $employee->city; ?>"
                    value="<?php echo $employee->city; ?>"
                    name="city"
                    aria-describedby="city-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="zip_code"
                    class="form-label">zip_code:
                </label>
                <input type="text"
                    class="form-control"
                    id="zip_code"
                    placeholder="<?php echo $employee->zip_code; ?>"
                    value="<?php echo $employee->zip_code; ?>"
                    name="zip_code"
                    aria-describedby="zip_code-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="country"
                    class="form-label">country:
                </label>
                <input type="text"
                    class="form-control"
                    id="country"
                    placeholder="<?php echo $employee->country; ?>"
                    value="<?php echo $employee->country; ?>"
                    name="country"
                    aria-describedby="country-help"
                    required>
            </div>

            <div class="mb-3">
                <label for="gender"
                    class="form-label">gender:
                </label>
                <select class="form-select"
                    id="gender"
                    name="gender"
                    aria-describedby="gender-help"
                    required>

                    <option selected value="">Select a gender:</option>

                    <!-- Iterate through the genders options and add them to the select, thanks to the $genders array (defined in the controller employees_gest_controller.php) -->
                    <?php foreach ($genders as $gender_option) { ?>
                        <!-- Add the gender option to the select -->
                        <option value="<?php echo $gender_option; ?>"

                            <?php

                            # If the current employee gender is the same as the gender option, add the selected attribute to the option
                            ?>
                            <?php echo ($employee->gender == $gender_option) ? 'selected' : ''; ?>>

                            <!-- Display the gender option -->
                            <?php echo $gender_option; ?>
                        </option>
                    <?php }; ?>

                </select>
            </div>

            <div class="mb-3">
                <label for="marital_status"
                    class="form-label">marital_status:
                </label>
                <select class="form-select"
                    id="marital_status"
                    name="marital_status"
                    aria-describedby="marital_status-help"
                    required>

                    <option selected value="">Select a marital status:</option>

                    <!-- Iterate through the marital status options and add them to the select, thanks to the $marital_status array (defined in the controller employees_gest_controller.php) -->
                    <?php foreach ($marital_status as $marital_status_option) { ?>
                        <!-- Add the marital status option to the select -->
                        <option value="<?php echo $marital_status_option; ?>"

                            <?php

                            # If the current employee marital status is the same as the marital status option, add the selected attribute to the option
                            ?>
                            <?php echo ($employee->marital_status == $marital_status_option) ? 'selected' : ''; ?>>

                            <!-- Display the marital status option -->
                            <?php echo $marital_status_option; ?>
                        </option>
                    <?php }; ?>

                </select>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <input type="submit" class="btn btn-warning px-4" value="Update Employee">
                <a href="/employees/gest/start" class="btn btn-primary px-4">Cancel</a>
            </div>
        </form>

    </div>
</div>


<br>
<br>
<br>
<br>