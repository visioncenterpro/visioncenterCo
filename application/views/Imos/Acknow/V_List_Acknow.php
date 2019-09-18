<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de  Acknowledgments</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?=$table?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            </div>
        </div>
    </section>
</div>
<script>
    $(function () {
        var table = $('#table_ack').DataTable( {
            scrollY: "550px",
            paging: false,
            fixedHeader: true,
            sScrollX: true,
            scrollCollapse: true,
            order: [[ 1, "desc" ]]
        });
    });
    
    function ShowDetailsAck(id){
        location.href = "<?= base_url() ?>Imos/Acknow/C_Acknow/ShowDetailsAck/" + id;
    }
</script>