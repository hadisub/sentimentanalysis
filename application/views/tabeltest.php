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
                            <th>Label Sentimen</th>
                            <th>P <em>Pos</em></th>
                            <th>P <em>Neg</em></th>
                            <th>Hasil Analisis</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!--End Advanced Tables -->
	<div class="col-md-12" id="confusion-matrix">
		<div class="alert alert-info">
			<table class="borderless">
				<th width="400"><strong>Akurasi Klasifikasi (Prediksi Benar/Total Prediksi)</strong></th>
				<th width="20">:</th>
				<th><span id="akurasi-percentage"></span></th>
			</table>
		</div>
		<div class="alert alert-info">
			<strong>Confusion Matrix Kelas Positif</strong>
		</div>
		<div class="alert alert-info">
			<strong>Confusion Matrix Kelas Negatif</strong>
		</div>
	</div>
</div>
