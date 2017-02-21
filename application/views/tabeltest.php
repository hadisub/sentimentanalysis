<!--DATASET OVERVIEW-->
<div class="row">
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table borderless">
                <tbody>
                        <tr>
                          <td style="width:70%">Jumlah seluruh term di dataset:</td>
                          <td><?php echo number_format($total_terms,0,',','.')?></td>
                        </tr>
                        <tr>
                          <td>Jumlah term di review positif:</td>
                          <td><?php echo number_format($total_pos_terms,0,',','.')?></td>
                        </tr>
                        <tr>
                          <td>Jumlah term di review negatif:</td>
                          <td><?php echo number_format($total_neg_terms,0,',','.')?></td>
                        </tr>
                        <tr>
                          <td>Term yang paling sering muncul:</td>
                          <td>"<?php print_r($most_common_term)?>"</td>
                        </tr>
                        <tr>
                          <td>Test:</td>
                          <td><?php print_r($testing)?></td>
                        </tr>
                        <tr>
                          <td><h3><strong>AKURASI:</strong></h3></td>
                          <td><h3><strong>78%</strong></h3></td>
                        </tr>
                      </tbody>
            </table>
        </div>
    </div>
</div>

<!--TABEL DATA UJI -->
<div class="row">
    <div class="col-md-12">
    <!-- Advanced Tables -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="25%">Judul Review</th>
                            <th>Sentimen yg Ditentukan</th>
                            <th>Sentimen Setelah Analisis</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!--End Advanced Tables -->
</div>
