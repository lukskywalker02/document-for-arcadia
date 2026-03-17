// DataTables Configuration for Health Reports
// Double check jQuery and DataTables are available
if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
    console.error('jQuery or DataTables not loaded!');
} else {
    const $ = jQuery;
    const table = $('#vreportsTable');
    
    if (table.length) {
        // Get existing DataTable instance or initialize
        let dataTable;
        if ($.fn.DataTable.isDataTable('#vreportsTable')) {
            // Get existing instance
            dataTable = table.DataTable();
            // Reorder by ID if not already ordered
            dataTable.order([0, 'desc']).draw();
            console.log('Using existing DataTable instance');
        } else {
            // Initialize new instance
            dataTable = table.DataTable({
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                responsive: true,
                order: [[5, "desc"]], // Order by Review Date descending (most recent first)
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [1, 8] }, // Image and Actions columns not sortable
                    { type: 'num', targets: [0] } // ID column should be sorted as numbers (uses data-order attribute)
                ]
            });
            console.log('DataTables initialized for health reports');
        }
    }
}