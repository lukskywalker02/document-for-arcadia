-- 2. Insert ROLES first (no dependencies)
INSERT INTO
       roles (id_role, role_name, role_description)
VALUES
       (
              1,
              'Veterinary',
              'Responsible for the care and health of zoo animals.'
       ),
       (
              2,
              'Employee',
              'Responsible for cleaning, maintenance, public service, and animal nutrition.'
       ),
       (
              3,
              'Admin',
              'System administrator with full access to the zoo management.'
       ),
       (
              4,
              'Accountant',
              'Responsible for the zoo finances.'
       ),
       (
              5,
              'NO ROLE',
              'nothing'
       );

-- 3. Insert EMPLOYEES (personal data)
INSERT INTO
       employees (
              id_employee,
              first_name,
              last_name,
              email,
              birthdate,
              phone,
              address,
              city,
              zip_code,
              country,
              gender,
              marital_status
       )
VALUES
       (
              1,
              'Maria-Marcela',
              'Bandila',
              'maria.bandila@arcadia.com',
              '1990-05-15',
              '0601020304',
              '123 Rue de la Savane',
              'Paris',
              '75001',
              'France',
              'female',
              'single'
       ),
       (
              2,
              'Dumitru',
              'Stefan-Fernando',
              'dumitru.stefan@arcadia.com',
              '1988-11-20',
              '0602030405',
              '45 Avenue des Lions',
              'Lyon',
              '69002',
              'France',
              'male',
              'married'
       ),
       (
              3,
              'Sophie',
              'Martin',
              'sophie.martin@arcadia.com',
              '1992-02-10',
              '0603040506',
              '78 Boulevard des Girafes',
              'Marseille',
              '13008',
              'France',
              'female',
              'single'
       ),
       (
              4,
              'Pierre',
              'Dubois',
              'pierre.dubois@arcadia.com',
              '1985-09-30',
              '0604050607',
              '91 Rue du Tigre',
              'Lille',
              '59000',
              'France',
              'male',
              'divorced'
       ),
       (
              5,
              'Emma',
              'Bernard',
              'emma.bernard@arcadia.com',
              '1995-07-22',
              '0605060708',
              '10 Allée des Pandas',
              'Toulouse',
              '31000',
              'France',
              'female',
              'married'
       ),
       (
              6,
              'Lucas',
              'Moreau',
              'lucas.moreau@arcadia.com',
              '1993-01-18',
              '0606070809',
              '23 Chemin des Singes',
              'Bordeaux',
              '33000',
              'France',
              'male',
              'single'
       ),
       (
              7,
              'Marie',
              'Laurent',
              'marie.laurent@arcadia.com',
              '1989-03-12',
              '0607080910',
              '47 Impasse des Zèbres',
              'Nantes',
              '44000',
              'France',
              'female',
              'widowed'
       ),
       (
              8,
              'Thomas',
              'Garcia',
              'thomas.garcia@arcadia.com',
              '1998-12-05',
              '0608091011',
              '65 Place des Perroquets',
              'Strasbourg',
              '67000',
              'France',
              'male',
              'single'
       ),
       (
              9,
              'Julien',
              'Petit',
              'julien.petit@arcadia.com',
              '1991-08-17',
              '0609101112',
              '89 Route des Crocodiles',
              'Montpellier',
              '34000',
              'France',
              'male',
              'married'
       ),
       (
              10,
              'Isabelle',
              'Robert',
              'isabelle.robert@arcadia.com',
              '1987-06-25',
              '0610111213',
              '11 Avenue des Éléphants',
              'Nice',
              '06000',
              'France',
              'female',
              'divorced'
       ),
       (
              11,
              'Lakaka',
              'Abunda',
              'fdab222hadf@gmail.com',
              '1990-03-23',
              '735475347354',
              '4735eruturet',
              'Bubua',
              '675848',
              'Angola',
              'female',
              'married'
       ),
       -- Adding 20 more employees
       (
              12,
              'Jean',
              'Dupont',
              'jean.dupont@arcadia.com',
              '1986-04-11',
              '0612131415',
              '1 Place de la République',
              'Paris',
              '75003',
              'France',
              'male',
              'married'
       ),
       (
              13,
              'Anne',
              'Lefevre',
              'anne.lefevre@arcadia.com',
              '1994-08-02',
              '0613141516',
              '2 Rue de la Paix',
              'Lyon',
              '69001',
              'France',
              'female',
              'single'
       ),
       (
              14,
              'Michel',
              'Leroy',
              'michel.leroy@arcadia.com',
              '1980-12-24',
              '0614151617',
              '3 Avenue du Prado',
              'Marseille',
              '13006',
              'France',
              'male',
              'divorced'
       ),
       (
              15,
              'Nathalie',
              'Girard',
              'nathalie.girard@arcadia.com',
              '1997-06-19',
              '0615161718',
              '4 Boulevard de la Liberté',
              'Lille',
              '59000',
              'France',
              'female',
              'single'
       ),
       (
              16,
              'David',
              'Roux',
              'david.roux@arcadia.com',
              '1983-10-05',
              '0616171819',
              '5 Quai des Chartrons',
              'Bordeaux',
              '33000',
              'France',
              'male',
              'married'
       ),
       (
              17,
              'Valérie',
              'Fournier',
              'valerie.fournier@arcadia.com',
              '1991-02-28',
              '0617181920',
              '6 Rue Crébillon',
              'Nantes',
              '44000',
              'France',
              'female',
              'single'
       ),
       (
              18,
              'Alain',
              'Vincent',
              'alain.vincent@arcadia.com',
              '1984-07-14',
              '0618192021',
              '7 Place Kléber',
              'Strasbourg',
              '67000',
              'France',
              'male',
              'married'
       ),
       (
              19,
              'Christine',
              'Lambert',
              'christine.lambert@arcadia.com',
              '1996-09-08',
              '0619202122',
              '8 Rue de la Loge',
              'Montpellier',
              '34000',
              'France',
              'female',
              'single'
       ),
       (
              20,
              'Gérard',
              'Blanc',
              'gerard.blanc@arcadia.com',
              '1982-05-21',
              '0620212223',
              '9 Promenade des Anglais',
              'Nice',
              '06000',
              'France',
              'male',
              'divorced'
       ),
       (
              21,
              'Sylvie',
              'Henry',
              'sylvie.henry@arcadia.com',
              '1999-01-30',
              '0621222324',
              '10 Rue Saint-Ferréol',
              'Marseille',
              '13001',
              'France',
              'female',
              'single'
       ),
       (
              22,
              'Christophe',
              'Roussel',
              'christophe.roussel@arcadia.com',
              '1981-11-11',
              '0622232425',
              '11 Rue Esquermoise',
              'Lille',
              '59800',
              'France',
              'male',
              'married'
       ),
       (
              23,
              'Hélène',
              'Gauthier',
              'helene.gauthier@arcadia.com',
              '1993-04-16',
              '0623242526',
              '12 Rue de la Fosse',
              'Nantes',
              '44000',
              'France',
              'female',
              'single'
       ),
       (
              24,
              'Frédéric',
              'Chevalier',
              'frederic.chevalier@arcadia.com',
              '1987-03-03',
              '0624252627',
              '13 Place Broglie',
              'Strasbourg',
              '67000',
              'France',
              'male',
              'married'
       ),
       (
              25,
              'Céline',
              'Marchand',
              'celine.marchand@arcadia.com',
              '1995-12-12',
              '0625262728',
              '14 Rue de l''Hôtel de Ville',
              'Lyon',
              '69001',
              'France',
              'female',
              'single'
       ),
       (
              26,
              'Olivier',
              'Andre',
              'olivier.andre@arcadia.com',
              '1989-08-20',
              '0626272829',
              '15 Rue de Rivoli',
              'Paris',
              '75004',
              'France',
              'male',
              'married'
       ),
       (
              27,
              'Sandrine',
              'Simon',
              'sandrine.simon@arcadia.com',
              '1992-07-07',
              '0627282930',
              '16 Cours Mirabeau',
              'Aix-en-Provence',
              '13100',
              'France',
              'female',
              'single'
       ),
       (
              28,
              'Guillaume',
              'Mercier',
              'guillaume.mercier@arcadia.com',
              '1985-06-01',
              '0628293031',
              '17 Place du Capitole',
              'Toulouse',
              '31000',
              'France',
              'male',
              'married'
       ),
       (
              29,
              'Stéphanie',
              'Hubert',
              'stephanie.hubert@arcadia.com',
              '1998-02-14',
              '0629303132',
              '18 Rue de la République',
              'Lyon',
              '69002',
              'France',
              'female',
              'single'
       ),
       (
              30,
              'Benoît',
              'Aubert',
              'benoit.aubert@arcadia.com',
              '1984-09-26',
              '0630313233',
              '19 Quai de la Tournelle',
              'Paris',
              '75005',
              'France',
              'male',
              'divorced'
       ),
       (
              31,
              'Laetitia',
              'Caron',
              'laetitia.caron@arcadia.com',
              '1990-11-09',
              '0631323334',
              '20 Rue du Faubourg Saint-Honoré',
              'Paris',
              '75008',
              'France',
              'female',
              'married'
       );

-- 4. Insert USERS (credentials and links)
INSERT INTO
       users (
              id_user,
              username,
              psw,
              is_active,
              role_id,
              employee_id
       )
VALUES
       (1, 'mariab', 'mariab123', true, 2, NULL),
       (2, 'dumitrus', 'dumitrus123', true, 1, 2),
       (3, 'sophiem', 'sophiem123', false, 3, 3),
       (4, 'pierred', 'pierred123', true, 3, NULL),
       (5, 'emmab', 'emmab123', true, 2, 5),
       (6, 'lucasm', 'lucasm123', true, NULL, 6),
       (7, 'mariel', 'mariel123', false, 3, 7),
       (8, 'thomasg', 'thomasg123', false, 2, 8),
       (9, 'julienp', 'julienp123', true, NULL, 9),
       (10, 'isabeller', 'isabeller123', true, 3, 10),
       (11, 'lakakaa', 'lakakaa123', false, 2, 11),
       (12, 'jeand', 'jeand123', true, 2, 12),
       (13, 'annel', 'annel123', true, 2, 13),
       (14, 'michell', 'michell123', true, 2, 14),
       (15, 'nathalieg', 'nathalieg123', true, 2, 15),
       (16, 'davidr', 'davidr123', true, 2, 16),
       (17, 'valerief', 'valerief123', true, 2, 17),
       (18, 'alainv', 'alainv123', true, 2, 18),
       (19, 'christinel', 'christinel123', true, 2, 19),
       (20, 'gerardb', 'gerardb123', true, 2, 20),
       (21, 'sylvieh', 'sylvieh123', true, 2, 21),
       (22, 'christopher', 'christopher123', true, 2, 22),
       (23, 'heleneg', 'heleneg123', true, 2, 23),
       (24, 'fredericc', 'fredericc123', true, 2, 24),
       (25, 'celinem', 'celinem123', true, 1, 25),
       (26, 'oliviera', 'oliviera123', true, 1, 26),
       (27, 'sandrines', 'sandrines123', true, 3, 27),
       (28, 'guillaumem', 'guillaumem123', true, 2, NULL),
       (
              29,
              'stephanieh',
              'stephanieh123',
              false,
              2,
              NULL
       ),
       (30, 'benoita', 'benoita123', false, 1, NULL),
       (
              31,
              'laetitiac',
              'laetitiac123',
              true,
              NULL,
              NULL
       ),
       (
              32,
              'axel',
              '12345',
              true,
              5,
              NULL
       );

-- Este archivo llena la tabla `permissions` con el catálogo oficial de permisos.
-- ¡IMPORTANTE! Los 'permission_name' deben coincidir EXACTAMENTE con las constantes en PermissionList.php
INSERT INTO
       permissions (permission_name, permission_desc)
VALUES
       -- Permisos de Cuentas
       (
              'users-view',
              'Allows viewing the list of users in the system.'
       ),
       ('users-create', 'Allows creating new users.'),
       ('users-edit', 'Allows editing existing users.'),
       ('users-delete', 'Allows deleting users.'),
       (
              'roles-view',
              'Allows viewing the list of roles in the system.'
       ),
       ('roles-create', 'Allows creating new roles.'),
       ('roles-edit', 'Allows editing existing roles.'),
       ('roles-delete', 'Allows deleting roles.'),
       -- Permisos de Gestión del Zoo
       (
              'services-create',
              'Allows creating new services for the zoo.'
       ),
       (
              'services-view',
              'Allows viewing the list of services.'
       ),
       (
              'services-edit',
              'Allows editing existing services.'
       ),
       ('services-delete', 'Allows deleting services.'),
       (
              'schedules-view',
              'Allows viewing the list of schedules.'
       ),
       (
              'schedules-edit',
              'Allows editing existing schedules.'
       ),
       (
              'habitats-view',
              'Allows viewing the list of habitats.'
       ),
       (
              'habitats-create',
              'Allows creating new habitats.'
       ),
       (
              'habitats-edit',
              'Allows editing existing habitats.'
       ),
       (
              'habitats-delete',
              'Allows deleting habitats.'
       ),
       -- Permisos de Animales
       ('animals-create', 'Allows creating new animals.'),
       (
              'animals-view',
              'Allows viewing the list of animals.'
       ),
       (
              'animals-edit',
              'Allows editing existing animals.'
       ),
       ('animals-delete', 'Allows deleting animals.'),
       (
              'animal_stats-view',
              'Allows viewing the list of animal stats.'
       ),
       (
              'animal_feeding-view',
              'Allows viewing the list of animal feeding.'
       ),
       (
              'animal_feeding-assign',
              'Allows assigning and updating the food of an animal.'
       ),
       -- Permisos de Veterinario
       (
              'vet_reports-create',
              'Allows creating new veterinary reports.'
       ),
       (
              'vet_reports-view',
              'Allows viewing the list of veterinary reports.'
       ),
       (
              'vet_reports-edit',
              'Allows editing existing veterinary reports.'
       ),
       (
              'habitat_suggestions-create',
              'Allows creating new habitat suggestions.'
       ),
       (
              'habitat_suggestions-view',
              'Allows viewing the list of habitat suggestions.'
       ),
       (
              'habitat_suggestions-manage',
              'Allows accepting or rejecting habitat suggestions.'
       ),
       (
              'habitat_suggestions-delete',
              'Allows deleting habitat suggestions.'
       ),
       -- Permisos de Interacción Pública
       (
              'testimonials-view',
              'Allows viewing the list of testimonials.'
       ),
       (
              'testimonials-validate',
              'Allows validating or invalidating testimonials.'
       ),
       (
              'testimonials-delete',
              'Allows deleting testimonials.'
       );

INSERT INTO
       roles_permissions (role_id, permission_id)
VALUES
       -- Admin (role_id = 3) tiene todos los permisos (1-27, 30-32, 33-35)
       (3, 1),
       (3, 2),
       (3, 3),
       (3, 4),
       -- users: view, create, edit, delete
       (3, 5),
       (3, 6),
       (3, 7),
       (3, 8),
       -- roles: view, create, edit, delete
       (3, 9),
       (3, 10),
       (3, 11),
       (3, 12),
       -- services: create, view, edit, delete
       (3, 13),
       (3, 14),
       -- schedules: view, edit
       (3, 15),
       (3, 16),
       (3, 17),
       (3, 18),
       -- habitats: view, create, edit, delete
       (3, 19),
       (3, 20),
       (3, 21),
       (3, 22),
       -- animals: create, view, edit, delete
       (3, 23),
       (3, 24),
       (3, 25),
       -- animal_stats: view, animal_feeding: view, assign
       (3, 27),
       -- vet_reports: view
       (3, 30),
       (3, 31),
       (3, 32),
       -- habitat_suggestions: view, manage, delete
       -- testimonials: view (#33), validate (#34), delete (#35)
       (3, 33),
       (3, 34),
       (3, 35),
       -- Employee (role_id = 2) tiene todos los permisos (1-27, 30-32, 33-35)
       (2, 1),
       (2, 9),
       (2, 10),
       (2, 11),
       (2, 12),
       -- services: create, view, edit, delete
       (2, 13),
       -- schedules: view
       (2, 20),
       -- animals: view, animal_stats-view
       (2, 23),
       (2, 24),
       (2, 25),
       -- animal_stats: view, animal_feeding: view, assign
       (2, 27),
       -- vet_reports: view
       -- testimonials: view (#33), validate (#34), delete (#35) - Employee can do all actions
       (2, 33),
       (2, 34),
       (2, 35),
       -- Veterinarian (role_id = 1) tiene todos los permisos (1-35)
       (1, 13),
       -- schedules: view
       (1, 20),
       -- animals: view, animal_stats-view
       (1, 23),
       (1, 24),
       -- animal_stats: view, animal_feeding: view
       (1, 26),
       (1, 27),
       (1, 28),
       -- vet_reports: create, view, edit 
       (1, 29),
       (1, 30),
       (1, 32);

-- habitat_suggestions: create, view, delete
INSERT INTO
       `users_permissions` (`user_id`, `permission_id`)
VALUES
       (2, 2),
       (2, 5),
       (2, 8),
       (16, 8);

-- 🆕 Insert default Schedules (Opening Hours) - DAYS OF WEEK
INSERT INTO
       opening (time_slot, opening_time, closing_time, status)
VALUES
       ('Monday', '08:00:00', '18:00:00', 'open'),
       ('Tuesday', '08:00:00', '18:00:00', 'open'),
       ('Wednesday', '08:00:00', '18:00:00', 'open'),
       ('Thursday', '08:00:00', '18:00:00', 'open'),
       ('Friday', '08:00:00', '18:00:00', 'open'),
       ('Saturday', '09:00:00', '20:00:00', 'open'),
       ('Sunday', '10:00:00', '18:00:00', 'closed');

-- ============================================================
-- SEED DATA FOR SERVICES, HABITATS & FEATURED (With Real Cloudinary Images)
-- ============================================================
-- 1. Insert images into MEDIA table
INSERT INTO
       media (
              id_media,
              media_path,
              media_path_medium,
              media_path_large,
              media_type,
              description
       )
VALUES
       -- Media for Heroes
       (
              201,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876163/DALL_E_2024-08-23_20.27.03_-_A_hyper-realistic_image_of_a_monkey_dressed_exactly_like_the_one_provided_wearing_a_tailored_butler_suit_complete_with_a_bow_tie_and_white_gloves._T_1_dbwrhq.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876398/DALL_E_2024-08-23_20.27.03_-_A_hyper-realistic_image_of_a_monkey_dressed_exactly_like_the_one_provided_wearing_a_tailored_butler_suit_complete_with_a_bow_tie_and_white_gloves._T_7_rtctpu.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876450/DALL_E_2024-08-23_20.27.03_-_A_hyper-realistic_image_of_a_monkey_dressed_exactly_like_the_one_provided_wearing_a_tailored_butler_suit_complete_with_a_bow_tie_and_white_gloves._T_8_pmcjcu.webp',
              'image',
              'CMS Hero Monkey Desktop'
       ),
       (
              204,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764877493/DALL_E_2024-08-24_13.04.18_-_A_hyper-realistic_image_showing_three_distinct_habitats_with_no_visible_vertical_dividing_lines._On_the_left_a_savanna_with_golden_grass_sparse_tree_1_ubumul.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876995/DALL_E_2024-08-24_13.04.18_-_A_hyper-realistic_image_showing_three_distinct_habitats_with_no_visible_vertical_dividing_lines._On_the_left_a_savanna_with_golden_grass_sparse_tree_2_jas09u.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876866/DALL_E_2024-08-24_13.04.18_-_A_hyper-realistic_image_showing_three_distinct_habitats_with_no_visible_vertical_dividing_lines._On_the_left_a_savanna_with_golden_grass_sparse_tree_2_pskxpd.webp',
              'image',
              'Habitats Hero Desktop'
       ),
       (
              200,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764873190/aa7e4c59-0439-4c32-9703-5ee460d1dd8f_1_iyw7yo.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764873282/aa7e4c59-0439-4c32-9703-5ee460d1dd8f_2_g5y4ed.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872122/aa7e4c59-0439-4c32-9703-5ee460d1dd8f_3_qzx3wt.webp',
              'image',
              'Home Hero Background'
       ),
       (
              205,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764878015/DALL_E_2024-08-27_16.54.15_-_A_highly_detailed_and_realistic_image_featuring_a_cheetah_from_the_savannah_a_scarlet_ibis_from_the_swamp_and_a_chimpanzee_from_the_jungle_all_seam_2_ugfhbt.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764877726/DALL_E_2024-08-27_16.54.15_-_A_highly_detailed_and_realistic_image_featuring_a_cheetah_from_the_savannah_a_scarlet_ibis_from_the_swamp_and_a_chimpanzee_from_the_jungle_all_seam_1_o4z04j.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764877378/DALL_E_2024-08-27_16.54.15_-_A_highly_detailed_and_realistic_image_featuring_a_cheetah_from_the_savannah_a_scarlet_ibis_from_the_swamp_and_a_chimpanzee_from_the_jungle_all_seam_1_ibqrb7.webp',
              'image',
              'Animals Hero Background'
       ),
       (
              206,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764873838/5e6e4c9a-7e33-4dc0-ad86-783068dd38a8_1_gadwme.png',
              NULL,
              NULL,
              'image',
              'K-About BG'
       ),
       -- Media for Featured Cards (Homepage)
       (
              100,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872615/6607a878-b883-49b4-b760-012f655319e8_1_vx5rl5.webp',
              '',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872541/1734796025420_3_s62gy0.webp',
              'image',
              'Services Man'
       ),
       (
              101,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872680/DALL_E_2024-08-22_14.38.43_-_An_image_divided_into_three_vertical_sections_each_representing_a_different_natural_environment__a_savanna_a_swamp_and_a_jungle._The_savanna_sectio_1_rtadm7.webp',
              '',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872824/DALL_E_2024-08-22_14.38.43_-_An_image_divided_into_three_vertical_sections_each_representing_a_different_natural_environment__a_savanna_a_swamp_and_a_jungle._The_savanna_sectio_2_hwsq3u.webp',
              'image',
              'Habitats Collage'
       ),
       (
              102,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872943/DALL_E_2024-08-22_15.42.48_-_A_realistic_image_depicting_a_seamless_natural_environment_where_a_lion_a_crocodile_and_a_gorilla_coexist._The_lion_is_in_a_grassy_savanna-like_area_1_wmjlun.webp',
              '',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764872902/DALL_E_2024-08-22_15.42.48_-_A_realistic_image_depicting_a_seamless_natural_environment_where_a_lion_a_crocodile_and_a_gorilla_coexist._The_lion_is_in_a_grassy_savanna-like_area_1_y4gata.webp',
              'image',
              'Animals Collage'
       ),
       -- Media for Regular Services
       (
              103,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876157/_45bf66dc-f855-49f3-8c70-01c353e88270_1_caqe6l.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876404/_45bf66dc-f855-49f3-8c70-01c353e88270_2_hdhye1.webp',
              '',
              'image',
              'Restaurant'
       ),
       (
              104,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876160/_5c9ef8df-08e3-4d3f-9d73-3f0e8c8c064d_1_r8yo7a.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876401/_5c9ef8df-08e3-4d3f-9d73-3f0e8c8c064d_1_pw7vnb.webp',
              '',
              'image',
              'Zoo Guide'
       ),
       (
              105,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876165/DALL_E_2024-08-23_21.48.55_-_A_hyper-realistic_image_of_a_zoo_train_with_a_conductor_guiding_passengers_through_the_zoo._The_conductor_is_a_human_in_a_professional_uniform_and_th_1_q11b2p.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876165/DALL_E_2024-08-23_21.48.55_-_A_hyper-realistic_image_of_a_zoo_train_with_a_conductor_guiding_passengers_through_the_zoo._The_conductor_is_a_human_in_a_professional_uniform_and_th_1_wp2qdr.webp',
              '',
              'image',
              'Train'
       ),
       -- Media for Habitats Cards
       (
              106,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764877055/DALL_E_2024-08-22_14.42.06_-_A_realistic_and_detailed_image_of_a_jungle_landscape._The_scene_features_dense_lush_green_foliage_with_tall_trees_thick_undergrowth_and_vines_hangi_1_otbziq.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876999/DALL_E_2024-08-22_14.42.06_-_A_realistic_and_detailed_image_of_a_jungle_landscape._The_scene_features_dense_lush_green_foliage_with_tall_trees_thick_undergrowth_and_vines_hangi_1_ff7mys.webp',
              '',
              'image',
              'Jungle'
       ),
       (
              107,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764877051/DALL_E_2024-08-22_14.40.51_-_A_realistic_and_detailed_image_of_a_savanna_landscape._The_scene_features_wide_open_grasslands_with_tall_dry_grasses_swaying_in_the_breeze._Scattere_2_ptpvtj.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876988/DALL_E_2024-08-22_14.40.51_-_A_realistic_and_detailed_image_of_a_savanna_landscape._The_scene_features_wide_open_grasslands_with_tall_dry_grasses_swaying_in_the_breeze._Scattere_1_xbm3xa.webp',
              '',
              'image',
              'Savannah'
       ),
       (
              108,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764877059/DALL_E_2024-08-22_14.41.22_-_A_realistic_and_detailed_image_of_a_swamp_landscape._The_scene_features_murky_waters_reflecting_the_surrounding_thick_vegetation_with_tall_moss-cove_1_ngyvkh.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764876991/DALL_E_2024-08-22_14.41.22_-_A_realistic_and_detailed_image_of_a_swamp_landscape._The_scene_features_murky_waters_reflecting_the_surrounding_thick_vegetation_with_tall_moss-cove_1_esuv3x.webp',
              '',
              'image',
              'Swamp'
       ),
       (
              109,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889109/protect-and-educate-animals_qi4awr.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889306/tab-protect-and-educate-animals_lrofgy.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889463/desk-protect-and-educate-animals_gre6ou.webp',
              'image',
              'About Carousel Slide 1'
       ),
       (
              110,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889111/learning-education-all-time_cnzcgn.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889307/tab-learning-education-all-time_hf6vjg.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889463/desk-learning-education-all-time_cj7jls.webp',
              'image',
              'About Carousel Slide 2'
       ),
       (
              111,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889109/caring-_-unique-esxperiences_tljdjn.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889307/tab-caring-_-unique-esxperiences_kr2bhp.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1764889462/desk-caring-_-unique-esxperiences_zgtlke.webp',
              'image',
              'About Carousel Slide 3'
       );

-- 2. Insert SERVICES
INSERT INTO
       services (
              id_service,
              service_title,
              service_description,
              link,
              type
       )
VALUES
       -- Homepage Features
       (
              100,
              'SERVICES',
              'SEE WHAT ARCADIA CAN OFFERS YOU',
              '/cms/pages/cms',
              'featured'
       ),
       (
              101,
              'HABITATS',
              'AMAZING HABITATS TO DISCOVER',
              '/habitats/pages/habitats',
              'featured'
       ),
       (
              102,
              'ANIMALS',
              'EXPLORE ANOTHER WAY OF LOVE',
              '/animals/pages/allanimals',
              'featured'
       ),
       -- Regular Services
       (
              103,
              'Restaurant',
              'Get a break',
              NULL,
              'service'
       ),
       (
              104,
              'Zoo Guide',
              'Feel safe all time',
              NULL,
              'service'
       ),
       (
              105,
              'Train to Arcadia',
              'A family adventure',
              NULL,
              'service'
       ),
       -- Habitats
       (
              106,
              'JUNGLE',
              'EMBRACE THE SURPRISES OF THE JUNGLE',
              '/habitats/pages/habitat1',
              'habitat'
       ),
       (
              107,
              'SAVANNAH',
              'EXPERIENCE THE WILD MAJESTY OF THE SAVANNAH',
              '/habitats/pages/habitat1',
              'habitat'
       ),
       (
              108,
              'SWAMP',
              'UNCOVER THE MYSTERIES OF THE SWAMP',
              '/habitats/pages/habitat1',
              'habitat'
       );

-- 3. Insert HEROES (NO CAROUSEL)
INSERT INTO
       heroes (
              id_hero,
              hero_title,
              hero_subtitle,
              page_name,
              has_sliders
       )
VALUES
       (
              1,
              'ZOO ARCADIA',
              'Where all animals love to live',
              'home',
              0
       ),
       (
              2,
              'SERVICES',
              'Our specialized services for you',
              'services',
              0
       ),
       (
              3,
              'HABITATS',
              'Discover our amazing worlds',
              'habitats',
              0
       ),
       (
              4,
              'ANIMALS',
              'Explore another way of love',
              'animals',
              0
       ),
       (
              5,
              'ABOUT US',
              'Our commitment to conservation and education',
              'about',
              1
       );

-- 4. Insert Bricks
INSERT INTO
       bricks (title, description, link, page_name)
VALUES
       (
              'More About Us',
              'In the heart of Bretagne, Arcadia Zoo is home to unique animals from the savannah, jungle, and wetlands.

Since 1960, we have ensured their well-being through daily veterinary care and tailored feeding.',
              '/about/pages/about',
              'home'
       ),
       (
              'who we are ?',
              'Arcadia Zoo, located near the Brocéliande Forest in Brittany, France, has been a sanctuary for animals since 1960. Organized into diverse habitats such as the savannah, jungle, and wetlands, the zoo is committed to the well-being of its residents. Daily veterinary checks ensure the health of all animals before the zoo opens its doors to the public, and their meals are carefully portioned according to veterinarian reports.

With its thriving operation and happy animals, Arcadia Zoo is a source of pride for its director, José, who envisions even greater achievements for the zoo''s future. Through innovation and care, the zoo continues to be a place where visitors can connect with animals and nature.',
              NULL,
              'about'
       );

-- 5. Insert Slides for About Page
INSERT INTO
       slides (
              id_slide,
              hero_id,
              title_caption,
              description_caption
       )
VALUES
       (
              1,
              5,
              'Our team works day by day to protect and educate',
              'Recognize the dedicated team that works every day to guarantee animals care and promote environmental education.'
       ),
       (
              2,
              5,
              'A natural space to learn and connect with animals',
              'Discover a space where animals live in harmony, surrounded by green and serene landscapes, designed to learn and connect with nature.'
       ),
       (
              3,
              5,
              'Taking care of animals and offering unique experiences',
              "Explore a safe and friendly atmosphere where visitors and animals live together, reflecting the zoo's commitment to animal welfare and the joy of its visitors."
       );

-- 6. Link MEDIA to SERVICES and HEROES
INSERT INTO
       media_relations (media_id, related_table, related_id, usage_type)
VALUES
       -- Links for Services
       (100, 'services', 100, 'main'),
       (101, 'services', 101, 'main'),
       (102, 'services', 102, 'main'),
       (103, 'services', 103, 'main'),
       (104, 'services', 104, 'main'),
       (105, 'services', 105, 'main'),
       (106, 'services', 106, 'main'),
       (107, 'services', 107, 'main'),
       (108, 'services', 108, 'main'),
       -- Links for Heroes
       (200, 'heroes', 1, 'main'),
       (201, 'heroes', 2, 'main'),
       (204, 'heroes', 3, 'main'),
       (205, 'heroes', 4, 'main'),
       -- Links for Slides
       (109, 'slides', 1, 'main'),
       (110, 'slides', 2, 'main'),
       (111, 'slides', 3, 'main'),
       -- Link for Brick (Home More About Us)
       (206, 'bricks', 1, 'main');

-- ============================================================
-- SEED DATA FOR HABITATS (Savannah, Jungle, Swamp)
-- ============================================================
-- 7. Insert HABITATS
INSERT INTO
       habitats (id_habitat, habitat_name, description_habitat)
VALUES
       (1, 'Savannah', 'Majesty in its rawest form'),
       (
              2,
              'Jungle',
              'EMBRACE THE SURPRISES OF THE JUNGLE'
       ),
       (3, 'swamp', 'UNCOVER THE MYSTERIES OF THE SWAMP');

-- 8. Insert MEDIA for Habitats (Cards/Listings images)
INSERT INTO
       media (
              id_media,
              media_path,
              media_path_medium,
              media_path_large,
              media_type,
              description
       )
VALUES
       -- Savannah Habitat Card Images
       (
              112,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766091147/arcadia_uploads/jyxp73wbq6ddownipvis.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766091174/arcadia_uploads/jryclj1jkkpz2a39xsg5.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766091253/arcadia_uploads/lddrokgktbokvo1tdypn.png',
              'image',
              'Savannah Habitat Card'
       ),
       -- Jungle Habitat Card Images
       (
              113,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766092293/arcadia_uploads/bdxxfgxfxgoif1iwonud.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766092373/arcadia_uploads/nflh6z7os8ptp2brc9is.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766092573/arcadia_uploads/k9v8qp3etqdler2qdvqr.png',
              'image',
              'Jungle Habitat Card'
       ),
       -- Swamp Habitat Card Images
       (
              114,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766094070/arcadia_uploads/o1w2dksoerzlkfksmkla.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766094146/arcadia_uploads/visplj8egr0pqdxha9z8.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766094190/arcadia_uploads/v15s7juxxahooaqgamco.png',
              'image',
              'Swamp Habitat Card'
       ),
       -- Savannah Hero Images
       (
              115,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766090958/arcadia_uploads/rr8fohrnbkiwdekj2noa.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766091027/arcadia_uploads/qminb0u2p9syksaka3ra.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766091063/arcadia_uploads/tongriqblcx5sa6sasv1.webp',
              'image',
              'Savannah Hero Background'
       ),
       -- Jungle Hero Images
       (
              116,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766093099/arcadia_uploads/drjznpcgiejwrtpjnjht.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766093163/arcadia_uploads/nzwzdhlpoekku6b7fmym.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766093194/arcadia_uploads/gydql4irp9h1qzxpq5p2.webp',
              'image',
              'Jungle Hero Background'
       ),
       -- Swamp Hero Images
       (
              117,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766093761/arcadia_uploads/zoqvgbwcus9fhvkqia20.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766093788/arcadia_uploads/xi9hjzrtieopg8a2eptu.webp',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766093891/arcadia_uploads/fizurykhv12kkzdn722v.webp',
              'image',
              'Swamp Hero Background'
       );

-- 9. Insert HEROES for Habitats (with habitat_id)
INSERT INTO
       heroes (
              id_hero,
              hero_title,
              hero_subtitle,
              page_name,
              has_sliders,
              habitat_id
       )
VALUES
       (
              6,
              'VELVET SOVEREIGNS',
              'HEIRS OF A KINGDOM WITHOUT BORDERS',
              'habitats',
              0,
              1
       ),
       (
              7,
              'the silent Sylvans',
              "emerald unseen\'s art",
              'habitats',
              0,
              2
       ),
       (
              8,
              'The bayou barons',
              'A new pulse of a hidden world',
              'habitats',
              0,
              3
       );

-- 10. Link MEDIA to HABITATS (for cards/listings)
INSERT INTO
       media_relations (media_id, related_table, related_id, usage_type)
VALUES
       (112, 'habitats', 1, 'main'),
       (113, 'habitats', 2, 'main'),
       (114, 'habitats', 3, 'main');

-- 11. Link MEDIA to HEROES (for habitat-specific heroes)
INSERT INTO
       media_relations (media_id, related_table, related_id, usage_type)
VALUES
       (115, 'heroes', 6, 'main'),
       (116, 'heroes', 7, 'main'),
       (117, 'heroes', 8, 'main');

-- 12 Insert categories
INSERT INTO
       category (id_category, category_name)
VALUES
       (1, 'Mammal'),
       (2, 'Bird'),
       (3, 'Reptile'),
       (4, 'Amphibian'),
       (5, 'Arachnid'),
       (6, 'Insect');

-- ============================================================
-- SEED DATA FOR ANIMALS (Categories, Species, Nutrition, Animals)
-- ✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨
-- ============================================================
-- 13. Insert SPECIES (Scientific Names)
INSERT INTO
       specie (id_specie, category_id, specie_name)
VALUES
       -- Mammals
       -- start jungle mammals
       (1, 1, 'Ailuropoda melanoleuca (bear)'),
       (2, 1, 'Alouatta seniculus (monkey)'),
       (3, 1, 'Arctictis binturong (bearcat)'),
       (4, 1, 'Artibeus jamaicensis (bat)'),
       (5, 1, 'Ateles geoffroyi (monkey)'),
       (6, 1, 'Bradypus variegatus (sloth)'),
       (7, 1, 'elephas maximus (elephant)'),
       (8, 1, 'Helarctos malayanus (bear)'),
       (9, 1, 'Leopardus pardalis (feline)'),
       (10, 1, 'nasua (coati)'),
       (11, 1, 'Panthera onca (feline)'),
       (12, 1, 'Panthera tigris tigris (feline)'),
       (13, 1, 'pridontes maximus (armadillo)'),
       (14, 1, 'puma concolor (feline)'),
       (15, 1, 'Tamandua tetradactyla (anteater)'),
       (16, 1, 'tapirus terrestris (tapir)'),
       (17, 1, 'Tremarctos ornatus (bear)'),
       (18, 1, 'Viverra tangalunga (civet)'),
       -- start savannah mammals
       (19, 1, 'Acinonyx jubatus raineyi (feline)'),
       (20, 1, 'Aepyceros melampus (antelope)'),
       (21, 1, 'Ceratotherium simum (rhinoceros)'),
       (22, 1, 'Connochaetes taurinus (wildebeest)'),
       (23, 1, 'crocuta crocuta (hyena)'),
       (24, 1, 'Damaliscus lunatus jimela (antelope)'),
       (25, 1, 'Equus zebra (zebra)'),
       (
              26,
              1,
              'Giraffa camelopardalis peralta (giraffe)'
       ),
       (27, 1, 'Leptailurus serval (feline)'),
       (28, 1, 'Loxodonta africana (elephant)'),
       (29, 1, 'Orycteropus afer (aardvark)'),
       (30, 1, 'Oryx beisa (antelope)'),
       (31, 1, 'Panthera leo melanochaita (feline)'),
       (32, 1, 'panthera pardus pardus (feline)'),
       (33, 1, 'papio kindae (monkey)'),
       (34, 1, 'Phacochoerus africanus (warthog)'),
       (35, 1, 'syncerus caffer (buffalo)'),
       (36, 1, 'viverricula indica (civet)'),
       -- start swamp mammals
       (37, 1, 'bubalus bubalis (buffalo)'),
       (38, 1, 'castor fiber (beaver)'),
       (39, 1, 'Cerdocyon thous (fox)'),
       (40, 1, 'Hippopotamus amphibious (hippopotamus)'),
       (41, 1, 'Hydrochoerus hydrochaeris (capybara)'),
       (42, 1, 'lutra lutra (otter)'),
       (43, 1, 'neomys fodiens (shrew)'),
       (44, 1, 'Ondatra zibethicus (muskrat)'),
       (45, 1, 'Pteronura brasiliensis (otter)'),
       (46, 1, 'Trichechus manatus (manatee)'),
       -- Birds
       -- start jungle birds
       (48, 2, 'Ara chloropterus (parrot)'),
       (49, 2, 'Buceros rhinoceros (hornbill)'),
       (50, 2, 'cotinga nattererii (cotinga)'),
       (51, 2, 'Harpia harpyja (bird of prey)'),
       (52, 2, 'Pharomachrus mocinno (quetzal)'),
       (53, 2, 'Picus viridis (woodpecker)'),
       (54, 2, 'Probosciger aterrimus (parrot)'),
       (55, 2, 'Psittacus erithacus (parrot)'),
       (56, 2, 'Ramphastos sulfuratus (toucan)'),
       (57, 2, 'trochilidae (hummingbird)'),
       -- start swamp birds
       (58, 2, 'anhinga rufa (water bird)'),
       (59, 2, 'Ardea alba (water bird)'),
       (60, 2, 'Ardea cinerea (water bird)'),
       (61, 2, 'Eudocimus ruber (water bird)'),
       (62, 2, 'Himantopus himantopus (water bird)'),
       (63, 2, 'Jabiru mycteria (water bird)'),
       (64, 2, 'Leptoptilos crumenifer (water bird)'),
       (65, 2, 'Microcarbo africanus (water bird)'),
       (66, 2, 'Phalacrocorax carbo (water bird)'),
       (67, 2, 'Phoeniconaias minor (water bird)'),
       (68, 2, 'Phoenicopterus roseus (water bird)'),
       (69, 2, 'Platalea ajaja (water bird)'),
       (70, 2, 'Platalea leucorodia (water bird)'),
       -- start savannah birds
       (71, 2, 'Burhinus vermiculatus (water bird)'),
       (72, 2, 'Coracias abyssinicus (roller)'),
       (73, 2, 'Gyps fulvus (bird of prey)'),
       (74, 2, 'ploceus velatus (weaver)'),
       (75, 2, 'Polemaetus bellicosus (bird of prey)'),
       (76, 2, 'Pternistis adspersus (fowl)'),
       (
              77,
              2,
              'Sagittarius serpentarius (secretarybird)'
       ),
       (78, 2, 'Struthio camelus (ostrich)'),
       (79, 2, 'Vanellus albiceps (water bird)'),
       (80, 2, 'Vanellus armatus (water bird)'),
       -- start swamp reptiles
       (81, 3, 'Acanthochelys spixii (turtle)'),
       (82, 3, 'Alligator mississippiensis (crocodile)'),
       (83, 3, 'caiman yacare (crocodile)'),
       (84, 3, 'Crocodylus niloticus (crocodile)'),
       (85, 3, 'Gavialis gangeticus (crocodile)'),
       (86, 3, 'Melanosuchus niger (crocodile)'),
       -- start savannah reptiles
       (87, 3, 'agama agama (lizard)'),
       (88, 3, 'Aldabrachelys gigantea (turtle)'),
       (89, 3, 'chamaeleo africanus (lizard)'),
       (90, 3, 'Gopherus evgoodei (turtle)'),
       (91, 3, 'Mediterranean house gecko (lizard)'),
       -- start jungle amphibians
       (92, 4, 'Agalychnis callidryas (frog)'),
       (93, 4, 'Dendrobates tinctorius azureus (frog)'),
       (94, 4, 'Hyalinobatrachium fleischmanni (frog)'),
       (95, 4, 'Phyllobates terribilis (frog)'),
       (96, 4, 'Phyllomedusa bicolor (frog)');

-- 14. Insert NUTRITION PLANS
INSERT INTO
       nutrition (
              id_nutrition,
              nutrition_type,
              food_type,
              food_qtty
       )
VALUES
       -- Carnivorous plans
       (1, 'carnivorous', 'meat', 5000),
       -- For large felines (lions, tigers, jaguars, leopards) - 5kg meat
       (2, 'carnivorous', 'meat', 3000),
       -- For medium felines (puma, ocelot, serval, cheetah) - 3kg meat
       (3, 'carnivorous', 'meat', 2500),
       -- For hyenas - 2.5kg meat
       (4, 'carnivorous', 'meat', 2000),
       -- For crocodiles, alligators, caimans - 2kg meat
       (5, 'carnivorous', 'fish', 1500),
       -- For otters - 1.5kg fish
       (6, 'carnivorous', 'meat', 1000),
       -- For foxes, civets - 1kg meat
       (7, 'carnivorous', 'insect', 500),
       -- For insectivores (anteaters, shrews) - 500g insects
       (8, 'carnivorous', 'meat', 800),
       -- For birds of prey (eagles, vultures) - 800g meat
       -- Herbivorous plans
       (9, 'herbivorous', 'grass', 15000),
       -- For elephants - 15kg grass/vegetation
       (10, 'herbivorous', 'leaves', 8000),
       -- For giraffes - 8kg leaves
       (11, 'herbivorous', 'grass', 6000),
       -- For rhinoceroses - 6kg grass
       (12, 'herbivorous', 'grass', 5000),
       -- For large herbivores (buffalo, wildebeest, zebra) - 5kg grass
       (13, 'herbivorous', 'grass', 4000),
       -- For antelopes, warthogs - 4kg grass
       (14, 'herbivorous', 'aquatic_plants', 3000),
       -- For hippopotamus, manatee - 3kg aquatic plants
       (15, 'herbivorous', 'fruit', 3000),
       -- For fruit-eating herbivores - 3kg fruit
       (16, 'herbivorous', 'leaves', 2000),
       -- For sloths, tapirs - 2kg leaves
       (17, 'herbivorous', 'grass', 2000),
       -- For capybara, beaver - 2kg grass/vegetation
       (18, 'herbivorous', 'aquatic_plants', 1500),
       -- For muskrats - 1.5kg aquatic plants
       -- Omnivorous plans
       (19, 'omnivorous', 'fruit', 2500),
       -- For bears (panda, sun bear, andean bear) - 2.5kg fruit + vegetables
       (20, 'omnivorous', 'fruit', 2000),
       -- For monkeys (howler, spider, baboon) - 2kg fruit + insects
       (21, 'omnivorous', 'fruit', 1500),
       -- For coati, armadillo - 1.5kg fruit + insects
       (22, 'omnivorous', 'fruit', 1000),
       -- For aardvark - 1kg fruit + termites
       -- Bird plans
       (23, 'omnivorous', 'fruit', 800),
       -- For parrots, toucans - 800g fruit + seeds
       (24, 'omnivorous', 'fruit', 500),
       -- For hornbills, quetzals - 500g fruit
       (25, 'carnivorous', 'fish', 600),
       -- For water birds (herons, cormorants, storks) - 600g fish
       (26, 'herbivorous', 'aquatic_plants', 500),
       -- For flamingos, spoonbills - 500g aquatic plants
       (27, 'carnivorous', 'insect', 400),
       -- For small birds (woodpeckers, weavers) - 400g insects
       (28, 'omnivorous', 'fruit', 300),
       -- For rollers, fowls - 300g fruit + insects
       (29, 'herbivorous', 'grass', 2000),
       -- For ostriches - 2kg grass + insects
       (30, 'carnivorous', 'nectar', 50),
       -- For hummingbirds - 50g nectar + tiny insects
       -- Reptile plans
       (31, 'herbivorous', 'vegetables', 1000),
       -- For tortoises - 1kg vegetables + fruits
       (32, 'omnivorous', 'insect', 300),
       -- For lizards, geckos - 300g insects + small fruits
       (33, 'carnivorous', 'insect', 200),
       -- For chameleons - 200g insects
       -- Amphibian plans
       (34, 'carnivorous', 'insect', 100);

-- For frogs - 100g small insects
-- 15. Insert ANIMAL_GENERAL (Individual animals with common name)
INSERT INTO
       animal_general (id_animal_g, animal_name, gender, specie_id)
VALUES
       -- Jungle Mammals (1-18)
       (1, 'Bamboo', 'male', 1),
       (2, 'Rufus', 'male', 2),
       (3, 'Fuzzy', 'male', 3),
       (4, 'Nyx', 'female', 4),
       (5, 'Spider', 'male', 5),
       (6, 'Sloth', 'male', 6),
       (7, 'Surya', 'male', 7),
       (8, 'Sunny', 'male', 8),
       (9, 'Spots', 'female', 9),
       (10, 'Tail', 'female', 10),
       (11, 'Jaguar', 'male', 11),
       (12, 'Rajah', 'male', 12),
       (13, 'Armor', 'male', 13),
       (14, 'Swift', 'female', 14),
       (15, 'Tongue', 'male', 15),
       (16, 'Tapir', 'female', 16),
       (17, 'Andes', 'male', 17),
       (18, 'Civet', 'female', 18),
       -- Savannah Mammals (19-36)
       (19, 'Lightning', 'male', 19),
       (20, 'Jumper', 'male', 20),
       (21, 'Horn', 'male', 21),
       (22, 'Blue', 'male', 22),
       (23, 'Laugh', 'female', 23),
       (24, 'Topi', 'male', 24),
       (25, 'Stripes', 'female', 25),
       (26, 'Neck', 'female', 26),
       (27, 'Serval', 'male', 27),
       (28, 'Tembo', 'male', 28),
       (29, 'Earth', 'male', 29),
       (30, 'Oryx', 'female', 30),
       (31, 'King', 'male', 31),
       (32, 'Leopard', 'male', 32),
       (33, 'Baboon', 'male', 33),
       (34, 'Warthog', 'male', 34),
       (35, 'Buffalo', 'male', 35),
       (36, 'India', 'female', 36),
       -- Swamp Mammals (37-47)
       (37, 'Water', 'male', 37),
       (38, 'Beaver', 'male', 38),
       (39, 'Fox', 'male', 39),
       (40, 'Hippo', 'male', 40),
       (41, 'Capy', 'female', 41),
       (42, 'Otter', 'female', 42),
       (43, 'Shrew', 'female', 43),
       (44, 'Muskrat', 'male', 44),
       (45, 'Giant', 'male', 45),
       (46, 'Manatee', 'female', 46),
       -- Jungle Birds (47-56)
       (47, 'Green', 'male', 48),
       (48, 'Horn', 'male', 49),
       (49, 'Blue', 'male', 50),
       (50, 'Eagle', 'female', 51),
       (51, 'Quetzal', 'male', 52),
       (52, 'Peck', 'male', 53),
       (53, 'Cockatoo', 'female', 54),
       (54, 'Grey', 'male', 55),
       (55, 'Toucan', 'male', 56),
       (56, 'Humming', 'female', 57),
       -- Swamp Birds (57-69)
       (57, 'Anhinga', 'male', 58),
       (58, 'Egret', 'female', 59),
       (59, 'Grey', 'male', 60),
       (60, 'Red', 'male', 61),
       (61, 'Stilt', 'female', 62),
       (62, 'Jabiru', 'male', 63),
       (63, 'Marabou', 'male', 64),
       (64, 'Cormorant', 'male', 65),
       (65, 'Great', 'male', 66),
       (66, 'Lesser', 'female', 67),
       (67, 'Greater', 'female', 68),
       (68, 'Rose', 'female', 69),
       (69, 'Eurasia', 'male', 70),
       -- Savannah Birds (70-79)
       (70, 'Water', 'male', 71),
       (71, 'Abyssinian', 'female', 72),
       (72, 'Vulture', 'male', 73),
       (73, 'Weaver', 'male', 74),
       (74, 'Martial', 'female', 75),
       (75, 'Bill', 'male', 76),
       (76, 'Secretary', 'male', 77),
       (77, 'Ostrich', 'male', 78),
       (78, 'Crown', 'female', 79),
       (79, 'Blacksmith', 'male', 80),
       -- Swamp Reptiles (80-85)
       (80, 'Spine', 'female', 81),
       (81, 'Alli', 'male', 82),
       (82, 'Yacare', 'male', 83),
       (83, 'Nile', 'male', 84),
       (84, 'Gharial', 'male', 85),
       (85, 'Black', 'male', 86),
       -- Savannah Reptiles (86-90)
       (86, 'Agama', 'male', 87),
       (87, 'Giant', 'male', 88),
       (88, 'Chameleon', 'male', 89),
       (89, 'Gopherus', 'female', 90),
       (90, 'Gecko', 'female', 91),
       -- Jungle Amphibians (91-95)
       (91, 'Eyes', 'female', 92),
       (92, 'Blue', 'male', 93),
       (93, 'Crystal', 'female', 94),
       (94, 'Golden', 'male', 95),
       (95, 'Bicolor', 'female', 96);

-- 16. Insert ANIMAL_FULL (Link animals with habitats and nutrition)
INSERT INTO
       animal_full (
              id_full_animal,
              animal_g_id,
              habitat_id,
              nutrition_id
       )
VALUES
       -- Jungle Mammals (1-18) - habitat_id=2 (Jungle)
       (1, 1, 2, 19),
       -- Bambú (Panda) - omnivorous fruit
       (2, 2, 2, 20),
       -- Rufo (Mono Aullador) - omnivorous fruit
       (3, 3, 2, 19),
       -- Peludo (Binturong) - omnivorous fruit
       (4, 4, 2, 7),
       -- Noche (Murciélago) - carnivorous insect
       (5, 5, 2, 20),
       -- Araña (Mono Araña) - omnivorous fruit
       (6, 6, 2, 16),
       -- Lento (Perezoso) - herbivorous leaves
       (7, 7, 2, 9),
       -- Surya (Elefante Asiático) - herbivorous grass
       (8, 8, 2, 19),
       -- Sol (Oso del Sol) - omnivorous fruit
       (9, 9, 2, 2),
       -- Manchas (Ocelote) - carnivorous meat medium
       (10, 10, 2, 21),
       -- Cola (Coati) - omnivorous fruit
       (11, 11, 2, 1),
       -- Jaguar (Jaguar) - carnivorous meat large
       (12, 12, 2, 1),
       -- Rajah (Tigre de Bengala) - carnivorous meat large
       (13, 13, 2, 21),
       -- Armado (Armadillo Gigante) - omnivorous fruit
       (14, 14, 2, 2),
       -- Veloz (Puma) - carnivorous meat medium
       (15, 15, 2, 7),
       -- Lengua (Oso Hormiguero) - carnivorous insect
       (16, 16, 2, 16),
       -- Tapir (Tapir) - herbivorous leaves
       (17, 17, 2, 19),
       -- Andino (Oso Andino) - omnivorous fruit
       (18, 18, 2, 6),
       -- Civeta (Civeta Malaya) - carnivorous meat small
       -- Savannah Mammals (19-36) - habitat_id=1 (Savannah)
       (19, 19, 1, 2),
       -- Rayo (Guepardo) - carnivorous meat medium
       (20, 20, 1, 13),
       -- Saltarín (Impala) - herbivorous grass
       (21, 21, 1, 11),
       -- Cuerno (Rinoceronte Blanco) - herbivorous grass
       (22, 22, 1, 12),
       -- Azul (Ñu) - herbivorous grass large
       (23, 23, 1, 3),
       -- Risa (Hiena Manchada) - carnivorous meat
       (24, 24, 1, 13),
       -- Topi (Topi) - herbivorous grass
       (25, 25, 1, 12),
       -- Rayas (Cebra) - herbivorous grass large
       (26, 26, 1, 10),
       -- Cuello (Jirafa) - herbivorous leaves
       (27, 27, 1, 2),
       -- Serval (Serval) - carnivorous meat medium
       (28, 28, 1, 9),
       -- Tembo (Elefante Africano) - herbivorous grass
       (29, 29, 1, 22),
       -- Tierra (Cerdo Hormiguero) - omnivorous fruit
       (30, 30, 1, 13),
       -- Oryx (Órix) - herbivorous grass
       (31, 31, 1, 1),
       -- Rey (León) - carnivorous meat large
       (32, 32, 1, 1),
       -- Leopardo (Leopardo) - carnivorous meat large
       (33, 33, 1, 20),
       -- Baboon (Baboon) - omnivorous fruit
       (34, 34, 1, 13),
       -- Jabalí (Jabalí Verrugoso) - herbivorous grass
       (35, 35, 1, 12),
       -- Búfalo (Búfalo del Cabo) - herbivorous grass large
       (36, 36, 1, 6),
       -- India (Civeta India) - carnivorous meat small
       -- Swamp Mammals (37-47) - habitat_id=3 (Swamp)
       (37, 37, 3, 12),
       -- Agua (Búfalo de Agua) - herbivorous grass large
       (38, 38, 3, 17),
       -- Castor (Castor) - herbivorous grass
       (39, 39, 3, 6),
       -- Zorro (Zorro Cangrejero) - carnivorous meat small
       (40, 40, 3, 14),
       -- Hipo (Hipopótamo) - herbivorous aquatic plants
       (41, 41, 3, 17),
       -- Capy (Capibara) - herbivorous grass
       (42, 42, 3, 5),
       -- Nutria (Nutria Europea) - carnivorous fish
       (43, 43, 3, 7),
       -- Musaraña (Musaraña Acuática) - carnivorous insect
       (44, 44, 3, 18),
       -- Rata (Rata Almizclera) - herbivorous aquatic plants
       (45, 45, 3, 5),
       -- Gigante (Nutria Gigante) - carnivorous fish
       (46, 46, 3, 14),
       -- Manatí (Manatí) - herbivorous aquatic plants
       -- Jungle Birds (47-56) - habitat_id=2 (Jungle)
       (47, 47, 2, 23),
       -- Verde (Guacamayo) - omnivorous fruit
       (48, 48, 2, 24),
       -- Cuerno (Cálao Rinoceronte) - omnivorous fruit
       (49, 49, 2, 24),
       -- Azul (Cotinga Azul) - omnivorous fruit
       (50, 50, 2, 8),
       -- Águila (Águila Arpía) - carnivorous meat bird of prey
       (51, 51, 2, 24),
       -- Quetzal (Quetzal) - omnivorous fruit
       (52, 52, 2, 27),
       -- Pico (Pájaro Carpintero) - carnivorous insect
       (53, 53, 2, 23),
       -- Cacatúa (Cacatúa de Palmera) - omnivorous fruit
       (54, 54, 2, 23),
       -- Gris (Loro Gris) - omnivorous fruit
       (55, 55, 2, 23),
       -- Tucán (Tucán) - omnivorous fruit
       (56, 56, 2, 30),
       -- Humming (Hummingbird) - carnivorous nectar
       -- Swamp Birds (57-69) - habitat_id=3 (Swamp)
       (57, 57, 3, 25),
       -- Anhinga (Anhinga Africana) - carnivorous fish
       (58, 58, 3, 25),
       -- Garza (Garza Blanca) - carnivorous fish
       (59, 59, 3, 25),
       -- Gris (Garza Gris) - carnivorous fish
       (60, 60, 3, 25),
       -- Rojo (Ibis Escarlata) - carnivorous fish
       (61, 61, 3, 25),
       -- Patas (Cigüeñuela) - carnivorous fish
       (62, 62, 3, 25),
       -- Jabirú (Jabirú) - carnivorous fish
       (63, 63, 3, 25),
       -- Marabú (Marabú) - carnivorous fish
       (64, 64, 3, 25),
       -- Cormorán (Cormorán Carrizal) - carnivorous fish
       (65, 65, 3, 25),
       -- Grande (Cormorán Grande) - carnivorous fish
       (66, 66, 3, 26),
       -- Menor (Flamenco Menor) - herbivorous aquatic plants
       (67, 67, 3, 26),
       -- Mayor (Flamenco Mayor) - herbivorous aquatic plants
       (68, 68, 3, 25),
       -- Rosa (Espátula Rosada) - carnivorous fish
       (69, 69, 3, 25),
       -- Eurasia (Espátula Eurasiática) - carnivorous fish
       -- Savannah Birds (70-79) - habitat_id=1 (Savannah)
       (70, 70, 1, 25),
       -- Agua (Alcaraván) - carnivorous fish
       (71, 71, 1, 28),
       -- Abisinia (Carraca Abisinia) - omnivorous fruit
       (72, 72, 1, 8),
       -- Buitre (Buitre Leonado) - carnivorous meat bird of prey
       (73, 73, 1, 27),
       -- Tejedor (Tejedor Enmascarado) - carnivorous insect
       (74, 74, 1, 8),
       -- Militar (Águila Marcial) - carnivorous meat bird of prey
       (75, 75, 1, 28),
       -- Pico (Francolín de Pico Rojo) - omnivorous fruit
       (76, 76, 1, 8),
       -- Secretario (Secretario) - carnivorous meat bird of prey
       (77, 77, 1, 29),
       -- Avestruz (Avestruz) - herbivorous grass
       (78, 78, 1, 25),
       -- Corona (Avefría de Corona Blanca) - carnivorous fish
       (79, 79, 1, 25),
       -- Herrero (Avefría Herrera) - carnivorous fish
       -- Swamp Reptiles (80-85) - habitat_id=3 (Swamp)
       (80, 80, 3, 31),
       -- Espina (Tortuga de Cuello Negro) - herbivorous vegetables
       (81, 81, 3, 4),
       -- Alli (Alligator Americano) - carnivorous meat
       (82, 82, 3, 4),
       -- Yacaré (Yacaré) - carnivorous meat
       (83, 83, 3, 4),
       -- Nilo (Cocodrilo del Nilo) - carnivorous meat
       (84, 84, 3, 4),
       -- Gavial (Gavial) - carnivorous meat
       (85, 85, 3, 4),
       -- Negro (Caimán Negro) - carnivorous meat
       -- Savannah Reptiles (86-90) - habitat_id=1 (Savannah)
       (86, 86, 1, 32),
       -- Agama (Lagarto Agama) - omnivorous insect
       (87, 87, 1, 31),
       -- Gigante (Tortuga Gigante de Aldabra) - herbivorous vegetables
       (88, 88, 1, 33),
       -- Camaleón (Camaleón Africano) - carnivorous insect
       (89, 89, 1, 31),
       -- Gopherus (Tortuga de Matorral) - herbivorous vegetables
       (90, 90, 1, 32),
       -- Gecko (Gecko Doméstico) - omnivorous insect
       -- Jungle Amphibians (91-95) - habitat_id=2 (Jungle)
       (91, 91, 2, 34),
       -- Ojos (Rana de Ojos Rojos) - carnivorous insect
       (92, 92, 2, 34),
       -- Azul (Rana Dardo Azul) - carnivorous insect
       (93, 93, 2, 34),
       -- Cristal (Rana de Cristal) - carnivorous insect
       (94, 94, 2, 34),
       -- Dorada (Rana Dardo Dorada) - carnivorous insect
       (95, 95, 2, 34);

-- Bicolor (Rana Arborícola Bicolor) - carnivorous insect
-- 17. Insert MEDIA for Animals (Placeholder URLs - REPLACE with your Cloudinary URLs)
-- Format: mobile, tablet, desktop
INSERT INTO
       media (
              id_media,
              media_path,
              media_path_medium,
              media_path_large,
              media_type,
              description
       )
VALUES
       -- Jungle Mammals (1-18)
       (
              1,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399495/Ailuropoda_melanoleuca_ihv5xx.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417311/Ailuropoda_melanoleuca-tab_flrgje.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417311/Ailuropoda_melanoleuca-tab_flrgje.png',
              'image',
              'Bamboo the Panda'
       ),
       (
              2,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399651/Alouatta_seniculus_gdvkge.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/Alouatta_seniculus-tab_hshwug.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/Alouatta_seniculus-tab_hshwug.png',
              'image',
              'Rufus the Howler Monkey'
       ),
       (
              3,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399649/Arctictis_binturong_hceicv.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417312/binturong-tab_o36u6s.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417312/binturong-tab_o36u6s.png',
              'image',
              'Fuzzy the Binturong'
       ),
       (
              4,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399646/Artibeus_jamaicensis_cb3fdp.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417310/Artibeus_jamaicensis-tab_ai0gio.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417310/Artibeus_jamaicensis-tab_ai0gio.png',
              'image',
              'Nyx the Fruit Bat'
       ),
       (
              5,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399650/Ateles_geoffroyi_dqpqzn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417311/Ateles_geoffroyi-tab_ik2pbl.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417311/Ateles_geoffroyi-tab_ik2pbl.png',
              'image',
              'Spider the Spider Monkey'
       ),
       (
              6,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399649/Bradypus_variegatus_r5b9sa.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417313/Bradypus_variegatus-tab_vhnfcv.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417313/Bradypus_variegatus-tab_vhnfcv.png',
              'image',
              'Sloth the Sloth'
       ),
       (
              7,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399645/elephas_maximus_w8ma4t.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417314/elephas_maximus-tab_lepulp.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417314/elephas_maximus-tab_lepulp.png',
              'image',
              'Surya the Asian Elephant'
       ),
       (
              8,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399647/Helarctos_malayanus_d6h49l.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417315/Helarctos_malayanus-tab_ejagij.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417315/Helarctos_malayanus-tab_ejagij.png',
              'image',
              'Sunny the Sun Bear'
       ),
       (
              9,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399646/Leopardus_pardalis_klj6gx.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417308/Leopardus_pardalis-tab_kty9wq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417308/Leopardus_pardalis-tab_kty9wq.png',
              'image',
              'Spots the Ocelot'
       ),
       (
              10,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399649/nasua_h4dj6z.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417315/coati-tab_j94j3r.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417315/coati-tab_j94j3r.png',
              'image',
              'Tail the Coati'
       ),
       (
              11,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399652/Panthera_onca_ycxcam.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417314/jaguar_onca-tab_crdtsg.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417314/jaguar_onca-tab_crdtsg.png',
              'image',
              'Jaguar the Jaguar'
       ),
       (
              12,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399653/Panthera_tigris_tigris_dmud7z.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/tigre-tab_h9xuyq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/tigre-tab_h9xuyq.png',
              'image',
              'Rajah the Bengal Tiger'
       ),
       (
              13,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399654/pridontes_maximus_gkjuxq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417310/Arctictis_binturong-tab_e34jwp.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417310/Arctictis_binturong-tab_e34jwp.png',
              'image',
              'Armor the Giant Armadillo'
       ),
       (
              14,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399654/puma_concolor_kqfvrs.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417308/puma_concolor-tab_tftkkp.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417308/puma_concolor-tab_tftkkp.png',
              'image',
              'Swift the Puma'
       ),
       (
              15,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399656/Tamandua_tetradactyla_aod6bm.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417308/tamandua-tab_jyfyl7.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417308/tamandua-tab_jyfyl7.png',
              'image',
              'Tongue the Anteater'
       ),
       (
              16,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399657/tapirus_terrestris_alafhm.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417314/danta_tapirus-tab_d3x0dt.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417314/danta_tapirus-tab_d3x0dt.png',
              'image',
              'Tapir the Tapir'
       ),
       (
              17,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399656/Tremarctos_ornatus_srt19d.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/Tremarctos_ornatus-tab_jigebw.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/Tremarctos_ornatus-tab_jigebw.png',
              'image',
              'Andes the Andean Bear'
       ),
       (
              18,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399644/Viverra_tangalunga_c2jpfu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/Viverra_tangalunga-tab_uhbuok.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417309/Viverra_tangalunga-tab_uhbuok.png',
              'image',
              'Civet the Malayan Civet'
       ),
       -- Savannah Mammals (19-36)
       (
              19,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400405/Acinonyx_jubatus_raineyi_rqssn5.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418961/Acinonyx_jubatus_raineyi-tab_xbeysu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418961/Acinonyx_jubatus_raineyi-tab_xbeysu.png',
              'image',
              'Lightning the Cheetah'
       ),
       (
              20,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400399/Aepyceros_melampus_d7zkqj.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418953/Aepyceros_melampus-tab_mwig1n.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418953/Aepyceros_melampus-tab_mwig1n.png',
              'image',
              'Jumper the Impala'
       ),
       (
              21,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400397/Ceratotherium_simum_d5ednw.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419001/Ceratotherium_simum-tab_vpahfk.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419001/Ceratotherium_simum-tab_vpahfk.png',
              'image',
              'Horn the White Rhinoceros'
       ),
       (
              22,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400401/Connochaetes_taurinus_xe3hgj.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418995/Connochaetes_taurinus-tab_xaeuee.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418995/Connochaetes_taurinus-tab_xaeuee.png',
              'image',
              'Blue the Wildebeest'
       ),
       (
              23,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400407/Crocuta_crocuta_gxuyjg.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419004/Crocuta_crocuta-tab_gwqhkd.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419004/Crocuta_crocuta-tab_gwqhkd.png',
              'image',
              'Laugh the Spotted Hyena'
       ),
       (
              24,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400403/Damaliscus_lunatus_jimela_jpfpyw.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418956/Damaliscus_lunatus_jimela-tab_owryse.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418956/Damaliscus_lunatus_jimela-tab_owryse.png',
              'image',
              'Topi the Topi'
       ),
       (
              25,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400412/Equus_zebra_fio9ji.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418998/Equus_zebra-tab_xhqye6.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418998/Equus_zebra-tab_xhqye6.png',
              'image',
              'Stripes the Zebra'
       ),
       (
              26,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400410/Giraffa_camelopardalis_peralta_dp4as8.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418967/Giraffa_camelopardalis_peralta-tab_ry0r7d.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418967/Giraffa_camelopardalis_peralta-tab_ry0r7d.png',
              'image',
              'Neck the Giraffe'
       ),
       (
              27,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400414/Leptailurus_serval_kmtfg2.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418964/Leptailurus_serval-tab_lo5zhr.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418964/Leptailurus_serval-tab_lo5zhr.png',
              'image',
              'Serval the Serval'
       ),
       (
              28,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400416/Loxodonta_africana_f6xnhv.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419007/Loxodonta_africana-tab_dbha0e.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419007/Loxodonta_africana-tab_dbha0e.png',
              'image',
              'Tembo the African Elephant'
       ),
       (
              29,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400419/Orycteropus_afer_yjdjh0.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418971/Orycteropus_afer-tab_yot3v8.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418971/Orycteropus_afer-tab_yot3v8.png',
              'image',
              'Earth the Aardvark'
       ),
       (
              30,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400422/Oryx_beisa_ygo3qu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418958/Oryx_beisa-tab_zyhsbt.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418958/Oryx_beisa-tab_zyhsbt.png',
              'image',
              'Oryx the Oryx'
       ),
       (
              31,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400423/Panthera_leo_melanochaita_nlsq1s.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418980/Panthera_leo_melanochaita-tab_zewlld.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418980/Panthera_leo_melanochaita-tab_zewlld.png',
              'image',
              'King the Lion'
       ),
       (
              32,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400425/Panthera_pardus_pardus_bwwjyo.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418977/Panthera_pardus_pardus-tab_iegyge.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418977/Panthera_pardus_pardus-tab_iegyge.png',
              'image',
              'Leopard the Leopard'
       ),
       (
              33,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400428/Papio_kindae_jtcowj.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418992/Papio_kindae-tab_nge7oj.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418992/Papio_kindae-tab_nge7oj.png',
              'image',
              'Baboon the Baboon'
       ),
       (
              34,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400430/Phacochoerus_africanus_omybxs.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418987/Phacochoerus_africanus-tab_recdfu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418987/Phacochoerus_africanus-tab_recdfu.png',
              'image',
              'Warthog the Warthog'
       ),
       (
              35,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400432/Syncerus_caffer_dsl1sf.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418989/Syncerus_caffer-tab_tzdbyq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418989/Syncerus_caffer-tab_tzdbyq.png',
              'image',
              'Buffalo the Cape Buffalo'
       ),
       (
              36,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400395/Viverricula_indica_zsap4k.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418983/Viverricula_indica-tab_fkdvue.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418983/Viverricula_indica-tab_fkdvue.png',
              'image',
              'India the Indian Civet'
       ),
       -- Swamp Mammals (37-47)
       (
              37,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401527/bubalus_bubalis_jxqbv0.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/bubalus_bubalis-tab_kqslan.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/bubalus_bubalis-tab_kqslan.png',
              'image',
              'Water the Water Buffalo'
       ),
       (
              38,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401513/castor_fiber_ybtswr.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/castor_fiber-tab_dbjso4.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/castor_fiber-tab_dbjso4.png',
              'image',
              'Beaver the Beaver'
       ),
       (
              39,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401518/Cerdocyon_thous_dfzpyc.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421350/Cerdocyon_thous-tab_dpzlml.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421350/Cerdocyon_thous-tab_dpzlml.png',
              'image',
              'Fox the Crab-eating Fox'
       ),
       (
              40,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401522/Hippopotamus_amphibious_jft9st.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/Hippopotamus_amphibious-tab_kmso0t.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/Hippopotamus_amphibious-tab_kmso0t.png',
              'image',
              'Hippo the Hippopotamus'
       ),
       (
              41,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401532/Hydrochoerus_hydrochaeris_jlamqa.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421349/Hydrochoerus_hydrochaeris-tab_w82zzd.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421349/Hydrochoerus_hydrochaeris-tab_w82zzd.png',
              'image',
              'Capy the Capybara'
       ),
       (
              42,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401536/Lutra_lutra_rk8nqs.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421351/Lutra_lutra-tab_pvcrlq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421351/Lutra_lutra-tab_pvcrlq.png',
              'image',
              'Otter the Eurasian Otter'
       ),
       (
              43,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401541/Neomys_fodiens_bglbak.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421352/Neomys_fodiens-tab_jy6ict.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421352/Neomys_fodiens-tab_jy6ict.png',
              'image',
              'Shrew the Water Shrew'
       ),
       (
              44,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401546/Ondatra_zibethicus_wsuylo.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421348/Ondatra_zibethicus-tab_yzyazx.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421348/Ondatra_zibethicus-tab_yzyazx.png',
              'image',
              'Muskrat the Muskrat'
       ),
       (
              45,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401550/Pteronura_brasiliensis_fk1low.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421349/Pteronura_brasiliensis-tab_qhxekn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421349/Pteronura_brasiliensis-tab_qhxekn.png',
              'image',
              'Giant the Giant Otter'
       ),
       (
              46,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401509/Trichechus_manatus_wbfzmh.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/Trichechus_manatus-tab_qxndx9.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421347/Trichechus_manatus-tab_qxndx9.png',
              'image',
              'Manatee the Manatee'
       ),
       -- Jungle Birds (48-57)
       (
              47,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399805/Ara_chloropterus_nigxsd.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417846/Ara_chloropterus-tab_vaqsjk.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417846/Ara_chloropterus-tab_vaqsjk.png',
              'image',
              'Green the Macaw'
       ),
       (
              48,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399804/Buceros_rhinoceros_uczklh.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417837/Buceros_rhinoceros-tab_oo0fjb.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417837/Buceros_rhinoceros-tab_oo0fjb.png',
              'image',
              'Horn the Rhinoceros Hornbill'
       ),
       (
              49,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399806/cotinga_nattererii_kmu4fz.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417832/cotinga_nattererii-tab_dolfys.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417832/cotinga_nattererii-tab_dolfys.png',
              'image',
              'Blue the Cotinga'
       ),
       (
              50,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399803/harpia_eagle_ndadhi.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417848/harpia_eagle-tab_okvdpu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417848/harpia_eagle-tab_okvdpu.png',
              'image',
              'Eagle the Harpy Eagle'
       ),
       (
              51,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399807/Pharomachrus_mocinno_ick4xe.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417835/Pharomachrus_mocinno-tab_ref4wd.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417835/Pharomachrus_mocinno-tab_ref4wd.png',
              'image',
              'Quetzal the Quetzal'
       ),
       (
              52,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399809/Picus_viridis_hmg5nf.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417844/Picus_viridis-tab_eht1q3.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417844/Picus_viridis-tab_eht1q3.png',
              'image',
              'Peck the Woodpecker'
       ),
       (
              53,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399812/Probosciger_aterrimus_zhotv4.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417839/Probosciger_aterrimus-tab_sqfj16.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417839/Probosciger_aterrimus-tab_sqfj16.png',
              'image',
              'Cockatoo the Palm Cockatoo'
       ),
       (
              54,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399810/Psittacus_erithacus_x2rbbc.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417841/Psittacus_erithacus-tab_bjmacc.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417841/Psittacus_erithacus-tab_bjmacc.png',
              'image',
              'Grey the Grey Parrot'
       ),
       (
              55,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399811/Ramphastos_sulfuratus_yjngrm.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417850/Ramphastos_sulfuratus-tab_syj7bv.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417850/Ramphastos_sulfuratus-tab_syj7bv.png',
              'image',
              'Toucan the Toucan'
       ),
       (
              56,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399814/Trochilidae_hflrnu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417831/Trochilidae-tab_aivyeu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766417831/Trochilidae-tab_aivyeu.png',
              'image',
              'Humming the Hummingbird'
       ),
       -- Swamp Birds (58-70)
       (
              57,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401266/anhinga_rufa_llgrfy.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421447/anhinga_rufa-tab_prgz1b.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421447/anhinga_rufa-tab_prgz1b.png',
              'image',
              'Anhinga the African Darter'
       ),
       (
              58,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401301/Ardea_alba_dody5h.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421452/Ardea_alba-tab_feiljn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421452/Ardea_alba-tab_feiljn.png',
              'image',
              'Egret the Great Egret'
       ),
       (
              59,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401270/Ardea_cinerea_xpxsgc.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421454/Ardea_cinerea-tab_xtmorx.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421454/Ardea_cinerea-tab_xtmorx.png',
              'image',
              'Grey the Grey Heron'
       ),
       (
              60,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401297/Eudocimus_ruber_orjyzx.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421448/Eudocimus_ruber-tab_nsykxr.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421448/Eudocimus_ruber-tab_nsykxr.png',
              'image',
              'Red the Scarlet Ibis'
       ),
       (
              61,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401279/Himantopus_himantopus_uupazn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421460/Himantopus_himantopus-tab_fezjfg.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421460/Himantopus_himantopus-tab_fezjfg.png',
              'image',
              'Stilt the Black-winged Stilt'
       ),
       (
              62,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401275/Jabiru_mycteria_kbbnig.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421450/Jabiru_mycteria-tab_elj2ow.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421450/Jabiru_mycteria-tab_elj2ow.png',
              'image',
              'Jabiru the Jabiru'
       ),
       (
              63,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401284/Leptoptilos_crumenifer_ux5ngo.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421451/Leptoptilos_crumenifer-tab_gjkxw8.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421451/Leptoptilos_crumenifer-tab_gjkxw8.png',
              'image',
              'Marabou the Marabou Stork'
       ),
       (
              64,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401243/Microcarbo_africanus_dfwzyp.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421453/Microcarbo_africanus-tab_mxnbyn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421453/Microcarbo_africanus-tab_mxnbyn.png',
              'image',
              'Cormorant the Reed Cormorant'
       ),
       (
              65,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401247/Phalacrocorax_carbo_irhkig.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421454/Phalacrocorax_carbo-tab_mhoryk.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421454/Phalacrocorax_carbo-tab_mhoryk.png',
              'image',
              'Great the Great Cormorant'
       ),
       (
              66,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401288/Phoeniconaias_minor_eqhwou.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421456/Phoeniconaias_minor-tab_velz9q.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421456/Phoeniconaias_minor-tab_velz9q.png',
              'image',
              'Lesser the Lesser Flamingo'
       ),
       (
              67,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401256/Phoenicopterus_roseus_o6eqe7.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421459/Phoenicopterus_roseus-tab_hpf8a9.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421459/Phoenicopterus_roseus-tab_hpf8a9.png',
              'image',
              'Greater the Greater Flamingo'
       ),
       (
              68,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401251/platalea_ajaja_vjqzze.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421457/platalea_ajaja-tab_ubzrvb.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421457/platalea_ajaja-tab_ubzrvb.png',
              'image',
              'Rose the Roseate Spoonbill'
       ),
       (
              69,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401292/Platalea_leucorodia_kqysuv.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421458/Platalea_leucorodia-tab_kcr7wo.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421458/Platalea_leucorodia-tab_kcr7wo.png',
              'image',
              'Eurasia the Eurasian Spoonbill'
       ),
       -- Savannah Birds (72-81)
       (
              70,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400624/Burhinus_vermiculatus_ydqufm.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419349/Burhinus_vermiculatus-tab_mjvmzo.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419349/Burhinus_vermiculatus-tab_mjvmzo.png',
              'image',
              'Water the Water Thick-knee'
       ),
       (
              71,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400644/Coracias_abyssinicus_ilbkye.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419336/Coracias_abyssinicus-tab_wmehr5.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419336/Coracias_abyssinicus-tab_wmehr5.png',
              'image',
              'Abyssinian the Abyssinian Roller'
       ),
       (
              72,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400630/Gyps_fulvus_heqvzh.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419359/Gyps_fulvus-tab_srxukn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419359/Gyps_fulvus-tab_srxukn.png',
              'image',
              'Vulture the Griffon Vulture'
       ),
       (
              73,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400633/Ploceus_velatus_wy6knn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419370/Ploceus_velatus-tab_stpkok.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419370/Ploceus_velatus-tab_stpkok.png',
              'image',
              'Weaver the Southern Masked Weaver'
       ),
       (
              74,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400641/Polemaetus_bellicosus_pqbfpo.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419367/Polemaetus_bellicosus-tab_rbgq6z.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419367/Polemaetus_bellicosus-tab_rbgq6z.png',
              'image',
              'Martial the Martial Eagle'
       ),
       (
              75,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400636/Pternistis_adspersus_jmkzie.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419356/Pternistis_adspersus-tab_gohusc.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419356/Pternistis_adspersus-tab_gohusc.png',
              'image',
              'Bill the Red-billed Spurfowl'
       ),
       (
              76,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400647/Sagittarius_serpentarius_b0gklk.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419346/Sagittarius_serpentarius-tab_ootusy.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419346/Sagittarius_serpentarius-tab_ootusy.png',
              'image',
              'Secretary the Secretarybird'
       ),
       (
              77,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400650/Struthio_camelus_wsnrn6.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419343/Struthio_camelus-tab_hgxxq0.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419343/Struthio_camelus-tab_hgxxq0.png',
              'image',
              'Ostrich the Ostrich'
       ),
       (
              78,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400653/Vanellus_albiceps_eqvtod.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419354/Vanellus_albiceps-tab_r8lm4c.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419354/Vanellus_albiceps-tab_r8lm4c.png',
              'image',
              'Crown the White-crowned Lapwing'
       ),
       (
              79,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400627/Vanellus_armatus_cmjqfn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419339/Vanellus_armatus-tab_wzukt8.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766419339/Vanellus_armatus-tab_wzukt8.png',
              'image',
              'Blacksmith the Blacksmith Lapwing'
       ),
       -- Swamp Reptiles (82-87)
       (
              80,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401683/Acanthochelys_spixii_ovkzk6.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421187/Acanthochelys_spixii-tab_saoe9o.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421187/Acanthochelys_spixii-tab_saoe9o.png',
              'image',
              'Spine the Swamp Turtle'
       ),
       (
              81,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401669/Alligator_mississippiensis_hpmkev.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421187/Alligator_mississippiensis-tab_i2gify.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421187/Alligator_mississippiensis-tab_i2gify.png',
              'image',
              'Alli the American Alligator'
       ),
       (
              82,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401688/caiman_yacare_oukor8.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421188/caiman_yacare-tab_zv9kxm.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421188/caiman_yacare-tab_zv9kxm.png',
              'image',
              'Yacare the Yacare Caiman'
       ),
       (
              83,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401674/Crocodylus_niloticus_zpof9r.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421189/Crocodylus_niloticus-tab_qnscq9.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421189/Crocodylus_niloticus-tab_qnscq9.png',
              'image',
              'Nile the Nile Crocodile'
       ),
       (
              84,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401664/Gavialis_gangeticus_gkmbrm.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421189/Gavialis_gangeticus-tab_n9oau2.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421189/Gavialis_gangeticus-tab_n9oau2.png',
              'image',
              'Gharial the Gharial'
       ),
       (
              85,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766401678/Melanosuchus_niger_xm1tff.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421189/Melanosuchus_niger-tab_q04okk.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766421189/Melanosuchus_niger-tab_q04okk.png',
              'image',
              'Black the Black Caiman'
       ),
       -- Savannah Reptiles (88-92)
       (
              86,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400260/agama_agama_m16cnd.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418343/agama_agama-tab_q6hhxt.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418343/agama_agama-tab_q6hhxt.png',
              'image',
              'Agama the Agama Lizard'
       ),
       (
              87,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400262/Aldabrachelys_gigantea_bptz2j.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418348/Aldabrachelys_gigantea-tab_poqmju.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418348/Aldabrachelys_gigantea-tab_poqmju.png',
              'image',
              'Giant the Aldabra Giant Tortoise'
       ),
       (
              88,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400258/chamaeleo_africanus_ouxeun.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418351/chamaeleo_africanus-tab_uqqauh.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418351/chamaeleo_africanus-tab_uqqauh.png',
              'image',
              'Chameleon the African Chameleon'
       ),
       (
              89,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400266/Gopherus_evgoodei_wxrm1i.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418345/Gopherus_evgoodei-tab_bqlopw.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418345/Gopherus_evgoodei-tab_bqlopw.png',
              'image',
              'Gopherus the Thornscrub Tortoise'
       ),
       (
              90,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766400264/Hemidactylus_turcicus_qjl2fj.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418340/Hemidactylus_turcicus-tab_htjmrn.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418340/Hemidactylus_turcicus-tab_htjmrn.png',
              'image',
              'Gecko the Mediterranean House Gecko'
       ),
       -- Jungle Amphibians (93-97)
       (
              91,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399988/Agalychnis_callidryas_jd6ce6.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418085/Agalychnis_callidryas-tab_rytokq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418085/Agalychnis_callidryas-tab_rytokq.png',
              'image',
              'Eyes the Red-Eyed Tree Frog'
       ),
       (
              92,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399981/Dendrobates_tinctorius_azureus_wwdxkg.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418092/Dendrobates_tinctorius_azureus-tab_ec66qx.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418092/Dendrobates_tinctorius_azureus-tab_ec66qx.png',
              'image',
              'Blue the Blue Poison Dart Frog'
       ),
       (
              93,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399983/Hyalinobatrachium_fleischmanni_jbdvxw.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418090/Hyalinobatrachium_fleischmanni-tab_ajcobu.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418090/Hyalinobatrachium_fleischmanni-tab_ajcobu.png',
              'image',
              'Crystal the Northern Glass Frog'
       ),
       (
              94,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399984/Phyllobates_terribilis_cspwx4.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418095/Phyllobates_terribilis-tab_xkbtlp.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418095/Phyllobates_terribilis-tab_xkbtlp.png',
              'image',
              'Golden the Golden Poison Frog'
       ),
       (
              95,
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766399986/Phyllomedusa_bicolor_limjiq.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418087/Phyllomedusa_bicolor-tab_n5zaja.png',
              'https://res.cloudinary.com/dxkdwzbs6/image/upload/v1766418087/Phyllomedusa_bicolor-tab_n5zaja.png',
              'image',
              'Bicolor the Bicolored Tree Frog'
       );

-- 18. Link MEDIA to ANIMALS
INSERT INTO
       media_relations (media_id, related_table, related_id, usage_type)
VALUES
       (1, 'animal_full', 1, 'main'),
       (2, 'animal_full', 2, 'main'),
       (3, 'animal_full', 3, 'main'),
       (4, 'animal_full', 4, 'main'),
       (5, 'animal_full', 5, 'main'),
       (6, 'animal_full', 6, 'main'),
       (7, 'animal_full', 7, 'main'),
       (8, 'animal_full', 8, 'main'),
       (9, 'animal_full', 9, 'main'),
       (10, 'animal_full', 10, 'main'),
       (11, 'animal_full', 11, 'main'),
       (12, 'animal_full', 12, 'main'),
       (13, 'animal_full', 13, 'main'),
       (14, 'animal_full', 14, 'main'),
       (15, 'animal_full', 15, 'main'),
       (16, 'animal_full', 16, 'main'),
       (17, 'animal_full', 17, 'main'),
       (18, 'animal_full', 18, 'main'),
       (19, 'animal_full', 19, 'main'),
       (20, 'animal_full', 20, 'main'),
       (21, 'animal_full', 21, 'main'),
       (22, 'animal_full', 22, 'main'),
       (23, 'animal_full', 23, 'main'),
       (24, 'animal_full', 24, 'main'),
       (25, 'animal_full', 25, 'main'),
       (26, 'animal_full', 26, 'main'),
       (27, 'animal_full', 27, 'main'),
       (28, 'animal_full', 28, 'main'),
       (29, 'animal_full', 29, 'main'),
       (30, 'animal_full', 30, 'main'),
       (31, 'animal_full', 31, 'main'),
       (32, 'animal_full', 32, 'main'),
       (33, 'animal_full', 33, 'main'),
       (34, 'animal_full', 34, 'main'),
       (35, 'animal_full', 35, 'main'),
       (36, 'animal_full', 36, 'main'),
       (37, 'animal_full', 37, 'main'),
       (38, 'animal_full', 38, 'main'),
       (39, 'animal_full', 39, 'main'),
       (40, 'animal_full', 40, 'main'),
       (41, 'animal_full', 41, 'main'),
       (42, 'animal_full', 42, 'main'),
       (43, 'animal_full', 43, 'main'),
       (44, 'animal_full', 44, 'main'),
       (45, 'animal_full', 45, 'main'),
       (46, 'animal_full', 46, 'main'),
       (47, 'animal_full', 47, 'main'),
       (48, 'animal_full', 48, 'main'),
       (49, 'animal_full', 49, 'main'),
       (50, 'animal_full', 50, 'main'),
       (51, 'animal_full', 51, 'main'),
       (52, 'animal_full', 52, 'main'),
       (53, 'animal_full', 53, 'main'),
       (54, 'animal_full', 54, 'main'),
       (55, 'animal_full', 55, 'main'),
       (56, 'animal_full', 56, 'main'),
       (57, 'animal_full', 57, 'main'),
       (58, 'animal_full', 58, 'main'),
       (59, 'animal_full', 59, 'main'),
       (60, 'animal_full', 60, 'main'),
       (61, 'animal_full', 61, 'main'),
       (62, 'animal_full', 62, 'main'),
       (63, 'animal_full', 63, 'main'),
       (64, 'animal_full', 64, 'main'),
       (65, 'animal_full', 65, 'main'),
       (66, 'animal_full', 66, 'main'),
       (67, 'animal_full', 67, 'main'),
       (68, 'animal_full', 68, 'main'),
       (69, 'animal_full', 69, 'main'),
       (70, 'animal_full', 70, 'main'),
       (71, 'animal_full', 71, 'main'),
       (72, 'animal_full', 72, 'main'),
       (73, 'animal_full', 73, 'main'),
       (74, 'animal_full', 74, 'main'),
       (75, 'animal_full', 75, 'main'),
       (76, 'animal_full', 76, 'main'),
       (77, 'animal_full', 77, 'main'),
       (78, 'animal_full', 78, 'main'),
       (79, 'animal_full', 79, 'main'),
       (80, 'animal_full', 80, 'main'),
       (81, 'animal_full', 81, 'main'),
       (82, 'animal_full', 82, 'main'),
       (83, 'animal_full', 83, 'main'),
       (84, 'animal_full', 84, 'main'),
       (85, 'animal_full', 85, 'main'),
       (86, 'animal_full', 86, 'main'),
       (87, 'animal_full', 87, 'main'),
       (88, 'animal_full', 88, 'main'),
       (89, 'animal_full', 89, 'main'),
       (90, 'animal_full', 90, 'main'),
       (91, 'animal_full', 91, 'main'),
       (92, 'animal_full', 92, 'main'),
       (93, 'animal_full', 93, 'main'),
       (94, 'animal_full', 94, 'main'),
       (95, 'animal_full', 95, 'main');

-- ============================================================
-- END OF SEED DATA FOR ANIMALS (Categories, Species, Nutrition, Animals)
-- ✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨✨
-- ============================================================
INSERT INTO
       health_state_report (
              full_animal_id,
              hsr_state,
              vet_obs,
              checked_by,
              opt_details
       )
VALUES
       (
              1,
              'healthy',
              'Subject: Bamboo
                  - Appearance: Coat clean/dense.
                  - Posture: Upright while feeding.
                  - Movement: Normal climbing/gait.
                  - Digestion: Fibrous green bolus.
                  - Behavior: Active foraging.',
              2,
              'Male Panda. 
               Status: healthy.
               BCS: 3/5 (Ideal weight).
               High dexterity in pseudo-thumb.
               Responsive to environment.
               No signs of stress or stereotypic pacing.
               Stable condition.'
       ),
       (
              2,
              'healthy',
              'Subject: Rufus
                  - Appearance: Rich reddish-brown fur, no patches.
                  - Posture: Active brachiating and tail use.
                  - Vocalization: Strong, normal morning howling.
                  - Movement: Fluid climbing, grip strength normal.
                  - Eyes: Clear, responsive to keepers.',
              2,
              'Male Howler Monkey. 
               Status: healthy.
               BCS: 3/5 (Ideal).
               Strong prehensile tail control.
               Feeding well on leafy greens and fruits.
               Socially integrated with the group.
               No signs of lethargy.'
       ),
       (
              3,
              'happy',
              'Subject: Fuzzy
                  - Appearance: Coarse black fur in excellent condition.
                  - Posture: Relaxed, draped over high branch using prehensile tail.
                  - Movement: Agile climbing, showing good coordination.
                  - Scent: Strong characteristic scent (normal marking).
                  - Behavior: Highly inquisitive and seeking enrichment.',
              2,
              'Male Binturong. 
               Status: happy.
               BCS: 3/5.
               Enjoying fruit-based enrichment.
               Prehensile tail strength is optimal.
               No signs of respiratory distress.
               Very active during dusk observation.
               Stable in jungle habitat.'
       ),
       (
              4,
              'good_condition',
              'Subject: Nyx
                  - Appearance: Patagium (wing membrane) intact and elastic.
                  - Posture: Hanging securely by hind claws in shaded area.
                  - Movement: Quick, erratic flight patterns observed during feeding.
                  - Eyes: Small, dark, and clear.
                  - Respiration: Stable during rest.',
              2,
              'Female Fruit Bat. 
               Status: good_condition.
               BCS: 3/5.
               High consumption of soft fruits (mango/papaya).
               Wing membranes show no signs of tearing or dryness.
               Socializing well with the colony.
               Weight is stable for an adult female.
               Stable in jungle nocturnal exhibit.'
       ),
       (
              5,
              'well',
              'Subject: Spider
                  - Appearance: Limbs are long and lean, fur is glossy.
                  - Posture: Frequent use of suspensory locomotion.
                  - Movement: Extremely agile; rapid brachiation observed.
                  - Tail: Prehensile tail shows excellent tactile sensitivity.
                  - Social: Engaging in grooming behaviors with group members.',
              2,
              'Male Spider Monkey. 
               Status: well.
               BCS: 2.5/5 (Typical lean build for this species).
               No signs of joint stiffness during high-speed swings.
               Appetite for diverse fruits and nuts is high.
               Vocalizations are clear and frequent.
               Overall excellent physical coordination.
               Stable in jungle canopy exhibit.'
       ),
       (
              6,
              'healthy',
              'Subject: Sloth
                  - Appearance: Algae growth on fur (normal symbiotic relationship).
                  - Posture: Securely suspended; neck rotation reaches 270 degrees.
                  - Movement: Typically slow, showing coordinated limb placement.
                  - Digestion: Stomach appears distended (normal slow digestion).
                  - Claws: All three claws on each limb are sharp and intact.',
              2,
              'Male Three-toed Sloth. 
               Status: healthy.
               BCS: 3/5.
               Monitoring slow metabolic rate (standard for species).
               Respiratory rate is low but steady.
               No signs of ectoparasites beyond normal moths.
               Fecal descent occurs weekly (normal cycle).
               Stable in jungle high-canopy habitat.'
       ),
       (
              7,
              'well',
              'Subject: Surya
                  - Appearance: Skin is thick and well-hydrated; no lesions.
                  - Posture: Even weight distribution across all four limbs.
                  - Movement: Steady gait; no signs of joint discomfort.
                  - Trunk: High muscle tone and full range of motion.
                  - Ears: Active flapping for thermoregulation.',
              2,
              'Male Asian Elephant. 
               Status: well.
               BCS: 3.5/5.
               Foot pads checked: no cracks or foreign objects.
               Consuming full ration of hay and supplemental browse.
               Temporal glands show no abnormal discharge.
               Social interaction with herd is positive.
               Stable in jungle/grassland transition habitat.'
       ),
       (
              8,
              'healthy',
              'Subject: Sunny
                  - Appearance: Short, sleek black fur; chest patch is vivid.
                  - Posture: Active; often standing on hind legs to scout.
                  - Movement: Agile climbing; claws provide excellent grip.
                  - Tongue: Fully functional, used for foraging enrichment.
                  - Teeth: Canines and molars in good condition.',
              2,
              'Male Sun Bear. 
               Status: healthy.
               BCS: 3/5.
               Very active during foraging activities.
               Long claws are naturally worn but strong.
               No signs of dental decay from fruit/honey diet.
               Characteristic "U" shaped chest patch is clear.
               Stable in jungle arboreal habitat.'
       ),
       (
              9,
              'healthy',
              'Subject: Spots
                  - Appearance: Rosette pattern is distinct; fur is sleek.
                  - Posture: Low-profile stalking posture, very alert.
                  - Movement: Silent and fluid gait; paws in perfect condition.
                  - Eyes: Pupils reacting normally to light changes.
                  - Claws: Fully retracting; no signs of overgrowth.',
              2,
              'Female Ocelot. 
               Status: healthy.
               BCS: 3/5.
               High responsiveness to auditory enrichment.
               Weight is stable and muscle tone is lean.
               Dental exam shows clean canines, no gingivitis.
               Active nocturnal hunter behavior observed.
               Stable in jungle undergrowth habitat.'
       ),
       (
              10,
              'well',
              'Subject: Tail
                  - Appearance: Banded tail is long and held upright.
                  - Snout: Highly mobile and moist; no nasal discharge.
                  - Movement: Constant foraging behavior; energetic pace.
                  - Claws: Strong and blunt, adapted for digging.
                  - Social: High interaction levels with the female band.',
              2,
              'Female Coati. 
               Status: well.
               BCS: 3/5.
               Olfactory response is excellent.
               Consuming varied diet (insects, fruit, and eggs).
               Tail used effectively for balance during climbing.
               No signs of dental issues in elongated jaw.
               Stable in jungle floor and canopy habitat.'
       ),
       (
              11,
              'healthy',
              'Subject: Jaguar
                  - Appearance: Powerful build, rosettes with internal spots.
                  - Posture: Firm and dominant; high muscular definition.
                  - Movement: Heavy but silent gait; excellent swimmer.
                  - Jaw: Massive masseter muscles; gums are healthy pink.
                  - Eyes: Golden-yellow, focused, and clear.',
              2,
              'Male Jaguar. 
               Status: healthy.
               BCS: 3.5/5 (Strong muscular condition).
               Jaw strength is optimal; dental ridge is clean.
               Water-entry behavior observed; no skin issues from moisture.
               Paws are large and pads are thick, no cracks.
               Territorial marking behavior is consistent.
               Stable in deep jungle habitat.'
       ),
       (
              12,
              'healthy',
              'Subject: Rajah
                  - Appearance: Deep orange coat with sharp black stripes.
                  - Posture: Massive frame; shoulders show high muscle tone.
                  - Movement: Powerful, confident stride; no joint clicking.
                  - Teeth: Canines are intact; no tartar buildup on carnassials.
                  - Respiration: Deep and regular, even after physical exertion.',
              2,
              'Male Bengal Tiger. 
               Status: healthy.
               BCS: 3/5 (Perfect muscular balance).
               Weight is optimal for an adult male.
               No signs of lameness or paw pad irritation.
               Responsive to training and vocal cues.
               Drinking and feeding patterns are consistent.
               Stable in jungle/marshland habitat.'
       ),
       (
              13,
              'healthy',
              'Subject: Armor
                  - Appearance: Carapace is hard and intact; no cracked scales.
                  - Posture: Low to the ground; legs tucked slightly under shell.
                  - Movement: Strong digging action; gait is steady and heavy.
                  - Claws: Large central claw is sharp and structurally sound.
                  - Skin: Soft skin between pelvic and scapular shields is pink/clean.',
              2,
              'Male Giant Armadillo. 
               Status: healthy.
               BCS: 3/5.
               Flexibility of the 11 to 13 moveable bands is optimal.
               No signs of infection in the abdominal soft tissue.
               Powerful digging behavior observed in nocturnal hours.
               Thermoregulation is normal; seeking cool soil as needed.
               Stable in deep jungle floor habitat.'
       ),
       (
              14,
              'well',
              'Subject: Swift
                  - Appearance: Uniform tan coat; clear of debris or parasites.
                  - Posture: Extremely lean and muscular; ready for propulsion.
                  - Movement: Exceptional jumping ability; joints are silent.
                  - Paws: Large hind feet provide great stability and power.
                  - Eyes: Large pupils; tracking movement with high precision.',
              2,
              'Female Puma. 
               Status: well.
               BCS: 3/5.
               High vertical leap capability observed (normal for species).
               Dental check: Carnassials are sharp and align perfectly.
               Auditory response: Ears rotate 180 degrees to catch sounds.
               Metabolic rate is steady; eating well.
               Stable in jungle/scrubland transition habitat.'
       ),
       (
              15,
              'healthy',
              'Subject: Tongue
                  - Appearance: Distinctive "black vest" pattern over tan fur.
                  - Snout: Long and tubular; nostrils clear of obstructions.
                  - Tongue: Highly extensible and moist (essential for feeding).
                  - Movement: Slow on ground but very agile in climbing.
                  - Tail: Strong prehensile grip; skin on underside is healthy.',
              2,
              'Male Southern Tamandua. 
               Status: healthy.
               BCS: 3/5.
               Large claws on front limbs are sharp for breaking termite nests.
               No signs of oral lesions or tongue dryness.
               Effective use of tail as a fifth limb during arboreal activity.
               Responds well to olfactory enrichment (honey/insects).
               Stable in jungle canopy habitat.'
       ),
       (
              16,
              'healthy',
              'Subject: Tapir
                  - Appearance: Bristly dark brown coat; mane is erect.
                  - Proboscis: Flexible and reactive; no signs of congestion.
                  - Eyes: Clear, no cloudiness (often prone to corneal issues).
                  - Feet: Three toes on hind feet and four on front are intact.
                  - Skin: Thick hide is healthy; no signs of fungal infection.',
              2,
              'Female South American Tapir. 
               Status: healthy.
               BCS: 3.5/5.
               Proboscis functionality is excellent for grasping vegetation.
               Weight distribution is normal; no lameness in damp terrain.
               Auditory sense is sharp; ears are highly mobile.
               Regular defecation in water (normal species behavior).
               Stable in jungle riverside habitat.'
       ),
       (
              17,
              'well',
              'Subject: Andes
                  - Appearance: Thick black fur; distinct cream spectacles.
                  - Posture: Robust; often seen resting in elevated platforms.
                  - Movement: Excellent vertical climbing; strong pectoral muscles.
                  - Mouth: Strong molars for crushing bromeliads and palms.
                  - Behavior: Solitary and calm during observation.',
              2,
              'Male Spectacled Bear. 
               Status: well.
               BCS: 3/5.
               Facial markings are clear and skin underneath is healthy.
               Arboreal activity is high; claws are in great condition.
               Dietary intake of fibrous plants is normal.
               No signs of dental wear on large chewing surfaces.
               Stable in cloud forest/jungle transition habitat.'
       ),
       (
              18,
              'healthy',
              'Subject: Civet
                  - Appearance: Distinctive black spinal stripe and spotted flanks.
                  - Neck: Bold black and white throat bands are clean.
                  - Movement: Low-slung, agile gait; very responsive to sound.
                  - Tail: Fully banded; no signs of alopecia or injury.
                  - Glands: Scent marking behavior is normal and active.',
              2,
              'Female Malayan Civet. 
               Status: healthy.
               BCS: 3/5.
               Nocturnal activity levels are optimal.
               Scent glands are clear of blockages or inflammation.
               Claws are semi-retractable and show normal wear.
               Dental health: Sharp carnassials for omnivorous diet.
               Stable in jungle floor/dense brush habitat.'
       ),
       (
              19,
              'healthy',
              'Subject: Lightning
                  - Appearance: Lean, aerodynamic build; tear marks are symmetrical.
                  - Spine: Exceptional flexibility; no signs of vertebral stiffness.
                  - Movement: Explosive acceleration; non-retractable claws are sharp.
                  - Respiration: Large nasal passages allow for rapid oxygen intake.
                  - Feet: Hard, ridge-like paw pads for high-speed traction.',
              2,
              'Male East African Cheetah. 
               Status: healthy.
               BCS: 2.5/5 (Ideal lean athletic condition).
               Cardiovascular check: Resting heart rate is stable.
               Non-retractable claws provide excellent grip during sprints.
               Tail used effectively as a rudder during high-speed turns.
               Dental exam: Small canines but healthy jaw alignment.
               Stable in savannah open-plain habitat.'
       ),
       (
              20,
              'well',
              'Subject: Jumper
                  - Appearance: Sleek reddish-brown coat; distinct white underbelly.
                  - Horns: Symmetrical, ridged, and firmly attached to the skull.
                  - Movement: High-velocity leaping (metatarsal glands are active).
                  - Eyes: Large, lateral placement; clear 360-degree awareness.
                  - Hooves: Sharp and even; no signs of overgrowth or rot.',
              2,
              'Male Impala. 
               Status: well.
               BCS: 3/5.
               Propulsion muscles in hindquarters show high power.
               Scent glands on hind legs are functioning for herd cohesion.
               Vigilant behavior; normal response to savannah stimuli.
               Dental check: Herbivorous grinding surfaces are intact.
               Stable in savannah grassland habitat.'
       ),
       (
              21,
              'healthy',
              'Subject: Horn
                  - Appearance: Massive slate-gray body; skin folds are clean.
                  - Horn: Primary and secondary horns are sturdy and well-shaped.
                  - Mouth: Wide, square lip (characteristic of species) is flexible.
                  - Movement: Surprisingly agile for weight; steady, heavy gait.
                  - Feet: Three-toed structure shows even wear on all hooves.',
              2,
              'Male White Rhinoceros. 
               Status: healthy.
               BCS: 3.5/5.
               Keratin structure of the horn shows no deep fissures.
               Skin condition: Mud-wallowing behavior is maintaining hydration.
               No signs of pressure sores on hocks or digits.
               Grazing efficiency is high due to healthy square-lip muscle.
               Stable in savannah open-grassland habitat.'
       ),
       (
              22,
              'well',
              'Subject: Blue
                  - Appearance: Slate gray coat with dark vertical stripes.
                  - Horns: Cow-like, curving outward and then inward; secure base.
                  - Movement: Constant roaming; high endurance in trot and gallop.
                  - Mane/Tail: Thick, black terminal hair; no signs of parasites.
                  - Hooves: Cloven hooves are hard and adapted for dry soil.',
              2,
              'Male Blue Wildebeest. 
               Status: well.
               BCS: 3/5.
               Cardiovascular endurance is excellent.
               Social dominance behavior observed within the herd.
               Grazing frequency is normal for a bulk feeder.
               No signs of respiratory distress after high-speed bursts.
               Stable in savannah plains habitat.'
       ),
       (
              23,
              'healthy',
              'Subject: Laugh
                  - Appearance: Spotted sandy coat; neck is exceptionally thick.
                  - Jaw: Massive zygomatic arches; teeth can crush dense bone.
                  - Posture: Sloping back profile (front legs longer than hind).
                  - Ears: Rounded and alert; high sensitivity to vocalizations.
                  - Movement: Efficient, loping gait with high stamina.',
              2,
              'Female Spotted Hyena. 
               Status: healthy.
               BCS: 3.5/5.
               Dental check: Enamel is intact despite bone-crushing diet.
               Alpha female behavior observed; high social confidence.
               Digestive system: Normal production of "white scat" (calcium-rich).
               Muscle tone in forequarters is extremely developed.
               Stable in savannah scrubland habitat.'
       ),
       (
              24,
              'well',
              'Subject: Topi
                  - Appearance: Deep reddish-brown coat with purple sheen.
                  - Mask: Dark facial and leg patches are well-defined.
                  - Horns: Lyrate-shaped, heavily ringed; stable and symmetrical.
                  - Movement: Fluid, high-speed galloping; no signs of hoof rot.
                  - Posture: Often stands on elevated ground; vigilant stance.',
              2,
              'Male Topi. 
               Status: well.
               BCS: 3/5.
               High muscular definition in the shoulders and hocks.
               Alertness levels are optimal for a sentinel species.
               Ruminating normally; no signs of abdominal bloating.
               Hooves are hard and self-wearing on dry savannah soil.
               Stable in savannah open-plain habitat.'
       ),
       (
              25,
              'healthy',
              'Subject: Stripes
                  - Appearance: Grid-iron pattern on rump; clean white belly.
                  - Throat: Dewlap (skin fold) is prominent and healthy.
                  - Hooves: Hard, fast-growing; no signs of laminitis or cracks.
                  - Movement: Strong, rhythmic gallop; knees and hocks are supple.
                  - Teeth: Incisors align perfectly for efficient grazing.',
              2,
              'Female Mountain Zebra. 
               Status: healthy.
               BCS: 3/5.
               Hoof maintenance: Naturally worn, no corrective trimming needed.
               Gastrointestinal: Active gut sounds; normal fermentation.
               Hydration levels are optimal; skin pinch test is elastic.
               Social status: Integrated well with the harem.
               Stable in rocky savannah/sloped habitat.'
       ),
       (
              26,
              'healthy',
              'Subject: Neck
                  - Appearance: Large, pale orange-brown blotches; coat is sleek.
                  - Neck: Seven cervical vertebrae show normal alignment and range.
                  - Cardiovascular: Strong, rhythmic pulse; large heart capacity.
                  - Tongue: Prehensile, dark purple, and free of lesions.
                  - Movement: Graceful pacing gait; no signs of fetlock drop.',
              2,
              'Female West African Giraffe. 
               Status: healthy.
               BCS: 3/5.
               High-pressure vascular system is functioning normally.
               Ossicones are intact with healthy hair tufts.
               Successful foraging at height; tongue elasticity is optimal.
               Hoof health: Symmetrical wear on both digits.
               Stable in savannah woodland habitat.'
       ),
       (
              27,
              'healthy',
              'Subject: Serval
                  - Appearance: Golden-yellow coat with bold black spots and stripes.
                  - Ears: Oversized, upright, and highly mobile; "white bar" markings.
                  - Legs: Extremely long (longest relative to body size in felids).
                  - Movement: Expert pouncing; vertical jump is powerful and fluid.
                  - Tail: Relatively short for a feline, used for balance in leaps.',
              2,
              'Male Serval. 
               Status: healthy.
               BCS: 2.5/5 (Lean and lithe).
               Auditory canal check: Clear, responding to high-frequency sounds.
               Metatarsal and metacarpal bones show no signs of stress fractures.
               Dental: Sharp, needle-like teeth for small prey consumption.
               Active hunting behavior (leaping/pouncing) observed daily.
               Stable in savannah wetlands/tall grass habitat.'
       ),
       (
              28,
              'healthy',
              'Subject: Tembo
                  - Appearance: Massive grey frame; skin is thick and wrinkled.
                  - Trunk: Highly dexterous; full range of motion in the "fingers".
                  - Tusks: Symmetrical ivory growth; no deep cracks or pulp exposure.
                  - Feet: Large, cushioned pads; nails are trimmed and healthy.
                  - Ears: Massive "map of Africa" shape; vascular cooling active.',
              2,
              'Male African Bush Elephant. 
               Status: healthy.
               BCS: 3.5/5.
               Pedicure performed: No abscesses or necrotic tissue in solar pads.
               Temporal glands: Occasional drainage (normal musth preparation).
               Hydration: Active mud bathing for thermoregulation and skin care.
               Social: Demonstrates high cognitive engagement with enrichment.
               Stable in savannah plains/woodland habitat.'
       ),
       (
              29,
              'healthy',
              'Subject: Earth
                  - Appearance: Sparse, bristly hair over pale, thick skin.
                  - Snout: Long and flexible; nostrils have dense hair filters.
                  - Claws: Shovel-like, extremely strong for breaking concrete-like mounds.
                  - Ears: Rabbit-like and highly mobile; clear of any debris.
                  - Movement: Low-slung power; highly efficient digging mechanics.',
              2,
              'Male Aardvark. 
               Status: healthy.
               BCS: 3/5.
               Nostril hair-seals are functioning to prevent dust inhalation.
               Skin check: No abrasions from burrowing activities.
               Tongue is moist and extensible (long and worm-like).
               Nocturnal activity levels are high; digging tunnels as expected.
               Dentition: Columnar teeth (no enamel) are in good condition.
               Stable in savannah burrow/grassland habitat.'
       ),
       (
              30,
              'healthy',
              'Subject: Oryx
                  - Appearance: Fawn-colored coat with bold black facial masks.
                  - Horns: Long, rapier-like, and nearly straight; ringed at the base.
                  - Movement: Steady, economical gait; adapted for long distances.
                  - Eyes: Dark and clear; no signs of irritation from dust or sun.
                  - Hooves: Large and splayed, providing stability on sand and rock.',
              2,
              'Female Beisa Oryx. 
               Status: healthy.
               BCS: 3/5.
               Physiological adaptation: Efficient water conservation observed.
               Horns are structurally sound; no fissures in the keratin sheath.
               Nasal cooling system (carotid rete) appears functioning normally.
               Social behavior: Calm temperament; maintains position in hierarchy.
               Stable in savannah semi-arid/grassland habitat.'
       ),
       (
              31,
              'healthy',
              'Subject: King
                  - Appearance: Large, muscular frame; dense tawny coat.
                  - Mane: Thick and dark; extends under the belly (species trait).
                  - Mouth: Massive canines; gums are pink and healthy.
                  - Paws: Large, heavy-padded; claws are sharp and retractable.
                  - Eyes: Amber-colored; excellent binocular focus and clarity.',
              2,
              'Male Southern African Lion. 
               Status: healthy.
               BCS: 3.5/5.
               Superior muscle mass in the cervical and pectoral regions.
               Mane coverage indicates optimal hormonal levels.
               Vocalizations (roaring) are powerful; respiratory tract is clear.
               No signs of joint stiffness during patrolling behavior.
               Stable in savannah open-woodland habitat.'
       ),
       (
              32,
              'well',
              'Subject: Leopard
                  - Appearance: Rosette-patterned coat; long, muscular tail.
                  - Muscles: High definition in the scapular (shoulder) region.
                  - Claws: Fully retractable, extremely sharp for arboreal grip.
                  - Eyes: Large pupils for low-light hunting; clear and alert.
                  - Tail: Thick and used as a precision counterbalance.',
              2,
              'Male African Leopard. 
               Status: well.
               BCS: 3/5.
               Exceptional climbing agility; ligaments in paws are healthy.
               Vibrissae (whiskers) are intact, aiding nocturnal navigation.
               Territorial marking behavior is consistent.
               Dental exam: Canines and carnassials show no fractures.
               Stable in savannah riverine/kopje habitat.'
       ),
       (
              33,
              'well',
              'Subject: Baboon
                  - Appearance: Slender build; yellowish-brown silky fur.
                  - Face: Shorter muzzle compared to other Papio species.
                  - Hands/Feet: Highly dexterous; opposable thumbs are functional.
                  - Posterior: Ischial callosities (sitting pads) are healthy.
                  - Movement: Quadrupedal walking is fluid; high arboreal agility.',
              2,
              'Male Kinda Baboon. 
               Status: well.
               BCS: 3/5.
               Dental: Large canines are intact; no gingival inflammation.
               Social behavior: Highly interactive; grooming others frequently.
               Manual dexterity: Excellent at manipulating small seeds/objects.
               Skin check: No signs of dermatitis under the fur.
               Stable in savannah woodland/gallery forest habitat.'
       ),
       (
              34,
              'healthy',
              'Subject: Warthog
                  - Appearance: Sparse grey bristles; prominent facial warts.
                  - Tusks: Upper tusks curve 180 degrees; lower tusks are sharp.
                  - Knees: Calloused pads on front carpus (kneeling pads) are intact.
                  - Tail: Tasselled at the tip; held erect during movement.
                  - Eyes: Set high on the head; clear and vigilant.',
              2,
              'Male Common Warthog. 
               Status: healthy.
               BCS: 3/5.
               Carpal callosities are thick, protecting joints while foraging.
               Tusk alignment is correct; self-sharpening mechanism is functional.
               Respiratory: Snout is moist and responsive; sense of smell is keen.
               Skin: Healthy, shows evidence of regular mud-coating for sun protection.
               Stable in savannah open-grassland habitat.'
       ),
       (
              35,
              'healthy',
              'Subject: Buffalo
                  - Appearance: Robust black frame; sparse, coarse hair.
                  - Horns: Heavy "boss" (shield) meets in the center; tips are intact.
                  - Neck: Extremely thick and muscular; no signs of skin parasites.
                  - Hooves: Large, cloven, and hard; designed for heavy trampling.
                  - Ears: Large and fringed with hair; high mobility for insect swatting.',
              2,
              'Male Cape Buffalo. 
               Status: healthy.
               BCS: 4/5.
               The cranial boss is fully ossified and shows no fractures.
               Immune system appears strong; eyes and muzzle are clear.
               Social status: High-ranking bull behavior; alert and protective.
               Excellent digestive efficiency observed in ruminating cycles.
               Thick hide is in good condition; regular wallowing behavior.
               Stable in savannah plains/dense thicket habitat.'
       ),
       (
              36,
              'well',
              'Subject: India
                  - Appearance: Slender, cat-like body; greyish with black spots/rings.
                  - Tail: Distinctively ringed with 8-9 black bands.
                  - Scent Glands: Perineal glands are active and healthy.
                  - Ears: Small, rounded, and set low on the head.
                  - Claws: Semi-retractable; sharp for climbing and pinning prey.',
              2,
              'Female Small Indian Civet. 
               Status: well.
               BCS: 2.5/5 (Lithe, athletic build).
               Scent-marking behavior is frequent (territorial health).
               Dental: Sharp carnassial teeth show no tartar or wear.
               Pelage: Coarse hair is glossy; no signs of alopecia.
               High nocturnal activity; efficient foraging for insects and fruit.
               Stable in savannah scrub/tall grass habitat.'
       ),
       (
              37,
              'well',
              'Subject: Water
                  - Appearance: Massive slate-black hide; sparse hair coverage.
                  - Horns: Wide-reaching, crescent-shaped, and ribbed.
                  - Feet: Extra-wide splayed hooves with flexible fetlocks.
                  - Skin: Thick dermis with low sweat gland density.
                  - Movement: Powerful swimmer; slow, deliberate gait on land.',
              2,
              'Male Water Buffalo. 
               Status: well.
               BCS: 3.5/5.
               Hoof health: Broad splay prevents sinking in soft substrate.
               Thermoregulation: Regular wallowing maintains core temperature.
               Nasal passages are clear; high tolerance for high-moisture air.
               Dental: Strong molars for grinding coarse aquatic vegetation.
               Stable in swamp/marshland habitat.'
       ),
       (
              38,
              'well',
              'Subject: Beaver
                  - Appearance: Dense, waterproof brown fur; robust, compact body.
                  - Teeth: Large, orange-tinted incisors (high iron content).
                  - Tail: Broad, flat, and scaly; used as a rudder and fat storage.
                  - Feet: Webbed hind feet for swimming; dexterous front paws.
                  - Eyes/Ears: Small with nictitating membranes and valvular closures.',
              2,
              'Male Eurasian Beaver. 
               Status: well.
               BCS: 3.5/5.
               Dental: Incisors are correctly aligned for self-sharpening.
               Pelage: Natural oils (castoreum) provide excellent waterproofing.
               Tail condition: No lesions; distal temperature regulation is normal.
               High activity in lodge maintenance and dam building.
               Respiratory: Clear lung sounds after prolonged immersion.
               Stable in swamp/riverine habitat.'
       ),
       (
              39,
              'healthy',
              'Subject: Fox
                  - Appearance: Short, robust limbs; grey-brown coat with black tipping.
                  - Muzzle: Relatively short and pointed; dark rhinarium.
                  - Tail: Thick and bushy, often with a black tip and dorsal stripe.
                  - Feet: Strong claws adapted for digging in soft, muddy terrain.
                  - Ears: Medium-sized; keen auditory response to nocturnal movements.',
              2,
              'Male Crab-eating Fox. 
               Status: healthy.
               BCS: 3/5.
               Gastrointestinal: High tolerance for varied diet (fruit/crustaceans).
               Pads: Interdigital skin is healthy, no signs of fungal infection.
               Dental: Generalist dentition is intact; moderate wear on molars.
               Behavior: Cautious but active during crepuscular hours.
               Stable in swamp/seasonally flooded savannah habitat.'
       ),
       (
              40,
              'healthy',
              'Subject: Hippo
                  - Appearance: Barrel-shaped torso; smooth, hairless grey-pink skin.
                  - Mouth: Massive gape (up to 150 degrees); tusks are long and sharp.
                  - Head: Eyes, ears, and nostrils are positioned on top of the skull.
                  - Feet: Four-toed, semi-webbed structure for weight distribution.
                  - Skin: Secretes "blood sweat" (reddish hipposudoric acid) for protection.',
              2,
              'Male Common Hippopotamus. 
               Status: healthy.
               BCS: 4/5.
               Skin hydration is optimal; "blood sweat" secretion is active.
               Dental: Lower canines are clear of abscesses; correct alignment.
               Respiratory: Normal breath-holding cycles observed (up to 5 min).
               Gastrointestinal: Heavy grazing activity; no signs of bloat.
               Stable in swamp/riverine habitat.'
       ),
       (
              41,
              'well',
              'Subject: Capy
                  - Appearance: Heavy, blunt muzzle; coarse reddish-brown fur.
                  - Feet: Partially webbed; 4 toes on front feet, 3 on hind feet.
                  - Teeth: Two pairs of large, ever-growing incisors; clear of plaque.
                  - Eyes/Ears: High-set on the head, typical of semi-aquatic mammals.
                  - Movement: Efficient swimmer; agile on land for its size.',
              2,
              'Female Capybara. 
               Status: well.
               BCS: 3/5.
               Dental: Molar occlusion is normal; incisors show natural wear.
               Skin: Healthy hydration; no signs of dry-skin dermatitis.
               Interdigital webbing is intact and free of fungal lesions.
               Digestive: Active cecotrophy (normal for nutritional efficiency).
               Social: Calm temperament; integrates well with the group.
               Stable in swamp/riverbank habitat.'
       ),
       (
              42,
              'well',
              'Subject: Otter
                  - Appearance: Long, streamlined body; dense chocolate-brown fur.
                  - Tail: Thick at the base, tapering towards the end (muscular rudder).
                  - Vibrissae: Long, stiff whiskers; highly sensitive to vibrations.
                  - Feet: Fully webbed; claws are short and strong.
                  - Movement: Extremely fluid swimming; serpentine motion on land.',
              2,
              'Female Eurasian Otter. 
               Status: well.
               BCS: 3/5.
               Pelage integrity: Guard hairs and underfur are perfectly waterproof.
               Metabolism: High calorie intake required; active hunting observed.
               Auditory: Ear valves closure is functional during dives.
               Vibrissae response: Normal reaction to tactile stimuli in water.
               Social: Solitary but territorial markings are consistent.
               Stable in swamp/estuary habitat.'
       ),
       (
              43,
              'well',
              'Subject: Shrew
                  - Appearance: Slate-black dorsal fur with a silver-white belly.
                  - Feet: Fringes of stiff hairs on feet and tail (act as oars).
                  - Mouth: Red-tipped teeth; submandibular glands produce toxin.
                  - Sensory: Tiny eyes; relies on long snout and whiskers.
                  - Movement: Hyperactive; can run on the surface of the water.',
              2,
              'Female Eurasian Water Shrew. 
               Status: well.
               BCS: 2.5/5.
               Metabolism: Extremely high; requiring frequent insect/crustacean prey.
               Toxicology: Venomous saliva is active (used to paralyze prey).
               Pelage: Air-trapping fur provides buoyancy and insulation.
               Respiratory: Rapid respiratory rate is normal for this species.
               Stable in swamp/edge of freshwater habitat.'
       ),
       (
              44,
              'well',
              'Subject: Muskrat
                  - Appearance: Stocky body; waterproof reddish-brown fur.
                  - Tail: Long, scaly, and laterally flattened (unique rudder).
                  - Mouth: Folds of skin (valvular) behind incisors for underwater chewing.
                  - Feet: Hind feet are large with swimming fringes (semi-webbed).
                  - Scent: Pronounced musk glands near the base of the tail.',
              2,
              'Male Muskrat. 
               Status: well.
               BCS: 3/5.
               Dental: Incisors show healthy growth; can gnaw while submerged.
               Thermoregulation: Regional heterothermy in tail/limbs is functional.
               Respiratory: High tolerance for CO2 during 15-minute dives.
               Scent glands are producing musk normally for territory marking.
               Stable in swamp/marshland habitat.'
       ),
       (
              45,
              'healthy',
              'Subject: Giant
                  - Appearance: Exceptionally long body; chocolate-brown velvet fur.
                  - Neck: Distinctive cream-colored throat patches (unique ID).
                  - Tail: Broad, muscular, and dorso-ventrally flattened at the end.
                  - Feet: Large, fully webbed paws with prominent claws.
                  - Sensory: Large, sensitive whiskers; acute underwater vision.',
              2,
              'Male Giant Otter. 
               Status: healthy.
               BCS: 3.5/5.
               High muscular density in the pelvic and caudal regions.
               Throat markings are clear and skin is free of irritations.
               Gastrointestinal: High metabolic rate; efficient fish digestion.
               Vocalizations: Highly communicative; social barking is frequent.
               Excellent swimming propulsion and agile maneuvering.
               Stable in swamp/slow-moving river habitat.'
       ),
       (
              46,
              'healthy',
              'Subject: Manatee
                  - Appearance: Gray, wrinkled skin; sparse bristles on the snout.
                  - Tail: Large, paddle-shaped horizontal fluke.
                  - Flippers: Flexible pectoral fins; presence of three vestigial nails.
                  - Mouth: Prehensile split lips for grasping aquatic plants.
                  - Eyes: Small with a circular sphincter-like closure.',
              2,
              'Female West Indian Manatee. 
               Status: healthy.
               BCS: 3.5/5.
               Respiratory: Sustained breath-holding; nostrils seal perfectly.
               Dental: Continuous horizontal molar replacement is active.
               Skin: Healthy thickness; minor commensal algae growth (normal).
               Buoyancy control: Dense, heavy bones (pachyostosis) are functional.
               Digestive: Active fermentation; abdomen is soft and non-distended.
               Stable in swamp/estuarine coastal habitat.'
       ),
       (
              47,
              'healthy',
              'Subject: Green
                  - Appearance: Deep red plumage; teal-green wing coverts.
                  - Bill: Large, hooked beak; black upper mandible, pale lower.
                  - Face: Bare white skin with fine lines of small red feathers.
                  - Feet: Zygodactyl (two toes forward, two backward).
                  - Tail: Long, pointed, primarily red with blue tips.',
              2,
              'Male Red-and-green Macaw. 
               Status: healthy.
               BCS: 3/5 (Breast muscles are firm and well-developed).
               Feather condition: Intact rachis and barbs; preening is active.
               Respiratory: Clear air sacs; no nasal discharge from cere.
               Grip strength: Powerful hallux and forward digits.
               Oral: Tongue is muscular and healthy; beak is correctly aligned.
               Stable in tropical jungle/canopy habitat.'
       ),
       (
              48,
              'well',
              'Subject: Horn
                  - Appearance: Large black body; white tail with a black band.
                  - Casque: Large, upward-curved orange/red horn-like structure.
                  - Bill: Massive, reinforced with keratin; clean margins.
                  - Eyes: Prominent eyelashes (modified feathers); clear iris.
                  - Feet: Strong, dark grey; adapted for perching on thick branches.',
              2,
              'Male Rhinoceros Hornbill. 
               Status: well.
               BCS: 3/5.
               Casque integrity: Solid keratinous structure; no fissures or peeling.
               Feathering: Wing feathers are robust; molting cycle is normal.
               Respiratory: Clear resonance in vocalizations; no audible stridor.
               Behavior: High alertness; active exploration of canopy levels.
               Oral: Interior of the beak is healthy; tongue is responsive.
               Stable in tropical jungle/high-canopy habitat.'
       ),
       (
              49,
              'well',
              'Subject: Blue
                  - Appearance: Brilliant turquoise-blue plumage; purple throat/belly.
                  - Bill: Short, broad, and black; adapted for swallowing berries.
                  - Wings: Slightly rounded; feathers show structural coloration.
                  - Feet: Small, dark grey; three toes forward, one backward.
                  - Tail: Short and square; feathers are intact and glossy.',
              2,
              'Male Spangled Cotinga. 
               Status: well.
               BCS: 2.5/5.
               Feather condition: Excellent; no signs of stress bars.
               Uropygial gland is active; preening behavior is frequent.
               Respiratory: Clear breaths; high-altitude vocalizations are normal.
               Digestive: Crop is functioning well; fruit-based diet processing.
               Movement: High agility within the canopy.
               Stable in tropical jungle/canopy habitat.'
       ),
       (
              50,
              'well',
              'Subject: Eagle
                  - Appearance: Massive grey-white body; double-crested black crown.
                  - Talons: Extremely large (up to 13cm); black, sharp, and curved.
                  - Bill: Strongly hooked; dark grey keratin; high bite force.
                  - Wings: Broad and relatively short for maneuverability in trees.
                  - Eyes: Large, forward-facing; intense grey or orange iris.',
              2,
              'Female Harpy Eagle. 
               Status: well.
               BCS: 3.5/5 (Robust pectoral muscle mass).
               Pododermatitis check: Foot pads are thick and healthy; no lesions.
               Grip strength: Exceptional; hallux tendon is fully functional.
               Feathering: Crest feathers respond to stimuli; no frayed primary feathers.
               Vision: Rapid pupillary light reflex; acute distance focus.
               Respiratory: Strong, clear vocalizations; high aerobic capacity.
               Stable in tropical jungle/emergent tree habitat.'
       ),
       (
              51,
              'well',
              'Subject: Quetzal
                  - Appearance: Iridescent green plumage; vibrant red breast/belly.
                  - Tail: Extremely long green upper tail coverts (streamers).
                  - Bill: Short, yellow, and partially hidden by bristly feathers.
                  - Feet: Heterodactyl (toes 1 & 2 backward, 3 & 4 forward).
                  - Skin: Remarkably thin and easily damaged; requires careful handling.',
              2,
              'Male Resplendent Quetzal. 
               Status: well.
               BCS: 2.5/5.
               Plumage: Iridescence is high; long tail coverts are intact and clean.
               Integument: Skin is healthy; no signs of feather cysts or parasites.
               Digestive: Efficient regurgitation of large seeds from wild fruits.
               Respiratory: Normal breath sounds; stable in high-humidity environment.
               Behavior: Vigilant; normal perching and nesting activity.
               Stable in cloud forest/jungle habitat.'
       ),
       (
              52,
              'well',
              'Subject: Peck
                  - Appearance: Bright green upperparts; red crown and black lores.
                  - Bill: Strong, dagger-like; reinforced keratin for wood boring.
                  - Tongue: Long, barbed, and coated with sticky saliva.
                  - Tail: Stiff, pointed rectrices (tail feathers) for support.
                  - Feet: Zygodactyl; sharp claws for vertical bark clinging.',
              2,
              'Male Eurasian Green Woodpecker. 
               Status: well.
               BCS: 3/5.
               Cranial: No signs of concussion or trauma; hyoid apparatus is functional.
               Oral: Tongue extends fully; salivary glands are active and sticky.
               Feathering: Tail feathers show expected wear from trunk support.
               Gait: Strong vertical hopping; grip strength is symmetrical.
               Respiratory: Clear; no distress after high-frequency drumming.
               Stable in jungle/woodland edge habitat.'
       ),
       (
              53,
              'well',
              'Subject: Cockatoo
                  - Appearance: Large, smoky-grey to black plumage; prominent crest.
                  - Bill: Massive, hooked, and black; mandibles do not meet completely.
                  - Face: Bare red cheek patches; skin is vibrant and smooth.
                  - Tongue: Specialized red and black tip for extracting nut meats.
                  - Feet: Zygodactyl; thick, scaly skin with powerful black claws.',
              2,
              'Female Palm Cockatoo. 
               Status: well.
               BCS: 3/5.
               Cheek patches: Normal coloration; rapid flush response to stimuli.
               Dental/Beak: Upper and lower mandibles show healthy keratin layers.
               Plumage: Fine powder-down is present; feathers are well-preened.
               Vocalization: Loud, complex calls; no signs of respiratory clicking.
               Grip: High manual dexterity; uses feet to hold tools/drumsticks.
               Stable in tropical jungle/rainforest habitat.'
       ),
       (
              54,
              'healthy',
              'Subject: Grey
                  - Appearance: Mottled grey plumage; bright red short tail.
                  - Bill: Solid black, hooked, and very powerful.
                  - Face: Bare white skin around the eyes; pale yellow iris.
                  - Feet: Zygodactyl; dark grey with fine, sensitive scales.
                  - Wings: Large and broad; feathers show a fine silver sheen.',
              2,
              'Male African Grey Parrot. 
               Status: healthy.
               BCS: 3/5.
               Neurological: Highly alert; normal vocal mimicry and problem-solving.
               Plumage: Symmetrical feather wear; no signs of feather-plucking (PBFD-free).
               Respiratory: Clear nares (cere); no sneezing or discharge.
               Uropygial gland: Functional, providing essential preening oils.
               Mineral status: Proper calcium/phosphorus balance (critical for Greys).
               Stable in tropical jungle/lowland forest habitat.'
       ),
       (
              55,
              'healthy',
              'Subject: Toucan
                  - Appearance: Black plumage; bright yellow throat and chest.
                  - Bill: Large, multi-colored (green, red, orange, blue); serrated edges.
                  - Feet: Zygodactyl; blue-grey skin; strong grip for hopping.
                  - Eyes: Green skin patch around the eye; dark pupil.
                  - Tail: Long, black with white and red undertail coverts.',
              2,
              'Male Keel-billed Toucan. 
               Status: healthy.
               BCS: 3/5.
               Bill Integrity: Keratin sheath (rhamphotheca) is smooth; no delamination.
               Thermoregulation: Excellent vascular control in bill observed.
               Digestive: Rapid transit time; efficient seed regurgitation.
               Plumage: Waxy sheen on feathers; uropygial gland is functional.
               Oral: Serrated tomia (edges of the bill) are sharp and clean.
               Stable in tropical jungle/canopy habitat.'
       ),
       (
              56,
              'healthy',
              'Subject: Humming
                  - Appearance: Iridescent green and bronze plumage; metallic sheen.
                  - Bill: Long, needle-like, and slightly decurved.
                  - Wings: Narrow and pointed; capable of high-frequency rotation.
                  - Feet: Very small (anisodactyl); used only for perching.
                  - Tongue: Long, bifurcated, and extensible (tubular structure).',
              2,
              'Female Hummingbird. 
               Status: healthy.
               BCS: 2.5/5 (Pectoral muscles must be convex for flight power).
               Metabolic rate: Normal; bird is active and maintaining glucose levels.
               Torpor capability: Functional (used for energy conservation at night).
               Flight: Symmetrical hovering; high-speed wing beat is stable.
               Plumage: Feather barbs are tightly interlocked for aerodynamics.
               Oral: Tongue capillary action is functional for nectar uptake.
               Stable in tropical jungle/flowering understory habitat.'
       ),
       (
              57,
              'healthy',
              'Subject: Anhinga
                  - Appearance: Slender black body; silvery-white wing patches.
                  - Neck: Long, S-shaped, and extremely flexible.
                  - Bill: Sharp, straight, and serrated (spear-like).
                  - Tail: Long and fan-shaped; used for steering underwater.
                  - Feet: Totipalmate (all four toes webbed); dark grey.',
              2,
              'Male African Darter. 
               Status: healthy.
               BCS: 3/5.
               Neck Anatomy: 8th and 9th vertebrae specialized for "spearing" motion.
               Plumage: Healthy wettability (normal for diving); no feather lice.
               Thermoregulation: Sun-basking behavior is regular and efficient.
               Oral: Sharp tomia; no lesions from prey handling.
               Ocular: Nictitating membrane is clear and functional for diving.
               Stable in swamp/freshwater lake habitat.'
       ),
       (
              58,
              'healthy',
              'Subject: Egret
                  - Appearance: Pure white plumage; long, slender silhouette.
                  - Bill: Long, dagger-like, and bright yellow.
                  - Neck: Long "S" curve; can extend rapidly for hunting.
                  - Feet: Anisodactyl; long black legs and toes; no webbing.
                  - Eyes: Yellow iris; sharp binocular vision for depth perception.',
              2,
              'Female Great Egret. 
               Status: healthy.
               BCS: 2.5/5 (Lean, typical for the species).
               Feathering: Nuptial plumes (aigrettes) are in good condition.
               Legs/Feet: Integument is smooth; no pododermatitis or scaling.
               Respiratory: Air sacs are clear; calm respiratory rate.
               Oral: Beak is perfectly straight; tomia are sharp for gripping fish.
               Behavior: High stability while wading; successful foraging observed.
               Stable in swamp/wetland habitat.'
       ),
       (
              59,
              'healthy',
              'Subject: Grey
                  - Appearance: Ash-grey upperparts; white head with black "eyebrows".
                  - Bill: Powerful, spear-shaped; dull yellow to orange.
                  - Neck: Long, white with vertical black streaks on the front.
                  - Feet: Long, dark grey/greenish; anisodactyl arrangement.
                  - Wings: Very broad; slow, rhythmic wing beats in flight.',
              2,
              'Male Grey Heron. 
               Status: healthy.
               BCS: 3/5.
               Plumage: Symmetrical wing feathers; no signs of ectoparasites.
               Grooming: Pectinate claw (middle toe) is sharp and clean.
               Neck mobility: Full range of motion for "strike" hunting.
               Ocular: Clear corneas; excellent focus on submerged prey.
               Respiratory: Deep, rhythmic breathing; no tracheal rales.
               Stable in swamp/shallow water habitat.'
       ),
       (
              60,
              'healthy',
              'Subject: Red
                  - Appearance: Brilliant scarlet plumage; black wing tips.
                  - Bill: Long, thin, and curved downwards; dark grey to black.
                  - Legs: Long and slender; pinkish-red coloration.
                  - Feet: Partially webbed; adapted for walking on soft mud.
                  - Eyes: Small, dark; positioned for lateral peripheral vision.',
              2,
              'Male Scarlet Ibis. 
               Status: healthy.
               BCS: 3/5.
               Plumage: Vivid scarlet (indicates high-quality carotenoid intake).
               Beak: Distal sensory pits are functional for tactile foraging.
               Integument: Leg scaling is smooth; no signs of pododermatitis.
               Digestive: Efficient processing of aquatic invertebrates.
               Respiratory: Clear upper respiratory tract; no rales.
               Stable in swamp/mangrove habitat.'
       ),
       (
              61,
              'well',
              'Subject: Stilt
                  - Appearance: Contrast of black wings/back and pure white underparts.
                  - Legs: Extraordinarily long, thin, and bright pink.
                  - Bill: Long, needle-thin, and straight; black color.
                  - Eyes: Large, red iris; positioned for precise pecking.
                  - Feet: Three toes forward, no hallux (hind toe); partially webbed.',
              2,
              'Female Black-winged Stilt. 
               Status: well.
               BCS: 2.5/5 (Natural slender morphotype).
               Locomotion: Perfect joint extension in long tibiotarsus/tarsometatarsus.
               Plumage: Clean mantle; female-typical brownish-black hue on back.
               Beak: Fine tip integrity is maintained; precise strike reflex.
               Respiratory: Clear; no signs of distress after flight.
               Integument: Leg skin is hydrated; no lesions or "bumblefoot".
               Stable in swamp/salt pan habitat.'
       ),
       (
              62,
              'healthy',
              'Subject: Jabiru
                  - Appearance: Massive white body; featherless black head and neck.
                  - Neck: Distinctive bright red distensible band at the base.
                  - Bill: Enormous, heavy, slightly upturned, and black.
                  - Feet: Large, thick, dark grey legs; anisodactyl.
                  - Wings: Broad and powerful; one of the largest spans in the swamp.',
              2,
              'Male Jabiru Stork. 
               Status: healthy.
               BCS: 3.5/5.
               Gular sac: Red skin is vibrant and highly elastic; no lesions.
               Beak: Robust keratin; high bite force; no signs of necrosis or cracks.
               Locomotion: Steady gait; strong weight-bearing on tarsometatarsus.
               Respiratory: Clear air sacs; powerful, silent respiration.
               Thermoregulation: Gular fluttering behavior is normal.
               Stable in swamp/seasonally flooded savanna habitat.'
       ),
       (
              63,
              'well',
              'Subject: Marabou
                  - Appearance: Slate-grey wings; white underparts; bald, spotted head.
                  - Neck: Long, reddish-pink distensible gular sac.
                  - Bill: Massive, wedge-shaped, and dull yellowish-grey.
                  - Feet: Large, dark; often appear white due to urohidrosis (cooling).
                  - Shoulders: Broad with soft white down feathers at the base of the neck.',
              2,
              'Male Marabou Stork. 
               Status: well.
               BCS: 3/5.
               Gular sac: Elastic and vascularized; used effectively for cooling.
               Skin: Bald head shows healthy pigmentation; no sun-induced lesions.
               Thermoregulation: Urohidrosis behavior is active (cooling via excreta).
               Beak: Robust; no malocclusions; powerful enough for scavenging.
               Respiratory: Clear; no evidence of fungal air sacculitis.
               Stable in swamp/open wetland margins habitat.'
       ),
       (
              64,
              'healthy',
              'Subject: Cormorant
                  - Appearance: Mainly black plumage; long tail; small crest in breeding.
                  - Bill: Yellowish, hooked at the tip for gripping slippery fish.
                  - Eyes: Distinctive red or dark iris; adapted for underwater vision.
                  - Feet: Totipalmate (all four toes webbed); positioned posteriorly.
                  - Tail: Long and stiff; used as a rudder and for balance on land.',
              2,
              'Male Long-tailed Cormorant. 
               Status: healthy.
               BCS: 3/5.
               Plumage: Normal wettability; wing-drying behavior is frequent.
               Uropygial gland: Low secretion (typical for diving efficiency).
               Ocular: Nictitating membrane (third eyelid) is clear and reactive.
               Locomotion: Powerful swimming; waddling gait on land is normal.
               Respiratory: Clear; high tolerance for apnea during dives.
               Stable in swamp/freshwater river habitat.'
       ),
       (
              65,
              'healthy',
              'Subject: Great
                  - Appearance: Large, soot-black plumage; yellow throat patch.
                  - Bill: Strong, hooked; dark grey with a prominent nail at the tip.
                  - Wings: Broad and powerful for low-altitude flight over water.
                  - Feet: Large, totipalmate; dark grey with thick, scaly skin.
                  - Eyes: Emerald green iris; adapted for low-light underwater hunting.',
              2,
              'Male Great Cormorant. 
               Status: healthy.
               BCS: 3.5/5.
               Gular skin: Pliable and healthy; shows typical yellow/white breeding color.
               Plumage: Structured to allow water penetration for reduced buoyancy.
               Ocular: High visual acuity; emerald iris reflex is normal.
               Skeletal: Robust coracoid and furcula for powerful diving strokes.
               Metabolism: Efficient thermogenesis observed after cold water dives.
               Stable in swamp/estuary/coastal habitat.'
       ),
       (
              66,
              'healthy',
              'Subject: Lesser
                  - Appearance: Deep pink to red plumage; dark crimson flight feathers.
                  - Bill: Deeply angular; dark maroon with black tip; specialized lamellae.
                  - Legs: Long, thin, and pink; feet are webbed (palmate).
                  - Neck: Long and flexible; 19 cervical vertebrae.
                  - Eyes: Small, yellow to orange iris; lateral placement.',
              2,
              'Female Lesser Flamingo. 
               Status: healthy.
               BCS: 2.5/5.
               Plumage: Vibrant pink (reflects optimal spirulina-based diet).
               Beak: Fine filter lamellae are clean and unobstructed.
               Locomotion: Steady on mudflats; normal "marching" social behavior.
               Salt Glands: Supraorbital glands are active (excreting excess salt).
               Integument: Foot pads are soft but resilient to alkaline waters.
               Stable in swamp/alkaline lake habitat.'
       ),
       (
              67,
              'healthy',
              'Subject: Greater
                  - Appearance: Pale pinkish-white body; coral-red wing coverts.
                  - Bill: Large, pink with a prominent black tip; "broken-back" shape.
                  - Legs: Extremely long, pink; knees (intertarsal joints) are dark pink.
                  - Neck: Long, slender, and highly mobile; often held in an S-shape.
                  - Feet: Webbed (palmate); adapted for treading on soft sediment.',
              2,
              'Female Greater Flamingo. 
               Status: healthy.
               BCS: 3/5.
               Plumage: Symmetrical primary feathers; axillary feathers show bright coral.
               Feeding Mechanism: Tongue-pumping action is strong and rhythmic.
               Joint Health: No swelling in the intertarsal joints; full range of motion.
               Ocular: Clear yellow iris; no signs of avian conjunctivitis.
               Respiratory: Clear; high-altitude flight capacity is maintained.
               Stable in swamp/lagoon/estuary habitat.'
       ),
       (
              68,
              'healthy',
              'Subject: Rose
                  - Appearance: Bright pink body; white neck and upper back; bald greenish head.
                  - Bill: Long, flat, and spatulate (spoon-shaped); grey to yellowish.
                  - Legs: Long, slender, and deep pink; semi-palmate feet.
                  - Eyes: Intense red iris; lateral placement.
                  - Wings: Large, pink with darker carmine patches on the shoulders.',
              2,
              'Female Roseate Spoonbill. 
               Status: healthy.
               BCS: 3/5.
               Bill Integrity: Sensory pits on the spatulate tip are highly responsive.
               Plumage: Vibrant pink sheen; no signs of stress-induced molting.
               Integument: Head skin is smooth; no signs of solar dermatitis.
               Foraging Behavior: Lateral "sweeping" motion is vigorous and coordinated.
               Respiratory: Clear; no signs of aspergillosis in air sacs.
               Stable in swamp/mangrove/marsh habitat.'
       ),
       (
              69,
              'healthy',
              'Subject: Eurasia
                  - Appearance: Pure white plumage; long yellowish-black crest during breeding.
                  - Bill: Long, flat, and spoon-shaped; black with a yellow tip.
                  - Legs: Long, black; adapted for wading in soft mud.
                  - Eyes: Dark red to brown iris; excellent peripheral vision.
                  - Throat: Bare yellowish skin patch at the base of the bill.',
              2,
              'Male Eurasian Spoonbill. 
               Status: healthy.
               BCS: 3/5.
               Bill: Rhamphotheca is smooth; yellow tip is prominent and healthy.
               Plumage: Symmetrical flight feathers; no signs of feather mites.
               Vocal/Behavior: Bill-clattering behavior is normal for social interaction.
               Neck: Cervical flexibility allows for wide-angle foraging sweeps.
               Integument: Leg skin is intact; no signs of parasitic pododermatitis.
               Stable in swamp/estuary/reed bed habitat.'
       ),
       (
              70,
              'healthy',
              'Subject: Water
                  - Appearance: Cryptic brown and grey plumage; fine dark streaks.
                  - Eyes: Large, prominent yellow iris; adapted for night vision.
                  - Bill: Short, stout, and black with a yellow base.
                  - Legs: Thick, greenish-yellow "knees" (intertarsal joints).
                  - Wings: Narrow; shows a white bar during flight.',
              2,
              'Male Water Thick-knee. 
               Status: healthy.
               BCS: 3/5.
               Ocular: High pupillary light reflex; clear corneas.
               Plumage: Excellent cryptic pattern for pebble/sand mimicry.
               Locomotion: Strong runner; "bobbing" behavior is normal.
               Auditory: Highly sensitive to low-frequency vibrations.
               Integrity: No lesions on the tarsal pads from rocky substrate.
               Stable in Savannah/riverine fringe habitat.'
       ),
       (
              71,
              'healthy',
              'Subject: Abyssinian
                  - Appearance: Brilliant turquoise body; tan/fawn back; dark blue wings.
                  - Tail: Two long, slender black streamers (outer rectrices).
                  - Bill: Strong, black, slightly hooked at the tip.
                  - Feet: Syndactyl (inner and middle toes partially joined).
                  - Eyes: Large, dark; keen eyesight for spotting terrestrial prey.',
              2,
              'Female Abyssinian Roller. 
               Status: healthy.
               BCS: 2.5/5.
               Plumage: Iridescent blue structural coloration is vivid.
               Tail Filaments: Intact and symmetrical; no signs of breakage.
               Beak: Sharp tomia for crushing insect exoskeletons.
               Flight: High maneuverability; pectoral muscles well-developed.
               Neurological: Rapid head-tilt reflex (typical for sit-and-wait predators).
               Stable in Savannah/dry woodland habitat.'
       ),
       (
              72,
              'healthy',
              'Subject: Vulture
                  - Appearance: Sandy-brown body; dark flight feathers; pale ruff.
                  - Head/Neck: Bald with white down; adapted for hygiene.
                  - Bill: Massive, hooked, and pale yellow/grey; high shearing force.
                  - Feet: Large but relatively weak grip (compared to eagles); black.
                  - Wings: Immense envergure (span); "fingered" primary feathers.',
              2,
              'Male Griffon Vulture. 
               Status: healthy.
               BCS: 3/5.
               Digestive: High gastric acidity (pH ~1) confirmed; no toxin buildup.
               Neck: Skin is clear; no signs of necrotic debris or parasites.
               Flight: Excellent use of thermals; primary feathers show normal wear.
               Respiratory: Massive lung capacity and clear air sacs for high-altitude soaring.
               Beak: Keratin sheath is hard; normal occlusion for tearing tissue.
               Stable in Savannah/mountain cliff habitat.'
       ),
       (
              73,
              'healthy',
              'Subject: Weaver
                  - Appearance: Bright yellow body; black face mask and throat.
                  - Bill: Strong, conical, and black; adapted for seed-cracking and weaving.
                  - Eyes: Distinctive red iris; highly alert.
                  - Feet: Pinkish-brown; strong hallux for gripping thin branches.
                  - Wings: Short and rounded; efficient for quick, undulating flight.',
              2,
              'Male Southern Masked Weaver. 
               Status: healthy.
               BCS: 2.5/5.
               Plumage: Vibrant breeding colors; no signs of depigmentation.
               Beak: High dexterity; no fractures in the rhamphotheca.
               Motor Skills: Excellent fine motor coordination for nest construction.
               Respiratory: Clear; no evidence of tracheal mites (Sternostoma tracheacolum).
               Ocular: Red iris is clear; rapid pupillary response.
               Stable in Savannah/thornveld habitat.'
       ),
       (
              74,
              'healthy',
              'Subject: Martial
                  - Appearance: Dark brown upperparts; white underparts with dark spots.
                  - Head: Slight crest on the nape; powerful, broad head.
                  - Bill: Massive, hooked, black; base (cere) is bluish-grey.
                  - Feet: Huge, pale yellow; equipped with exceptionally long, black talons.
                  - Wings: Long and broad; dark underwing coverts.',
              2,
              'Female Martial Eagle. 
               Status: healthy.
               BCS: 3.5/5.
               Musculoskeletal: Pectoral muscles are firm; wings show powerful extension.
               Talons: Hallux talon is sharp and structurally sound; no fissures.
               Ocular: Deep-set yellow eyes; 1.0 visual acuity (estimated).
               Crop: Normal motility; no signs of impaction or sour crop.
               Respiratory: Massive air sac capacity; clear, silent breathing.
               Stable in Savannah/open woodland habitat.'
       ),
       (
              75,
              'healthy',
              'Subject: Bill
                  - Appearance: Cryptic grey-brown plumage with fine barring.
                  - Head: Bright yellow bare skin around the eyes.
                  - Bill: Strong, slightly curved, and bright red.
                  - Feet: Reddish-pink legs; males possess sharp tarsal spurs.
                  - Body: Rounded, terrestrial build; short wings and tail.',
              2,
              'Male Red-billed Spurfowl. 
               Status: healthy.
               BCS: 3/5.
               Integument: Orbital skin is vibrant and free of pox lesions.
               Tarsal Spurs: Calcified and sharp; used effectively for defense.
               Digestive: Gizzard is functional; efficient processing of seeds and bulbs.
               Locomotion: Strong pelvic limb musculature; no lameness.
               Respiratory: Clear; typical loud vocalizations indicate good lung capacity.
               Stable in Savannah/riverine thicket habitat.'
       ),
       (
              76,
              'healthy',
              'Subject: Secretary
                  - Appearance: Grey body; black thighs and flight feathers; crest of black plumes.
                  - Head: Bare orange/red facial skin; eagle-like hooked bill.
                  - Legs: Extraordinarily long, scaled; pinkish-grey; short toes for terrestrial grip.
                  - Tail: Long with two central streamers.
                  - Wings: Large and broad; used for soaring and stabilization during hunts.',
              2,
              'Male Secretarybird. 
               Status: healthy.
               BCS: 3/5.
               Predatory Mechanics: Kick force is rapid and powerful; tarsal scales are intact.
               Plumage: Nuchal crest plumes are full and symmetrical.
               Ocular: Large eyes with long eyelashes (modified feathers); clear corneas.
               Integument: Facial skin is vibrant; no signs of avian pox or lesions.
               Respiratory: Clear; efficient gas exchange for long-distance walking.
               Stable in Savannah/open grassland habitat.'
       ),
       (
              77,
              'healthy',
              'Subject: Ostrich
                  - Appearance: Massive black body plumage; white wing and tail plumes.
                  - Neck/Legs: Bare skin, pinkish-red (breeding male); extremely long.
                  - Feet: Didactyl (only 2 toes); large inner toe with a hoof-like claw.
                  - Eyes: Largest eyes of any land vertebrate; thick black lashes.
                  - Bill: Flat and broad; adapted for opportunistic grazing.',
              2,
              'Male Common Ostrich. 
               Status: healthy.
               BCS: 3.5/5.
               Locomotion: Powerful stride; no signs of slipped tendon or splay leg.
               Podotheca: Thick plantar pads; main claw shows healthy wear.
               Thermoregulation: Wing-fanning behavior is effective; air sacs clear.
               Ocular: Corneas clear; no signs of grit-induced irritation.
               Digestive: Proventriculus and gizzard functioning; stones present for grinding.
               Stable in Savannah/semi-arid plains habitat.'
       ),
       (
              78,
              'healthy',
              'Subject: Crown
                  - Appearance: Grey-brown upperparts; white underparts and crown.
                  - Head: Long, drooping bright yellow facial wattles.
                  - Wings: Large white patches visible in flight; black wing tips.
                  - Bill: Yellow base with a black tip; straight and pointed.
                  - Feet: Long, greenish-yellow; three toes forward.',
              2,
              'Female White-headed Lapwing. 
               Status: healthy.
               BCS: 2.5/5.
               Wattles: Turgid and vibrant yellow; no signs of parasitic cysts.
               Wing Spurs: Carpal spurs are sharp and well-developed for defense.
               Nervous System: Highly alert; normal "bobbing" and alarm displays.
               Plumage: Clean and waterproofed; uropygial gland is active.
               Respiratory: Clear; no evidence of syngamiasis (gapeworm).
               Stable in Savannah/riverine sandbar habitat.'
       ),
       (
              79,
              'healthy',
              'Subject: Blacksmith
                  - Appearance: Bold pattern of black, grey, and white; white crown.
                  - Wings: Equipped with sharp black carpal spurs on the wrists.
                  - Bill: Short, straight, and black; ideal for surface picking.
                  - Eyes: Deep red iris; provides excellent contrast in bright light.
                  - Legs: Long, thin, and black; adapted for wading in shallow mud.',
              2,
              'Male Blacksmith Lapwing. 
               Status: healthy.
               BCS: 2.5/5.
               Wing Spurs: Sharp and prominent; no signs of periosteal reaction.
               Ocular: Vibrant red iris; no signs of uveitis or corneal opacity.
               Plumage: High contrast maintained; no feathers show signs of depigmentation.
               Behavior: Highly vocal; "tink-tink-tink" alarm call is loud and clear.
               Locomotion: Agile on mudflats; symmetrical gait.
               Stable in Savannah/wetland margin habitat.'
       ),
       (
              80,
              'healthy',
              'Subject: Spine
                  - Appearance: Dark grey to blackish shell; depressed central groove.
                  - Neck: Long, covered with prominent pointed tubercles (spines).
                  - Shell: Oval-shaped carapax; relatively flat for hydrodynamic efficiency.
                  - Limbs: Strong, webbed feet with sharp claws for digging in mud.
                  - Head: Wide and flat with a slightly hooked upper jaw.',
              2,
              'Female Black Spine-necked Swamp Turtle. 
               Status: healthy.
               BCS: 3/5.
               Carapace Integrity: Scutes are firm; no signs of shell rot or pitting.
               Neck Tubercles: Pointed and intact; no fungal growth in interstitial skin.
               Hydration: Ocular membranes are moist; skin elasticity is normal.
               Cloacal Health: Clean; no signs of prolapse or parasitic discharge.
               Activity: Cryptic but responsive to tactile stimuli.
               Stable in swamp/shallow pond habitat.'
       ),
       (
              81,
              'healthy',
              'Subject: Alli
                  - Appearance: Large, robust body; dark grey to black coloration.
                  - Snout: Broad, U-shaped; upper jaw overlaps lower teeth.
                  - Osteoderms: Bony plates embedded in the skin of the back for protection.
                  - Tail: Massive and laterally compressed for aquatic propulsion.
                  - Eyes: Vertically slit pupils; reflective tapetum lucidum for night vision.',
              2,
              'Male American Alligator. 
               Status: healthy.
               BCS: 4/5.
               Dentition: Full set of teeth (approx. 74-80); no signs of gingival infection.
               Dermal Scutes: Osteoderms are hard and well-vascularized.
               Thermoregulation: Gaping behavior observed (normal heat exchange).
               Ocular: Nictitating membrane is functional and clear.
               Cloacal: Strong muscle tone; clear of obstructions.
               Stable in swamp/freshwater marsh habitat.'
       ),
       (
              82,
              'healthy',
              'Subject: Yacare
                  - Appearance: Dark olive to black; cross-banding on sides and tail.
                  - Snout: Medium-width; visible lower teeth when jaws are closed.
                  - Eyes: Prominent bony ridge between the orbits (spectacle-like).
                  - Belly: Highly ossified ventral scales (bony plates).
                  - Tail: Serrated dorsal crest; extremely muscular.',
              2,
              'Male Yacare Caiman. 
               Status: healthy.
               BCS: 3.5/5.
               Dentition: Characteristic "overbite" absent; teeth are clean and sharp.
               Ventral Scales: Extensive osteoderm development (typical for the genus).
               Nasal: Valves are responsive and airtight during submersion.
               Integument: Typical dark pigmentation; no signs of "red leg" (septisemia).
               Reflexes: Strong tail-thrash response and rapid jaw snap.
               Stable in swamp/riverine habitat.'
       ),
       (
              83,
              'healthy',
              'Subject: Nile
                  - Appearance: Bronze to greyish-green; dark cross-bands on the tail.
                  - Snout: Long and tapered; 4th lower tooth visible when jaws closed.
                  - Body: Massive, armored with heavy osteoderms on the dorsal side.
                  - Feet: Strongly webbed hind feet; five toes on front, four on back.
                  - Senses: Sensory pits (ISOs) located on almost every scale of the body.',
              2,
              'Male Nile Crocodile. 
               Status: healthy.
               BCS: 4/5.
               Oral: Tongue is fixed to the floor of the mouth; no signs of stomatitis.
               Dentition: Massive pressure capacity; teeth show regular replacement cycles.
               Integument: ISOs (Integumentary Sense Organs) are sensitive and healthy.
               Cardiovascular: Strong heart rate; Foramen of Panizza function is presumed normal.
               Locomotion: Powerful "high walk" and aquatic propulsion.
               Stable in swamp/river/lake habitat.'
       ),
       (
              84,
              'healthy',
              'Subject: Gharial
                  - Appearance: Olive-green to light brown; long, slender body.
                  - Snout: Extremely elongated and narrow; needle-like teeth.
                  - Head: Distinctive "ghara" (bulbous growth) on the narial boss.
                  - Feet: Extensively webbed; weak terrestrial locomotion (slides on belly).
                  - Tail: Well-developed vertically flattened tail for rapid swimming.',
              2,
              'Male Indian Gharial. 
               Status: healthy.
               BCS: 3/5.
               Narials: Ghara structure is intact; resonates correctly for vocalization.
               Dentition: Numerous interlocking teeth (approx. 110); no malocclusions.
               Ocular: Eyes sit high on the skull; clear vision above water line.
               Musculoskeletal: Specialized for aquatic life; leg muscles are lean.
               Integument: Scales are smooth; minimal algae attachment.
               Stable in river/deep swamp habitat.'
       ),
       (
              85,
              'healthy',
              'Subject: Black
                  - Appearance: Very dark, near-black skin; grey-brown banding on lower jaw.
                  - Eyes: Large, prominent with a silver/grey iris.
                  - Snout: Broad and heavy; structurally stronger than other caimans.
                  - Size: Robust and massive body; can exceed 5 meters in length.
                  - Osteoderms: Heavily armored dorsal surface with dark, ridged scales.',
              2,
              'Male Black Caiman. 
               Status: healthy.
               BCS: 4/5.
               Integument: Dark pigmentation is uniform; no signs of depigmentation or fungi.
               Cranial: Massive jaw adductor muscles; temporal fenestrae are clear.
               Metabolism: Efficient post-prandial thermoregulation observed.
               Ocular: Tapetum lucidum providing strong nocturnal eye-shine.
               Nervous System: High response to chemical cues in water.
               Stable in Amazonian swamp/flooded forest habitat.'
       ),
       (
              86,
              'healthy',
              'Subject: Agama
                  - Appearance: Bright orange head; indigo/blue body; bicolored tail.
                  - Body: Sub-cylindrical; covered in small, keeled scales.
                  - Head: Large, triangular; distinct tympanum (ear opening).
                  - Feet: Long toes with sharp claws for climbing rocks and trees.
                  - Tail: Long, non-autotomous (typically does not drop easily).',
              2,
              'Male Common Agama. 
               Status: healthy.
               BCS: 2.5/5.
               Coloration: High-intensity breeding colors; indicates dominance and health.
               Digital: All claws intact; excellent grip and climbing mobility.
               Oral: Mucosa is pink; acrodont dentition is stable and clean.
               Tympanum: Clear and free of mite clusters or debris.
               Hydration: Lateral skin folds are minimal; eyes are bright and protuberant.
               Stable in Savannah/kopje/suburban habitat.'
       ),
       (
              87,
              'healthy',
              'Subject: Giant
                  - Appearance: Massive domed carapace; thick, pillar-like legs.
                  - Neck: Long, allowing reach to higher vegetation.
                  - Head: Relatively small; scaly; no external ears.
                  - Feet: Cylindrical (elephantine) with blunt nails for heavy support.
                  - Shell: High-domed, brownish-grey; growth rings visible on scutes.',
              2,
              'Male Aldabra Giant Tortoise. 
               Status: healthy.
               BCS: 3.5/5.
               Carapace: No signs of "pyramiding" or metabolic bone disease.
               Locomotion: Slow but steady; gait is symmetrical and strong.
               Beak: Keratinized rhamphotheca is sharp for shearing fibrous plants.
               Hydration: Normal; access to mud wallows has kept skin supple.
               Fecal: High fiber content; normal digestion of lignified grasses.
               Stable in Savannah/grassland habitat.'
       ),
       (
              88,
              'healthy',
              'Subject: Chameleon
                  - Appearance: Usually green with pale lateral stripes; tall cranial casque.
                  - Eyes: Conical turrets; 360-degree independent rotation.
                  - Feet: Zygodactylous (toes fused into two opposing pads).
                  - Tail: Strongly prehensile; coiled when at rest.
                  - Tongue: Extremely long, projectile; equipped with a suction tip.',
              2,
              'Male African Chameleon. 
               Status: healthy.
               BCS: 2.5/5.
               Ocular: Rapid independent tracking; no signs of sunken orbits (dehydration).
               Casque: Well-defined cranial crest; no signs of metabolic softening.
               Grip: Strong zygodactylous grasp; no tremors or limb weakness.
               Integument: Efficient color change; skin sheds in clean patches.
               Oral: Hyoid apparatus functional; tongue projection is swift and accurate.
               Stable in Savannah/shrubland habitat.'
       ),
       (
              89,
              'healthy',
              'Subject: Gopherus
                  - Appearance: Rugose, dark brown carapace; yellowish plastron.
                  - Forelimbs: Broad, spade-like, and heavily scaled for burrowing.
                  - Head: Square-shaped profile; thick scales on the forehead.
                  - Size: Medium-sized tortoise; high-domed shell.
                  - Throat: Gular scutes (front of the bottom shell) are prominent.',
              2,
              'Female Goode’s Thornscrub Tortoise. 
               Status: healthy.
               BCS: 3/5.
               Forelimbs: Fossorial adaptations are intact; nails are thick and blunt.
               Plastron: Firm; no signs of shell pitting or erosive lesions.
               Nasal: Nares are dry and clear; no discharge (rinitis check).
               Hydration: Mental glands are active; eyes are clear and alert.
               Behavior: Efficient burrowing reflex; responsive to environmental changes.
               Stable in Savannah/thornscrub habitat.'
       ),
       (
              90,
              'healthy',
              'Subject: Gecko
                  - Appearance: Pale, translucent skin with dark spots/tubercles.
                  - Eyes: Large, vertical pupils; fixed transparent spectacle (no eyelids).
                  - Feet: Expanded toe pads with specialized subdigital lamellae.
                  - Tail: Cylindrical, fragile (can autotomize); often shows regeneration rings.
                  - Body: Flattened dorsoventrally; skin feels soft and granular.',
              2,
              'Female Mediterranean House Gecko. 
               Status: healthy.
               BCS: 2.5/5.
               Digital Pads: Setae are clean and functional; full adhesive capability.
               Ocular: Spectacle is clear; no retained shed (dysecdysis) over the eyes.
               Tail: Original tail intact; fat reserves in the caudal base are adequate.
               Integument: Tubercles are prominent; no signs of mite infestation.
               Activity: Strong righting reflex; active nocturnal hunting behavior.
               Stable in Savannah/rocky/urban habitat.'
       ),
       (
              91,
              'healthy',
              'Subject: Eyes
                  - Appearance: Neon green dorsum; bright orange feet; blue/yellow flanks.
                  - Eyes: Large, bulging, brilliant red with vertical slit pupils.
                  - Feet: Suction-cup toe pads for climbing; lack of extensive webbing.
                  - Skin: Smooth, permeable, and moist; secretes protective peptides.
                  - Eyelids: Reticulated lower eyelid (nictitating membrane) with gold pattern.',
              2,
              'Female Red-eyed Tree Frog. 
               Status: healthy.
               BCS: 3/5.
               Integument: Skin is moist and vibrant; no signs of chytrid fungus or lesions.
               Ocular: Red iridophores are vivid; nictitating membrane functions perfectly.
               Digital Pads: Adhesive discs are turgid; provides strong vertical grip.
               Coelomic: Normal palpation; no evidence of impaction or internal masses.
               Respiration: Gular pumping is steady; cutaneous respiration appears optimal.
               Stable in Jungle/high-humidity arboreal habitat.'
       ),
       (
              92,
              'healthy',
              'Subject: Blue
                  - Appearance: Brilliant azure blue with irregular black spotting.
                  - Body: Stout and robust; limbs are darker blue.
                  - Feet: Suction-like toe pads; lack of webbing (terrestrial).
                  - Skin: Extremely smooth and moist; contains poison glands.
                  - Head: Small with large, dark, lateral eyes.',
              2,
              'Male Blue Poison Dart Frog. 
               Status: healthy.
               BCS: 3/5.
               Integument: Mucous layer is intact; no signs of Batrachochytrium dendrobatidis.
               Coloration: High saturation; indicates optimal nutritional status.
               Digital Pads: Broad and functional; normal "sticky" response on leaves.
               Gular: Rhythmic gular fluttering (normal respiratory rate).
               Musculoskeletal: Forelimbs are strong; no signs of "spindly leg" syndrome.
               Stable in Jungle/leaf litter habitat.'
       ),
       (
              93,
              'healthy',
              'Subject: Crystal
                  - Appearance: Lime green dorsum with faint yellow spots; transparent belly.
                  - Internal: Visceral organs (heart, liver, intestines) visible through skin.
                  - Eyes: Large, golden-white iris with horizontal pupils; forward-facing.
                  - Body: Small, delicate, and flattened; adapted for leaf-dwelling.
                  - Feet: Tips expanded into discs; yellow-green coloration.',
              2,
              'Female Fleischmann’s Glass Frog. 
               Status: healthy.
               BCS: 2.5/5.
               Transparency: Ventral skin is clear; no signs of internal hemorrhage or edema.
               Cardiac: Heart rate is regular and visible; normal contraction cycle.
               Digestive: Liver is dark red (normal); intestinal motility is active.
               Ocular: Eyes are turgid; no signs of corneal clouding.
               Reproductive: Gravid state check: Oocytes visible through the abdominal wall.
               Stable in Jungle/riverine vegetation habitat.'
       ),
       (
              94,
              'healthy',
              'Subject: Golden
                  - Appearance: Solid bright yellow; robust and large for a dendrobatid.
                  - Skin: Extremely smooth; contains high concentrations of batrachotoxin.
                  - Mouth: Possesses teeth (maxillary), unlike most other poison frogs.
                  - Feet: Large toe pads; non-webbed; designed for terrestrial foraging.
                  - Eyes: Large and completely black; providing sharp contrast to the body.',
              2,
              'Male Golden Poison Frog. 
               Status: healthy.
               BCS: 3.5/5.
               Integument: Lustrous yellow sheen; no signs of skin peeling or discoloration.
               Oral: Maxillary teeth are present and stable; oral mucosa is healthy.
               Toxicity Check: Glandular activity is normal (dietary sourced in wild).
               Motor Skills: High activity levels; strong jumping and climbing response.
               Respiratory: Steady gular respiration; no audible distress.
               Stable in Jungle/humid leaf litter habitat.'
       ),
       (
              95,
              'healthy',
              'Subject: Bicolor
                  - Appearance: Bright leaf-green dorsum; creamy white or yellowish belly.
                  - Eyes: Large, silver-grey iris with vertical pupils.
                  - Limbs: Long and slender; possesses opposable first toes on all feet.
                  - Glands: Large parotoid glands extending behind the eyes.
                  - Skin: Waxy texture; secretes dermorphins and deltorphins.',
              2,
              'Female Giant Monkey Frog. 
               Status: healthy.
               BCS: 4/5.
               Integument: Waxy coating is uniform; no signs of skin desiccation.
               Parotoid Glands: Symmetrical and productive; no signs of impaction.
               Grip: Strong opposable grasp; coordination is excellent during arboreal movement.
               Hydration: Normal; stores water in the bladder efficiently.
               Ocular: Clear silver iris; normal pupillary light reflex.
               Stable in Jungle/canopy habitat.'
       );

-- ============================================================
-- SEED DATA FOR ANIMAL_CLICKS (Statistics)
-- ============================================================
-- Simulated click statistics for animals
-- ============================================================

-- INSERT INTO animal_clicks (animal_g_id, year, month, click_count)
-- VALUES
--        -- December 2025 (Current month)
--        (31, 2025, 12, 3),  -- King: 3 clicks
--        (1, 2025, 12, 2),   -- Bamboo: 2 clicks
       
--        -- January 2025 (Historical data - 10 animals with various clicks)
--        (1, 2025, 1, 7),    -- Bamboo: 7 clicks
--        (2, 2025, 1, 3),    -- Rufus: 3 clicks
--        (3, 2025, 1, 4),    -- Fuzzy: 4 clicks
--        (4, 2025, 1, 7),    -- Nyx: 7 clicks
--        (5, 2025, 1, 3),    -- Spider: 3 clicks
--        (6, 2025, 1, 4),    -- Sloth: 4 clicks
--        (7, 2025, 1, 7),    -- Surya: 7 clicks
--        (8, 2025, 1, 3),    -- Sunny: 3 clicks
--        (9, 2025, 1, 4),    -- Spots: 4 clicks
--        (10, 2025, 1, 7);   -- Tail: 7 clicks

