<style>
    #print-img{border: 1px solid #e0d7d7;}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Order Imos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <?= $table ?>
                    </div>
                    <div class="col-md-4" id="print-img">
                    </div>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Quick Example</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
    </section>
</div>
<script>
    $(function () {
        $("#table_order").DataTable();
    });

    function ListItems(name) {
        location.href = "<?= base_url() ?>Imos/Order/C_Order/ListItems/" + name;
    }
    
    function ShowImg(url){
        $("#print-img").html('<img src="'+url+'" class="" style="max-width: 100%;">');
    }
</script>