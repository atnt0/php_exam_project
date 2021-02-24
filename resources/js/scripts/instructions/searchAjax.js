let matchQueryLocation = '/instructions';
// if( window.location.pathname.substr(0, matchQueryLocation.length) == matchQueryLocation ){
if( window.location.pathname == matchQueryLocation ) {


    $(document).ready(function () {
        $('form[name="searchForm"]').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (data) {
                    $('table[data-table="insert_here"] tbody').empty().html(data);
                }
            });
        });
    });










}
