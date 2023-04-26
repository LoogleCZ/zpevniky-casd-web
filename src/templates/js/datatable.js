$(document).ready(function() {
    var table = $('#songs').DataTable({
        searchPanes: false,
        language: {
            "decimal":        "",
            "emptyTable":     "Nenalezen žádný záznam",
            "info":           "Zobrazuji od _START_ do _END_ z celkových _TOTAL_ zázanmů",
            "infoEmpty":      "Zobrazuji 0 záznamů",
            "infoFiltered":   "(vyfiltrováno z celkových _MAX_ záznamů)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Zobrazit _MENU_ záznamů",
            "loadingRecords": "Načítám...",
            "processing":     "",
            "search":         "Hledat:",
            "zeroRecords":    "Hledání neodpovídá žádný záznam",
            "paginate": {
                "first":      "První",
                "last":       "Poslední",
                "next":       "Následující",
                "previous":   "Předchozí"
            },
            "aria": {
                "sortAscending":  ": klikněte pro vzestupné řazení",
                "sortDescending": ": klikněte pro sestupné řazení"
            }
        }
    });
});
