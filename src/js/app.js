document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".dataTable").forEach((table) => {
    new DataTable(table, {
      // very important, to save the auto redirecting to the last action made in the table (this case the activation or not of the user selected)
      stateSave: true,
      pageLength: 5,
      lengthMenu: [
        [3, 5, 7, 13, 15, 17, 23, 25, 27, 30, 50, 100],
        [3, 5, 7, 13, 15, 17, 23, 25, 27, 30, 50, 100],
      ],

      responsive: true,
      order: [[12, "desc"]],
      language: {
        decimal: "",
        emptyTable: "No data available in table",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "Show _MENU_ entries",
        loadingRecords: "Loading...",
        processing: "Processing...",
        search: "Search:",
        zeroRecords: "No matching records found",
        paginate: {
          first: "first",
          last: "Last",
          next: "Next",
          previous: "Previous",
        },
        aria: {
          sortAscending: ": activate to sort column ascending",
          sortDescending: ": activate to sort column descending",
        },
      },
    });
  });
});

// If the page is loaded from the cache (back button), reload it
window.onpageshow = function (event) {
  if (event.persisted) {
    window.location.reload();
  }
};
