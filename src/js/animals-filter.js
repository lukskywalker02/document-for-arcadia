document.addEventListener("DOMContentLoaded", function() {
    let currentPage = 1;
    let itemsPerPage = 10;

    // Function to get URL parameters
    function getURLParams() {
        const params = new URLSearchParams(window.location.search);
        return {
            specie: params.get('specie') || '',
            habitat: params.get('habitat') || '',
            nutrition: params.get('nutrition') || '',
            state: params.get('state') || '',
            name: params.get('name') || '',
            perPage: params.get('perPage') || '10',
            page: params.get('page') || '1'
        };
    }

    // Function to update URL with current filter values
    function updateURL() {
        const params = new URLSearchParams();
        const specie = $('#filter-specie').val();
        const habitat = $('#filter-habitat').val();
        const nutrition = $('#filter-nutrition').val();
        const state = $('#filter-state').val();
        const name = $('#filter-name').val();
        const perPage = $('#filter-per-page').val();
        
        if (specie) params.set('specie', specie);
        if (habitat) params.set('habitat', habitat);
        if (nutrition) params.set('nutrition', nutrition);
        if (state) params.set('state', state);
        if (name) params.set('name', name);
        if (perPage && perPage !== '10') params.set('perPage', perPage);
        if (currentPage > 1) params.set('page', currentPage);
        
        // Update URL without reloading the page
        const newURL = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newURL);
    }

    // Function to restore filters from URL
    function restoreFiltersFromURL() {
        const urlParams = getURLParams();
        
        if (urlParams.specie) $('#filter-specie').val(urlParams.specie);
        if (urlParams.habitat) $('#filter-habitat').val(urlParams.habitat);
        if (urlParams.nutrition) $('#filter-nutrition').val(urlParams.nutrition);
        if (urlParams.state) $('#filter-state').val(urlParams.state);
        if (urlParams.name) $('#filter-name').val(urlParams.name);
        if (urlParams.perPage) $('#filter-per-page').val(urlParams.perPage);
        if (urlParams.page) currentPage = parseInt(urlParams.page) || 1;
        if (urlParams.perPage) itemsPerPage = parseInt(urlParams.perPage) || 10;
    }

    function applyFilters() {
        const specie = $('#filter-specie').val().toLowerCase();
        const habitat = $('#filter-habitat').val().toLowerCase();
        const nutrition = $('#filter-nutrition').val().toLowerCase();
        const state = $('#filter-state').val().toLowerCase();
        const name = $('#filter-name').val().toLowerCase();

        const visibleAnimals = [];

        $('.intro__animal').each(function() {
            const $article = $(this);
            const articleSpecie = $article.data('specie') || '';
            const articleHabitat = $article.data('habitat') || '';
            const articleNutrition = $article.data('nutrition') || '';
            const articleState = $article.data('state') || '';
            const articleName = $article.data('name') || '';

            let show = true;

            // Filter by specie (extract value from parentheses and compare)
            if (specie) {
                const specieMatch = articleSpecie.match(/\(([^)]+)\)/);
                const articleSpecieType = specieMatch ? specieMatch[1].toLowerCase().trim() : '';
                if (articleSpecieType !== specie.toLowerCase()) {
                    show = false;
                }
            }

            // Filter by habitat
            if (show && habitat && articleHabitat.toLowerCase().indexOf(habitat) === -1) {
                show = false;
            }

            // Filter by nutrition
            if (show && nutrition && articleNutrition.indexOf(nutrition) === -1) {
                show = false;
            }

            // Filter by state (exact match)
            if (show && state && articleState.toLowerCase() !== state.toLowerCase()) {
                show = false;
            }

            // Filter by name
            if (show && name && articleName.indexOf(name) === -1) {
                show = false;
            }

            // Store visible animals
            if (show) {
                visibleAnimals.push($article);
            }
            
            // Hide all first
            $article.hide();
        });

        // Apply pagination to visible animals
        currentPage = 1; // Reset to first page when filtering
        showPage(visibleAnimals);
        
        // Update URL with current filters
        updateURL();
        
        return visibleAnimals;
    }

    function showPage(visibleAnimals) {
        itemsPerPage = parseInt($('#filter-per-page').val()) || 10;
        const totalPages = Math.ceil(visibleAnimals.length / itemsPerPage);
        
        // Hide all animals
        $('.intro__animal').hide();
        
        // Show animals for current page
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        
        for (let i = start; i < end && i < visibleAnimals.length; i++) {
            visibleAnimals[i].show();
        }
        
        // Update pagination
        updatePagination(totalPages, visibleAnimals.length);
    }

    function updatePagination(totalPages, totalItems) {
        const $paginationNav = $('#paginationNav');
        const $paginationNumbers = $('#paginationNumbers');
        
        if (totalPages <= 1) {
            $paginationNav.hide();
            return;
        }
        
        $paginationNav.show();
        const $paginationUl = $paginationNav.find('.nav-pagination__ul');
        
        // Remove existing page numbers (keep prev and next buttons)
        $paginationUl.find('li:not(:first-child):not(:last-child)').remove();
        
        // Generate dynamic page numbers: show current page ± 1, plus first and last if needed
        const startPage = Math.max(1, currentPage - 1);
        const endPage = Math.min(totalPages, currentPage + 1);
        
        // Build page numbers array
        const pageNumbers = [];
        
        // Always show first page if not in range
        if (startPage > 1) {
            pageNumbers.push({type: 'number', value: 1, separator: ','});
            if (startPage > 2) {
                pageNumbers.push({type: 'ellipsis'});
            }
        }
        
        // Show pages around current page
        for (let i = startPage; i <= endPage; i++) {
            const separator = (i < endPage || (endPage < totalPages)) ? ',' : '';
            pageNumbers.push({type: 'number', value: i, separator: separator, isActive: i === currentPage});
        }
        
        // Show last page if not in range
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                pageNumbers.push({type: 'ellipsis'});
            }
            pageNumbers.push({type: 'number', value: totalPages, separator: ''});
        }
        
        // Insert page numbers after prev button
        let $prevButton = $paginationUl.find('#paginationPrev').parent();
        pageNumbers.forEach(function(page) {
            if (page.type === 'ellipsis') {
                $prevButton.after('<li class="nav-pagination__li"><span>...</span></li>');
            } else {
                const activeStyle = page.isActive ? ' style="color: #2ED6FF; font-weight: bold;"' : '';
                $prevButton.after('<li class="nav-pagination__li"><a href="#" data-page="' + page.value + '"' + activeStyle + '>' + page.value + page.separator + '</a></li>');
            }
            $prevButton = $prevButton.next();
        });
        
        // Previous button
        $('#paginationPrev').off('click').on('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                const visibleAnimals = getVisibleAnimals();
                showPage(visibleAnimals);
                updateURL(); // Update URL when page changes
            }
        });
        
        // Next button
        $('#paginationNext').off('click').on('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                const visibleAnimals = getVisibleAnimals();
                showPage(visibleAnimals);
                updateURL(); // Update URL when page changes
            }
        });
        
        // Page number clicks
        $paginationUl.find('a[data-page]').off('click').on('click', function(e) {
            e.preventDefault();
            currentPage = parseInt($(this).data('page'));
            const visibleAnimals = getVisibleAnimals();
            showPage(visibleAnimals);
            updateURL(); // Update URL when page changes
        });
    }

    function getVisibleAnimals() {
        const visibleAnimals = [];
        const specie = $('#filter-specie').val().toLowerCase();
        const habitat = $('#filter-habitat').val().toLowerCase();
        const nutrition = $('#filter-nutrition').val().toLowerCase();
        const state = $('#filter-state').val().toLowerCase();
        const name = $('#filter-name').val().toLowerCase();
        
        $('.intro__animal').each(function() {
            // Check if it should be visible based on filters
            const $article = $(this);
            const articleSpecie = $article.data('specie') || '';
            const articleHabitat = $article.data('habitat') || '';
            const articleNutrition = $article.data('nutrition') || '';
            const articleState = $article.data('state') || '';
            const articleName = $article.data('name') || '';
            
            let show = true;
            
            if (specie) {
                const specieMatch = articleSpecie.match(/\(([^)]+)\)/);
                const articleSpecieType = specieMatch ? specieMatch[1].toLowerCase().trim() : '';
                if (articleSpecieType !== specie.toLowerCase()) show = false;
            }
            if (show && habitat && articleHabitat.toLowerCase().indexOf(habitat) === -1) show = false;
            if (show && nutrition && articleNutrition.indexOf(nutrition) === -1) show = false;
            if (show && state && articleState.toLowerCase() !== state.toLowerCase()) show = false;
            if (show && name && articleName.indexOf(name) === -1) show = false;
            
            if (show) {
                visibleAnimals.push($article);
            }
        });
        
        return visibleAnimals;
    }

    // Apply filters on change
    $('#filter-specie, #filter-habitat, #filter-nutrition, #filter-state, #filter-name').on('change keyup', function() {
        applyFilters();
    });

    // Items per page change
    $('#filter-per-page').on('change', function() {
        currentPage = 1;
        itemsPerPage = parseInt($(this).val()) || 10;
        const visibleAnimals = getVisibleAnimals();
        showPage(visibleAnimals);
        updateURL(); // Update URL when items per page changes
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
        $('#filter-specie, #filter-habitat, #filter-nutrition, #filter-state, #filter-name').val('');
        $('#filter-per-page').val('10');
        currentPage = 1;
        itemsPerPage = 10;
        $('.intro__animal').show();
        const visibleAnimals = getVisibleAnimals();
        showPage(visibleAnimals);
        // Clear URL parameters on reset
        window.history.pushState({}, '', window.location.pathname);
    });

    // Restore filters from URL on page load
    restoreFiltersFromURL();

    // Initialize pagination on load
    const visibleAnimals = getVisibleAnimals();
    showPage(visibleAnimals);
});

