-- 2025_01_19_constraints.sql
-- The creation of the main tables for zoo arcadia

-- Verify if there is already a foreign key before adding it
-- Note: MySQL doesn't support IF EXISTS for DROP FOREIGN KEY, so we skip this in initial setup
ALTER TABLE media_relations DROP FOREIGN KEY IF EXISTS fk_media_in_media_relations;

ALTER TABLE media_relations
ADD CONSTRAINT fk_media_in_media_relations
FOREIGN KEY (media_id) REFERENCES media(id_media)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--


-- Verify if there is already a foreign key before adding it
ALTER TABLE slides DROP FOREIGN KEY IF EXISTS fk_header_in_slides;

ALTER TABLE slides
ADD CONSTRAINT fk_hero_in_slides
FOREIGN KEY (hero_id) REFERENCES heroes(id_hero)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- Verify if there is already a foreign key before adding it
ALTER TABLE heroes DROP FOREIGN KEY IF EXISTS fk_habitat_in_heroes;

-- Relationship: heroes.habitat_id -> habitats.id_habitat
ALTER TABLE heroes
ADD CONSTRAINT fk_habitat_in_heroes
FOREIGN KEY (habitat_id) REFERENCES habitats(id_habitat)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE roles_permissions DROP FOREIGN KEY IF EXISTS fk_roles_in_roles_permissions;

-- Relationship: roles_permissions.role_id -> roles.id_role
ALTER TABLE roles_permissions
ADD CONSTRAINT fk_roles_in_roles_permissions
FOREIGN KEY (role_id) REFERENCES roles(id_role)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE roles_permissions DROP FOREIGN KEY IF EXISTS fk_permissions_in_roles_permissions;

-- Relationship: roles_permissions.permission_id -> permissions.id_permission
ALTER TABLE roles_permissions
ADD CONSTRAINT fk_permissions_in_roles_permissions
FOREIGN KEY (permission_id) REFERENCES permissions(id_permission)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE users_permissions DROP FOREIGN KEY IF EXISTS fk_users_in_users_permissions;

-- Relationship: users_permissions.user_id -> users.id_user
ALTER TABLE users_permissions
ADD CONSTRAINT fk_users_in_users_permissions
FOREIGN KEY (user_id) REFERENCES users(id_user)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE users_permissions DROP FOREIGN KEY IF EXISTS fk_permission_in_users_permissions;

ALTER TABLE users_permissions
ADD CONSTRAINT fk_permission_in_users_permissions
FOREIGN KEY (permission_id) REFERENCES permissions(id_permission)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE users DROP FOREIGN KEY IF EXISTS fk_role_in_users;

-- Relationship: users.role_id -> roles.id_role
ALTER TABLE users
ADD CONSTRAINT fk_role_in_users
FOREIGN KEY (role_id) REFERENCES roles(id_role)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE users DROP FOREIGN KEY IF EXISTS fk_employee_in_users;

-- Relationship: users.role_id -> roles.id_role
ALTER TABLE users
ADD CONSTRAINT fk_employee_in_users
FOREIGN KEY (employee_id) REFERENCES employees(id_employee)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--

-- Verify if there is already a foreign key before adding it
ALTER TABLE testimonials 
DROP FOREIGN KEY IF EXISTS fk_users_in_testimonials;

-- Relationship: testimonials.validated_by -> users.id_user
ALTER TABLE testimonials 
ADD CONSTRAINT fk_users_in_testimonials 
FOREIGN KEY (validated_by) REFERENCES users(id_user) 
ON DELETE SET NULL         -- Si se elimina el usuario, se pone validated_by en NULL.
ON UPDATE CASCADE;         -- Si cambia el id_user, se actualiza automáticamente.
--
--

-- ============================================================
-- CHARACTER SET CONFIGURATION: Ensure utf8mb4 for Unicode support
-- ============================================================
-- This ensures that tables can store emojis and full Unicode characters (4 bytes)
-- utf8mb4 is required for emojis, while utf8 only supports 3-byte characters

-- Ensure testimonials table uses utf8mb4 (for emojis in messages)
ALTER TABLE testimonials 
    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Specifically ensure message and pseudo columns use utf8mb4
ALTER TABLE testimonials 
    MODIFY COLUMN message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE testimonials 
    MODIFY COLUMN pseudo VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

-- Ensure form_contact table uses utf8mb4 (for emojis in contact messages)
ALTER TABLE form_contact 
    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Specifically ensure message-related columns use utf8mb4
ALTER TABLE form_contact 
    MODIFY COLUMN f_message TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE form_contact 
    MODIFY COLUMN ff_name VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE form_contact 
    MODIFY COLUMN fl_name VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE form_contact 
    MODIFY COLUMN f_subject VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--
--

-- Verify if there is already the foreign key before adding it
ALTER TABLE habitat_suggestion DROP FOREIGN KEY IF EXISTS fk_vet_in_habitat_suggestion;

-- Relationship: habitat_suggestion.suggested_by -> users.id_user
ALTER TABLE habitat_suggestion
ADD CONSTRAINT fk_vet_in_habitat_suggestion
FOREIGN KEY (suggested_by) REFERENCES users(id_user)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--

-- Verify if there is already the foreign key before adding it
ALTER TABLE habitat_suggestion DROP FOREIGN KEY IF EXISTS fk_admin_in_habitat_suggestion;

-- Relationship: habitat_suggestion.reviewed_by -> users.id_user
ALTER TABLE habitat_suggestion
ADD CONSTRAINT fk_admin_in_habitat_suggestion
FOREIGN KEY (reviewed_by) REFERENCES users(id_user)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE habitat_suggestion DROP FOREIGN KEY IF EXISTS fk_habitat_in_habitat_suggestion;

-- Relationship: habitat_suggestion.habitat_id -> habitats.id_habitat
ALTER TABLE habitat_suggestion
ADD CONSTRAINT fk_habitat_in_habitat_suggestion
FOREIGN KEY (habitat_id) REFERENCES habitats(id_habitat)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE specie 
DROP FOREIGN KEY IF EXISTS fk_category_in_specie ;

-- Relationship: specie.category_id -> category.id_category
ALTER TABLE specie 
ADD CONSTRAINT fk_category_in_specie 
FOREIGN KEY (category_id) REFERENCES category(id_category)
ON DELETE CASCADE    -- Si se elimina una categoría, también se eliminan las especies asociadas.
ON UPDATE CASCADE;   -- Si cambia el id_category, se actualiza automáticamente en specie.
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE animal_general DROP FOREIGN KEY IF EXISTS fk_specie_in_animal_general;

-- Relationship: animal_general.specie _id -> specie .id_specie 
ALTER TABLE animal_general
ADD CONSTRAINT fk_specie_in_animal_general
FOREIGN KEY (specie_id) REFERENCES specie (id_specie )
ON DELETE RESTRICT   -- No permite eliminar una raza si tiene animales asociados.
ON UPDATE CASCADE;   -- Si cambia el id_specie , el cambio se propaga automáticamente a animal_general.
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE animal_clicks DROP FOREIGN KEY IF EXISTS fk_animal_g_in_click;

-- Relationship: animal_click.id_animal_g -> animal_general.id_animal_g
ALTER TABLE animal_clicks
ADD CONSTRAINT fk_animal_g_in_click
FOREIGN KEY (animal_g_id) REFERENCES animal_general(id_animal_g)
ON DELETE CASCADE    -- Si se elimina un animal, también se eliminan sus estadísticas de clics.
ON UPDATE CASCADE;   -- Si cambia el id_animal_g, el cambio se propaga automáticamente.
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE service_logs DROP FOREIGN KEY IF EXISTS fk_service_in_service_logs;

-- Relationship: service_logs.id_service -> services.id_service
ALTER TABLE service_logs
ADD CONSTRAINT fk_service_in_service_logs
FOREIGN KEY (service_id) REFERENCES services(id_service)
ON DELETE CASCADE 
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE service_logs DROP FOREIGN KEY IF EXISTS fk_user_in_service_logs;

-- Relationship: service_logs.changed_by -> users.id_user
ALTER TABLE service_logs
ADD CONSTRAINT fk_user_in_service_logs
FOREIGN KEY (changed_by) REFERENCES users(id_user)
ON DELETE CASCADE 
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE animal_full DROP FOREIGN KEY IF EXISTS fk_animal_g_in_animal_full;

-- Relationship: animal_full.animal_g_id -> animal_general.id_animal_g
ALTER TABLE animal_full
ADD CONSTRAINT fk_animal_g_in_animal_full
FOREIGN KEY (animal_g_id) REFERENCES animal_general(id_animal_g)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE animal_full DROP FOREIGN KEY IF EXISTS fk_habitat_in_animal_full;

-- Relationship: animal_full.habitat_id -> habitats.id_habitat
ALTER TABLE animal_full
ADD CONSTRAINT fk_habitat_in_animal_full
FOREIGN KEY (habitat_id) REFERENCES habitats(id_habitat)
ON DELETE SET NULL
ON UPDATE CASCADE;

-- Verify if there is already a foreign key before adding it
ALTER TABLE animal_full DROP FOREIGN KEY IF EXISTS fk_nutrition_in_animal_full;

-- Relationship: animal_full.nutrition_id -> nutrition.id_nutrition
ALTER TABLE animal_full
ADD CONSTRAINT fk_nutrition_in_animal_full
FOREIGN KEY (nutrition_id) REFERENCES nutrition(id_nutrition)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE health_state_report DROP FOREIGN KEY IF EXISTS fk_full_animal_in_health_report;

-- Relationship: health_state_report.full_animal_id -> animal_full.id_full_animal
ALTER TABLE health_state_report
ADD CONSTRAINT fk_full_animal_in_health_report
FOREIGN KEY (full_animal_id) REFERENCES animal_full(id_full_animal)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE health_state_report DROP FOREIGN KEY IF EXISTS fk_users_in_health_report;

-- Relationship: health_state_report.checked_by -> users.id_user
ALTER TABLE health_state_report
ADD CONSTRAINT fk_users_in_health_report
FOREIGN KEY (checked_by) REFERENCES users(id_user)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE feeding_logs DROP FOREIGN KEY IF EXISTS fk_full_animal_in_feeding_logs;

-- Relationship: feeding_logs.animal_f_id -> animal_full.id_full_animal
ALTER TABLE feeding_logs
ADD CONSTRAINT fk_full_animal_in_feeding_logs
FOREIGN KEY (animal_f_id) REFERENCES animal_full(id_full_animal)
ON DELETE CASCADE
ON UPDATE CASCADE;
--
--


--
--


-- Verify if there is already the foreign key before adding it
ALTER TABLE feeding_logs DROP FOREIGN KEY IF EXISTS fk_users_in_feeding_logs;

-- Relationship: feeding_logs.user_id -> users.id_user
ALTER TABLE feeding_logs
ADD CONSTRAINT fk_users_in_feeding_logs
FOREIGN KEY (user_id) REFERENCES users(id_user)
ON DELETE SET NULL
ON UPDATE CASCADE;
--
--

-- ============================================================
-- INDEXES AND OPTIMIZATIONS
-- ============================================================

-- Verify if index already exists before adding it
ALTER TABLE animal_clicks
DROP INDEX IF EXISTS idx_animal_month_year;

-- Unique composite index to prevent duplicate entries per animal/month/year
ALTER TABLE animal_clicks
ADD UNIQUE INDEX idx_animal_month_year (animal_g_id, year, month);
--
--

-- Verify if index already exists before adding it
ALTER TABLE animal_clicks
DROP INDEX IF EXISTS idx_year_month;

-- Index for faster queries by date range (for cleanup jobs)
ALTER TABLE animal_clicks
ADD INDEX idx_year_month (year, month);
--
--


-- Verify if index already exists before adding it
ALTER TABLE form_contact
DROP INDEX IF EXISTS idx_sent_date;

-- Index for faster queries by date (for cleanup jobs)
ALTER TABLE form_contact
ADD INDEX idx_sent_date (f_sent_date);
--
--

-- Verify if index already exists before adding it
ALTER TABLE form_contact
DROP INDEX IF EXISTS idx_email;

-- Index for faster email queries
ALTER TABLE form_contact
ADD INDEX idx_email (f_email);
--
--
